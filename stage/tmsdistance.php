<?php
/*
	This class is responsible for the distance calculations.
*/

class tmsdistance {
		private $query;
		
		function __construct() {
				$this->query = new tmsconnector;
			}
			
		private function query_google($coor) {
				$key = $GLOBALS['config']['google_api_key'];
				$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $coor['origin']['lat'] . ',' . $coor['origin']['lon'] . '&destinations=' . $coor['destination']['lat'] . ',' . $coor['destination']['lon'] . '&mode=driving&sensor=false';//&key=' . $key;
				$get_dist = new tmsrestrequest($url);
				$get_dist->execute();
				$response = json_decode($get_dist->getResponseBody(),true);
				if($response['status'] == 'OK') {
						if($response['rows'][0]['elements'][0]['status'] == 'OK') {
								$insert_param = array(
										'into' => 'disttable',
										'fields' => array("lat_o","lon_o","lat_d","lon_d","distance","duration"),
										'values' => array(
											array( $coor['origin']['lat'], $coor['origin']['lon'], $coor['destination']['lat'], $coor['destination']['lon'], $response['rows'][0]['elements'][0]['distance']['value'], $response['rows'][0]['elements'][0]['duration']['value'])
											),
									);
								$this->query->insert($insert_param);
								return array( array('distance' => (string) $response['rows'][0]['elements'][0]['distance']['value'], 'duration' => (string) $response['rows'][0]['elements'][0]['duration']['value']));
							} else {
									throw new Exception('Google responded with the Error' . $response['rows'][0]['elements'][0]['status'] . ' - tmsdistance.php');
								}
					} else {
							throw new Exception('Google responded with the Error' . $response['status'] . ' - tmsdistance.php');
						}
			}
		
		private function exists_local($coor) {
				$param = array(
					'Fields' => array('distance','duration'),
					'Tables' => array('disttable'),
					'Logic' => array(
						'logical_op' => array('AND','AND','AND'),
						'cond' => array(
							 array( 'col' => 'lat_o', 'op' => '=', 'val' => $coor['origin']['lat'], ),
							 array( 'col' => 'lon_o', 'op' => '=', 'val' => $coor['origin']['lon'], ),
							 array( 'col' => 'lat_d', 'op' => '=', 'val' => $coor['destination']['lat'], ),
							 array( 'col' => 'lon_d', 'op' => '=', 'val' => $coor['destination']['lon'], ),
						),
					),
				);
				
				$result = $this->query->select($param);
				if(count($result)==0) {
						return false;
					} else {
							return $result;
						}
			}
	
		public function get_distance($coor) {
				if(!$result = $this->exists_local($coor)) {
						return $this->query_google($coor);
					} else {
							return $result;
						}
			}
	
	}

?>