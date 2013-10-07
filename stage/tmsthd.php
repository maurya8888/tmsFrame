<?php
/*
	This class is responsible for the roster generation.
*/

class tmsthd {
		public static function generate($data,&$ret) {
				//var_dump($data); echo '<br/>';
				$date = $data[0];
				$table = $data[1] . $data[2];
				$query = new tmsconnector;
				$param = array(
					'Fields' => array('*'),
					'Tables' => array('shifts'),
				);
				$shifts = $query->select($param);
				$param = array(
					'Fields' => array('*'),
					'Tables' => array('Zones'),
				);
				$zones = $query->select($param);
				foreach($shifts as $shift) {
						foreach($zones as $zone) {
								if(true) {//$shift['value'] == '1' && $zone['value'] == '10') {
										$param = array (
											'select' => array('*'),
											'from' => array('employeesz1'),
											'inner_join' => array($table),
											'on' => array('employeesz1.EmpID',$table.'.EmpID'),
											'Where' => array(
													'logical_op' => array('AND','AND'),
													'cond' => array(
														array('col' => $table.'.Date', 'op' => '=', 'val' => $date),
														array('col' => $table.'.ShiftID', 'op' => '=', 'val' => $shift['value']),
														array('col' => 'employeesz1.Zone', 'op' => '=', 'val' => $zone['value'])
													)
												)
										);
										$emp_list = $query->inner_join($param);
										if(count($emp_list)!=0) {
												$MAX_PICKUP = 5;
												$TIME_CAP = 1800;
												$mat = new tmsmatrix($emp_list);
												$routes = array();
												$routes['emp_list'] = $emp_list;
												while(count($mat->get_emp_list()) > 0) {
													$route = array();
													$initiate_from = $mat->farthest_from_depo();
													$active_emp = array_keys($initiate_from);
													if((int) $initiate_from[$active_emp[0]] == 0) {
															$route['guard_required'] = false;
															$route['route_count'] = 1;
														} else {
																$route['guard_required'] = true;
																$route['route_count'] = 2;
															}
													$route['route_time'] = 0;
													$route['time_from_last'] = $mat->duration_from_depo($active_emp[0]);
													$route[] = array( $active_emp[0] => "0");
													$mat->pop_key($active_emp[0]);
													while($route['route_count'] < $MAX_PICKUP) {
															if(!$temp = $mat->get_row_min($active_emp[0])) break;
															$emp_id = array_keys($temp);
															if((int) $temp[$emp_id[0]] + $route['route_time'] > $TIME_CAP) break;
															$route[] = $temp;
															$route['route_count']++;
															$route['route_time'] += (int) $temp[$emp_id[0]];
															$route['time_from_last'] = $mat->duration_from_depo($emp_id[0]);
															$active_emp[0] = $emp_id[0];
															$mat->pop_key($emp_id[0]);
														}
													$routes[] = $route;
												}
												//var_dump($routes);
												$roster[$shift['value']][$zone['value']] = $routes;
												//var_dump($routes);
											}
									}
							}
					}
				//var_dump($roster);	
				$ret['shifts'] = $shifts;
				$ret['zones'] = $zones;
				$ret['roster'] = $roster;
				return "roster";
			}
	}
?>