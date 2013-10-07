tmsFrame
========
<<<<<<< HEAD

beta

Under development frame work to be used in transport management system

========

config.php

Used to configure the settings the framework will be using

========

connector.php

This class is used to perform basic queries like select on the database specified in the config.php file

Methods
 ->select($param);
 
  Executes the Select Query based on the parameters sent as an array.
  Array is expected as parameter with the mandatory keys 'Fields','Tables' and optional 'Logic'
  'Fields' is expected to be an array of name of the fields to look for
  'Tables' is expected to be an array of name of the tables to run the query on
  'Logic' is expected to be an array with mandatory keys 'logical_op','cond'
  'logical_op' is expected to be an array with all the logical operators in the order they should apply to the conditions
  'cond' is expected to be an array with the mandatory keys 'col','op','val'
  Number of 'logical_op's should be one less than the number of 'cond'
  Example -> 
				$param = array(
				'Fields' => array('Name','ldap','avrsid'),
				'Tables' => array('Managers'),
				'Logic' => array(
					'logical_op' => array('OR','OR'),
					'cond' => array(
						array(
							'col' => 'avrsid',
							'op' => '=',
							'val' => '1',
						),
						array(
							'col' => 'avrsid',
							'op' => '=',
							'val' => '2',
						),
						array(
							'col' => 'avrsid',
							'op' => '=',
							'val' => '3',
						),
					),
				),
			);
			
========

tableinfo.php

Return the required information about all the tables in the specified database.
=======
>>>>>>> 998d393fceb90df4eabfef7e08d072d2b6ca6e97
