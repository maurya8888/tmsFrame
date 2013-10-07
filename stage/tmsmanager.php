<?php
/*
	This class is responsible for handling managers views.
*/

class tmsmanager {
		public static function update($data,&$ret) {
				$query = new tmsconnector;
				if(isset($data[3])) {
						$changes = json_decode($data[3]);
						//var_dump($changes);
						foreach($changes as $key => $value) {
								$temp = explode('-',$key);
								$set = $temp[0];
								$empid = $temp[1];
								$param = array(
									'Update' => array('employeesz1'),
									'Set' => array($set => $value),
									'Where' => array(
											'logical_op' => array(),
											'cond' => array(
												array('col' => 'EmpID', 'op' => '=', 'val' => $empid)
											)
										)
									);
								//var_dump($param);
								$query->update($param);
							}
					}
				$param = array(
					'Fields' => array('Name','EmpID'),
					'Tables' => array('employeesz1'),
					'Logic' => array(
						'logical_op' => array('OR'),
						'cond' => array(
							 array( 'col' => 'Manager', 'op' => '=', 'val' => $data[0], ),
							 array( 'col' => 'EmpID', 'op' => '=', 'val' => $data[1], ),
						),
					),
				);
				array_push($ret,$query -> select($param));
				$param = array(
					'Fields' => array('*'),
					'Tables' => array('Zones'),
				);
				array_push($ret,$query -> select($param));
				$param = array(
					'Fields' => array('*'),
					'Tables' => array('bu'),
				);
				array_push($ret,$query -> select($param));
				$param = array(
					'Fields' => array('*'),
					'Tables' => array('managers'),
				);
				array_push($ret,$query -> select($param));
				if(isset($data[2])) {
						$param = array(
								'Fields' => array('*'),
								'Tables' => array('employeesz1'),
								'Logic' => array(
									'logical_op' => array(),
									'cond' => array(
										 array( 'col' => 'EmpID', 'op' => '=', 'val' => str_replace("e","",$data[2]), ),
									),
								),
							);
						array_push($ret,$query -> select($param));
					}
				//var_dump($ret);
				return "update";
			}
		public static function save($data,&$ret) {
				$table_name = $data[1] . "y" . $data[0];
				$avrsid = $data[2];
				$shift_vals = json_decode($data[4]);
				$query = new tmsconnector;
				$insert_required = false;
				$insert_param = array(
					'into' => $table_name,
					'fields' => array("EmpID","ShiftID","Date","Attendance","ManagerID"),
					'values' => array(),
				);
				foreach($shift_vals as $key => $value) {
						$tmp = explode('-',$key);
						$date = str_replace("d","",$tmp[0]);
						$empid = str_replace("e","",$tmp[1]);
						$param = array(
							'Update' => array($table_name),
							'Set' => array("ShiftID" => $value),
							'Where' => array(
									'logical_op' => array('AND'),
									'cond' => array(
										array('col' => 'Date', 'op' => '=', 'val' => $date),
										array('col' => 'EmpID', 'op' => '=', 'val' => $empid)
									)
								)
							);
						if($query->update($param) == 0)  {
								$insert_required = true;
								$insert_param['values'][] = array($empid,$value,$date,"1",$avrsid);
							}
					}
				if($insert_required) {
						$query->insert($insert_param);
					}
				return self::listteam($data,$ret);
			}
	
		public static function listteam($data,&$ret) {
				$query = new tmsconnector;
				$tables = $query->get_table_names();
				$tables = array_flip($tables);
				if(!array_key_exists($data[1] . 'y' . $data[0],$tables )) {
						$param = array(
							'TableNames' => array($data[1] . 'y' . $data[0]),
							'Fields' => array(
								array(
									'Names' => array('EmpID','ShiftID','Date','Attendance','ManagerID'),
									'Types' => array('varchar','int','int','int','int'),
									'Lengths' => array(10,11,11,11,11),
									'NotNull' => array(true,true,true,true,true),
									'Defaults' => array(),
									'StorageEngine' => 'InnoDB',
									'DefaultCharset' => 'latin1'
								)
							)
						);
						$query->create($param);
					}
				$param = array(
					'Fields' => array('Name','EmpID'),
					'Tables' => array('employeesz1'),
					'Logic' => array(
						'logical_op' => array('OR'),
						'cond' => array(
							 array( 'col' => 'Manager', 'op' => '=', 'val' => $data[2], ),
							 array( 'col' => 'EmpID', 'op' => '=', 'val' => $data[3], ),
						),
					),
				);
				array_push($ret,$query -> select($param));
				$temp = array();				
				foreach($ret[1] as $value) {
					$param = array(
						'Fields' => array('ShiftID','Date'),
						'Tables' => array($data[1] . 'y' . $data[0]),
						'Logic' => array(
							'logical_op' => array(),
							'cond' => array(
								 array( 'col' => 'EmpID', 'op' => '=', 'val' => $value["EmpID"], ),
							),
						),
						'Add' => ' ORDER BY `Date` ASC'
					);
					$result = $query -> select($param);
					if(count($result) != 0) {
						$temp[$value["EmpID"]] = $result;
					}
				}
				array_push($ret,json_encode($temp));
				$param = array(
					'Fields' => array('*'),
					'Tables' => array('shifts'),
				);
				array_push($ret,$query -> select($param));
				//var_dump($ret);
				return 'listteam';
			}
	}
?>