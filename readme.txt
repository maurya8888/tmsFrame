Sample request for create ->
$param = array(
	'TableNames' => array($data[1] . 'y' . $data[0],'table2'),
	'Fields' => array(
		array(
			'Names' => array('EmpID','ShiftID','Date','Attendance','ManagerID'),
			'Types' => array('varchar','int','int','int','int'),
			'Lengths' => array(10,11,11,11,11),
			'NotNull' => array(true,true,true,true,true),
			'Defaults' => array(),
			'Primary' => '',
			'Unique' => '',
			'Key' => '',
			'StorageEngine' => 'InnoDB',
			'DefaultCharset' => 'latin1'
		),
		array(
			'Names' => array('one','two','three','four','five'),
			'Types' => array('varchar','int','int','int','int'),
			'Lengths' => array(10,11,11,11,11),
			'NotNull' => array(true,false,true,true,false),
			'Defaults' => array('12','NULL','','',''),
			'Primary' => 'one',
			'Unique' => 'two',
			'Key' => 'three',
			'StorageEngine' => 'InnoDB',
			'DefaultCharset' => 'latin1'
		)
	)
);
					  
Sample request for update ->
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
	
Sample request for insert ->
$insert_param = array(
		'into' => $table_name,
		'fields' => array("EmpID","ShiftID","Date","Attendance","ManagerID"),
		'values' => array(
			array("12345","1","3","1","10")
		),
	);