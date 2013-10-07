<?php
/*
	This class is responsible for the creating the Matrix.
*/

class tmsmatrix {
		private $matrix;
		private $e_list;
		private $dist_depo;
		
		function __construct($emp_list) {
				$this->matrix = array();
				$this->generate_matrix($emp_list);
			}
			
		public function duration_from_depo($k) {
				return $this->dist_depo[$k];
			}
			
		public function get_emp_list() {
				return $this->e_list;
			}
			
		public function farthest_from_depo() {
				//var_dump($this->dist_depo); echo '<br/><br/>';
				//var_dump($this->matrix); echo '<br/><br/>';
				$keys = array_keys($this->e_list);
				foreach($keys as $e) {
						if(isset($max)) {
								if((int) $this->dist_depo[$max] < (int) $this->dist_depo[$e]) {
										$max = $e;
									}
							} else {
									$max = $e;
								}
					}
				if(isset($max)) {
						return array($max => $this->e_list[$max]);
					} else {
							return false;
						}
			}
		
		public function pop_key($k) {
				$keys = array_keys($this->e_list);
				foreach($keys as $e) {
						if($e != $k) {
								$tmp[$e	] = $this->e_list[$e];
							}
					}
				if(isset($tmp)) {
						$this->e_list = $tmp;
					} else {
							$this->e_list = array();
						}
			}
		
		public function get_row_min($v) {
				$keys = array_keys($this->e_list);
				foreach($keys as $e) {
						if(array_key_exists($e,$this->matrix[$v])) {
								if(isset($min)) {
										if((int) $this->matrix[$v][$e] < (int) $this->matrix[$v][$min]) {
												$min = $e;
											}
									} else {
											$min = $e;
										}
							}
					}
				if(isset($min)) {
						return array($min => $this->matrix[$v][$min]);
					} else {
							return false;
						}
			}
			
		public function get_row_max($v) {
				$keys = array_keys($this->e_list);
				foreach($keys as $e) {
						if(array_key_exists($e,$this->matrix[$v])) {
								if(isset($max)) {
										if((int) $this->matrix[$v][$e] > (int) $this->matrix[$v][$max]) {
												$max = $e;
											}
									} else {
											$max = $e;
										}
							}
					}
				if(isset($max)) {
						return array($max => $this->matrix[$v][$max]);
					} else {
							return false;
						}
			}
		
		private function generate_matrix($emp_list) {
				$d_obj = new tmsdistance;
				foreach($emp_list as $row) {
						$this->e_list[$row['EmpID']] = $row['Female'];
						//"Lat": "28.534154", "Lon": "77.34615"
						$c = array(
							'origin' => array('lat' => $GLOBALS['config']['depo_lat'],'lon' => $GLOBALS['config']['depo_lon']),
							'destination' => array('lat' => $row['Lat'],'lon' => $row['Lon']),
						);
						$res = $d_obj->get_distance($c);
						$this->dist_depo[$row['EmpID']] = $res[0]['duration'];
						foreach($emp_list as $col) {
								if($row['EmpID'] == $col['EmpID']) {
										//$obj[$row['EmpID']][$col['EmpID']] = '-';
									} else {
											$c = array(
												'origin' => array('lat' => $row['Lat'],'lon' => $row['Lon']),
												'destination' => array('lat' => $col['Lat'],'lon' => $col['Lon']),
											);
											$res = $d_obj->get_distance($c);
											$obj[$row['EmpID']][$col['EmpID']] = $res[0]['duration'];
										}
							}
					}
				//var_dump($obj);
				if(isset($obj)) {
						$this->matrix = $obj;
					}
			}
	}
?>