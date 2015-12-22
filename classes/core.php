<?php
/**
 * Copyright (C) 2015-2016 masterguru.net
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 * 
 */

class core {
	/**
	 * Sends request to WHM server and returns its output
	 */
	function launch_request($header,$url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
		curl_setopt($curl, CURLOPT_URL, $url);
		  
		$result = curl_exec($curl);
		if ($result == false) {
		    error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
		}
		curl_close($curl);
		return $result;
	}
	
	/**
	 *  Validation tests
	 */
	function validate_key($key) {
		switch($key) {
			case 'username':
				/**
				 * Usernames must contain eight characters or less.
				 * As of cPanel & WHM version 11.40, usernames may contain 16 characters or less if database prefixes are disabled.
				 * Usernames cannot begin with a number, or the string test.	
				 */
				// check empty
				if(empty($_POST[$key])) {
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: username is empty';
				}
	
				 // check lengh under 16
				if(strlen($_POST[$key])>16) 
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: username is over 16 characters';
				// not start by a number or "test" string
				if(is_numeric(substr($_POST[$key],0,1)) OR strtolower(substr($_POST[$key],0,4))=='test')
				 	$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: username can not start by a number or "test"';
				 	
				// avoid strange characters
				if(!mb_check_encoding($_POST[$key],'ASCII'))
				 	$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: username can not use non-ASCII characters';
				break;
				
			case 'domain':
				// check empty
				if(empty($_POST[$key])) {
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: domain is empty';
				}
	
				// A valid domain name
				$again = 'http://' . $_POST[$key];
	
				// next line had missing point to allow subdomains like xx.domain.tld
	    		if (!preg_match('/^[-a-z0-9.]+\.[a-z]{2,6}$/', strtolower($_POST[$key])))
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: domain name not valid2';
	
	    		if(!filter_var ($again, FILTER_VALIDATE_URL)) 
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: domain name not valid';
				break;
			
			case 'quota':
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0)
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: quota is not inside valid range: 0-999999';
				break;
			case 'password':
				if(empty($_POST[$key])) 
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: password is empty';
				break;
			case 'ip':
				if(isset($_POST[$key]) AND $_POST[$key]!=="y" AND $_POST[$key]!=="n")
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: Dedicated ip is not valid. Only "y" or "n" are valid values.';
				break;
			case 'cgi':
				if(isset($_POST[$key]) AND $_POST[$key]!=="1" AND $_POST[$key]!=="0")
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid. Only "0" or "1" are valid values.';
				break;
			case 'frontpage':
				if(isset($_POST[$key]) AND $_POST[$key]!=="1" AND $_POST[$key]!=="0")
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid. Only "0" or "1" are valid values.';
				break;
			case 'hasshell':
				if(isset($_POST[$key]) AND $_POST[$key]!=="1" AND $_POST[$key]!=="0")
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid. Only "0" or "1" are valid values.';
				break;
			case 'contactemail':
				if(isset($_POST[$key]) AND !empty($_POST[$key]) AND !filter_var($_POST[$key], FILTER_VALIDATE_EMAIL))			
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid email address.';
				break;
			case 'cpmod':
				// TODO: check value with list of names of cpmods...
				break;
			case 'maxftp':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'maxsql':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'maxpop':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'maxlst':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'maxsub':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'maxpark':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'maxaddon':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'bwlimit':
				//     A positive integer between one and 999,999.    0, unlimited, or null — The account has unlimited FTP accounts.
				if(!is_numeric($_POST[$key]) OR $_POST[$key]>999999 OR $_POST[$key]<0) 
					if($_POST[$key]!=="unlimited" AND !is_null($_POST[$key]))
						$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not a valid value for this field.';
				break;
			case 'customip':
				// TODO: A valid IP address.
				break;
			case 'language':
				// TODO: A two-letter ISO-3166 code.
				break;
			case 'useregns':
				if(isset($_POST[$key]) AND !empty($_POST[$key]))
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid (0/1)';
				break;
			case 'hasuseregns':
				if(isset($_POST[$key]) AND $_POST[$key]!==1)
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid (1)';
				break;			
			case 'reseller':
				if(isset($_POST[$key]) AND !empty($_POST[$key]))
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid (0/1)';
				break;
			case 'forcedns':
				if(isset($_POST[$key]) AND !empty($_POST[$key]))
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid (0/1)';
				break;
			case 'mxcheck':
				$valid_values = array('local','secondary','remote','auto');
				if(isset($_POST[$key]) AND !in_array($_POST[$key],$valid_values))
	    			$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
				break;
			case 'MAX_EMAIL_PER_HOUR':
				//     A positive integer.    0 or unlimited — The account can send an unlimited number of emails.
				if(isset($_POST[$key]) AND $_POST[$key]!=='unlimited' AND $_POST[$key]!=='0') {
					if(!is_numeric($_POST[$key])) {
							$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
					} else {
						if($_POST[$key]<0)
							$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
					}
					
				}
				break;
			case 'MAX_DEFER_FAIL_PERCENTAGE':
				//     A positive integer.    0 or unlimited — The account can send an unlimited number of emails.
				if(isset($_POST[$key]) AND $_POST[$key]!=='unlimited' AND $_POST[$key]!=='0') {
					if(!is_numeric($_POST[$key])) {
							$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
					} else {
						if($_POST[$key]<0)
							$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
					}
				}
				break;
			case 'uid':
				if(isset($_POST[$key]) AND !is_integer($_POST[$key]))
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
				break;
			case 'gid':
				if(isset($_POST[$key]) AND !is_integer($_POST[$key]))
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
				break;
			case 'homedir':
				// TODO: The account's home directory. If you do not specify a value, the system uses the /home/user directory, where user is the account's username. The absolute path to a location on the server.
				break;
			case 'dkim':
				if(isset($_POST[$key]) AND !empty($_POST[$key]))
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
				break;
			case 'spf':
				if(isset($_POST[$key]) AND !empty($_POST[$key]))
					$GLOBALS['keys'][$key] = $GLOBALS['errors'][] = $key.': Error: '.$key.' value is not valid';
				break;
			case 'owner':
				// TODO: root    A valid reseller account username on the server.
				break;
				
			default:
				break;
		}
	}
	
	/**
	 * Returns css style for errors
	 */
	function has_errors($key){
		if(isset($GLOBALS['keys'][$key]) AND count($GLOBALS['keys'][$key]>0))
			return 'has-error';  // css style
		return;
	}
	
	/**
	 * Returns servers select
	 */
	function get_select_servers($servers) {
		$tpl = new tpl();
		$options = '';
		foreach($servers as $idserver=>$_null) {
			$selected = ($idserver==$_GET['serverid'])?' selected="selected" ':'';
			$options .= '<option value="'.$idserver.'" '.$selected.'>'.$idserver.'</option>';
		}
		$data = array(
			'options' => $options
			);
		return $tpl->render($tpl->html_select_servers_short,$data);				
		//	$data['html_select_servers_short'] = render($tpl->html_select_servers_short,$data);		
		//	return render($tpl->html_select_servers, $data);
	}

	/**
	 * 
	 */
	function WHM_API_string($fields) {
	
		$query_string = '';
	
		// Create forms[] array with output grouped. Loop array['description'] to generate query_string and forms array
		foreach($fields['descriptions'] as $key=>$value) {
	
			// creating the query string for WHM API
			if(!isset($_POST[$key])) {
		
				if($fields['types'][$key]=='boolean') {
					$fields['defaults'][$key] = 0;
				}
		
				// if key is in array of overwritten parameters by a plan
				if(in_array($key,$fields['overplan'])) {
					// if there is not a valid plan use defaults in manual plan
					if(!isset($_POST['plan']) OR empty($_POST['plan']) OR $_POST['plan']=="manual") 
						$query_string .= '&'.$key.'='.urlencode($fields['defaults'][$key]);
		
				} else {
					// any other key
					$query_string .= '&'.$key.'='.urlencode($fields['defaults'][$key]);
				}
		
			} else {
				
				// check passed values
				$_null = $this->validate_key($key);
		
				// if key is in array of overwritten parameters by a plan
				if(in_array($key,$fields['overplan'])) {
					// if there is not a valid plan
					if(!isset($_POST['plan']) OR empty($_POST['plan']) OR $_POST['plan']=="manual") {
						$query_string .= '&'.$key.'='.urlencode($_POST[$key]);
					}
				} else {
		
		
					if($fields['types'][$key]=='boolean') {
						$_POST[$key] = 1;
					}
	
					// any other key
					$query_string .= '&'.$key.'='.urlencode($_POST[$key]);
					if($key=='useregns' AND $_POST[$key]=='1') {
						$query_string .= '&hasuseregns=1';
					}
				}
			}
		}
		return $query_string;
	}
	
	/**
	 * 
	 */
	function get_errors() {
		$msgs_error = '';
		if(isset($GLOBALS['errors']) AND count($GLOBALS['errors'])>0) {
			foreach($GLOBALS['errors'] as $msg) {
			  $msgs_error .= '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
			}
		}
		return $msgs_error;
	}
	
	/**
	 * 
	 */
	function check_required($fields) {
		$check_required = 0;
		foreach($fields['required'] as $freq) {
			if(!isset($_POST[$freq])) { //  AND !empty($_POST[$freq])) {
				$check_required=1;
				break;
			}
		}
		return $check_required;
	}
}
?>