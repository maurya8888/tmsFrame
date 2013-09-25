<?php
/*
	This class is responsible for connecting to the directory and authenticating the user
*/

class tmsldap {
		private $ldap;
		private $bind;
		private $ldap_host;

		
		function __construct() {
				$this->ldap_host = $GLOBALS['config']['ldap_host'];
			}
			
		protected function is_ldap_connected() {
				if($this->ldap = ldap_connect($this->ldap_host)) {
						return true;
					} else {
							throw new Exception('Not able to connect to the ldap host - ldap.php');
						}
			}
			
		protected function is_ldap_bound($u,$p) {
			return true; //Comment out this line for the ldap authentication to occur.
				if($this->is_ldap_connected()) {
						ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
						if($this->bind = ldap_bind($this->ldap,'ADOBENET\\'.$u,$p)) {
								return true;
							} else {
									return false;
								}
					}
			}
	}
?>