<?php
/*
	This class is responsible for the http-authentication of the user.
*/

class tmsauth extends tmsldap {
		private $username;
		private $password;
		public $user_info;
		
		function __construct() {
				parent::__construct();
			}
		
		private function is_authenticated() {
				if($this->is_ldap_bound($this->username,$this->password)) {
						return true;
					} else {
							return false;
						}
			}
			
		private function request_authentication () {
				header('WWW-Authenticate: Basic realm="Managers Portal"');
    			header('HTTP/1.0 401 Unauthorized');
				echo 'Text to send if user hits Cancel button';
    			exit;
    			//return 'Name of the view if the user hits cancel.';
			}
			
		private function is_token_sent() {
				if(isset($_SERVER['PHP_AUTH_USER'])) {
						return true;
					} else {
							return false;
						}
			}
			
		public function get_user_info() {
				return $this->user_info;
			}
		
		public function get_auth_hierarchy() {
				if($this->is_token_sent()) {
						$this->username = $_SERVER['PHP_AUTH_USER'];
						$this->password = $_SERVER['PHP_AUTH_PW'];
						if($this->is_authenticated()) {
								$query = new tmsConnector;
								$tables = array('managers','superusers','transport');
								foreach($tables as $tbl_name) {
										$param = array(
												'Fields' => array('*'),
												'Tables' => array($tbl_name),
												'Logic' => array(
													'logical_op' => array(),
													'cond' => array(
														 array( 'col' => 'ldap', 'op' => '=', 'val' => $this->username, ),
													),
												),
											);
										$result = $query -> select($param);
										if(count($result) != 0) {
												$result[0]['employeenumber'] = $this->employee_number;
												$this->user_info = $result;
												break;
											}
									}
								if(count($this->user_info)!=0) {
										return 'tms'.$tbl_name;
									} else {
											return false;
										}
									
							} else {
									echo 'Not authenticated !';
									exit;
								}
					} else {
							$this->request_authentication();
						}
			}
	}

?>