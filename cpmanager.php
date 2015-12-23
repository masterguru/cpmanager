<?php
/**
 * cpmanager.php 
 *
 * Script to create cpanel accounts and to send new account creation emails to clients
 *
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
 
 /**
 * Installation:
 * 1 - Copy this file, cpconfig.php and classes/ folder in a public folder 
 * 2 - Edit cpconfig.php and set correct values for your servers and user
 * 3 - Open this file with your browser
 */

include('cpconfig.php');   // Edit this file to set the configuration
include('classes/tpl.php');
include('classes/acl.php');
include('classes/fields.php');
include('classes/core.php');
include('classes/history.php');

// start session
session_start();

// check user
$acl = new acl();
$acl->validate_user();
$acl->check_session();
$acl->check_logout();

// core functions
$core = new core();

// general tpl class
$tpl = new tpl();

// Setting credentials for curl commands
if(isset($_GET['serverid']) AND !empty($_GET['serverid'])) {

	$whmuser 	= $servers[$_GET['serverid']]['whmuser'];
	$ip_server 	= $servers[$_GET['serverid']]['ip_server'];
	$server 	= $servers[$_GET['serverid']]['server'];
	$hash 		= $servers[$_GET['serverid']]['hash'];

} else {

	if(!isset($_POST['ajax'])) 
	{
		// redirecting to the single alone server if exists
		if(count($servers) == 1 AND $_GET['serverid'] !== key($servers) ) 
		{
			header('location:'.THIS_SCRIPT.'?serverid='.key($servers));
			die();		
		} 
			else 
		{
			$data = array(
				'select_servers' 	=> $core->get_select_servers($servers),
				'html_header' 		=> $tpl->html_header,
				'html_navbar' 		=> $tpl->render($tpl->html_navbar, $data)
				);
	
			// show only select servers
			echo $tpl->render($tpl->html_minimal_select, $data);
			die();
		}
	} 
		else 
	{
		$whmuser 	= $servers[$_POST['serverid']]['whmuser'];
		$ip_server 	= $servers[$_POST['serverid']]['ip_server'];
		$server 	= $servers[$_POST['serverid']]['server'];
		$hash 		= $servers[$_POST['serverid']]['hash'];
	}
}

// settting common header
$header[0] = "Authorization: WHM $whmuser:" . preg_replace("'(\r|\n)'","",$hash);

// Ajax actions: 
if(isset($_POST['ajax'])) {
	switch($_POST['action']) {
		case 'plan':
			// Setting new array['defaults'] replacing the current with new selected plan values 
			if(isset($_POST['plan'])) {
				if($_POST['plan']!== "manual") 
					$readonly = ' readonly="readonly" ' ;
				$url = $server."/json-api/listpkgs?api.version=1";
				$pkgs = json_decode($core->launch_request($header,$url));
				foreach($pkgs->data->pkg as $pkg) {
					if($pkg->name==$_POST['plan']) {
						$_null = get_object_vars($pkg);
						foreach($_null as $ki=>$lk) {
							$fields['defaults'][strtolower($ki)] = $lk;
						}
						break;
					}
				}
			}
			break;
		case 'destination_email':
			if(isset($_POST['destination_email'])) {
		
				if(!empty($_POST['destination_email']) AND filter_var($_POST['destination_email'], FILTER_VALIDATE_EMAIL))			
				{ 
					$headers = 'From: '.MAILSERVER. "\r\n" .
					    'Reply-To: '.MAILSERVER. "\r\n" .
					    'Bcc: '.BCCMAILSERVER. "\r\n" .
					    'X-Mailer: PHP/' . phpversion();
					$message = $_POST['email_content'];
					$to = $_POST['destination_email'];
					$subject = SUBJECTMAIL;
					if(mail($to,$subject,$message,$headers,"-f".MAILSERVER)) {
						$data_mail = array(
							'serverid' 	=> $_POST['serverid'],
							'item_id' 	=> $_POST['item_id'],
							'time'		=> time(),
							'subject' 	=> $subject,
							'to'		=> $to,
							'message' 	=> $message
							);
						$rawlog = file_get_contents('createacct_log');
						$records = json_decode($rawlog);
						$records[$_POST['item_id']]->data_mail = NULL;				
						$records[$_POST['item_id']]->data_mail = $data_mail;
						$rawlog = json_encode($records);
						file_put_contents('createacct_log',$rawlog);

						echo "Email sent succesfully!";
					} else {
						echo "Something was wrong!";
					}
				} else {
					echo "Email not valid!";
				}
				die();
			}
			break;
		case 'open_tabs':
			if(isset($_POST['open_tabs'])) {
				$history = new history();
				$rawlog = file_get_contents('createacct_log');
				$records = array_reverse(json_decode($rawlog),true);
				$reg[0] = $_POST['item_id'];
				$tabs = array(
					'email_template' 			=> '',
					'result_data' 				=> '',
					'server_info' 				=> '',
					'request_info' 				=> '',
					'env_info' 					=> '',
					'result_metadata_output' 	=> '',
					'cookie_info' 				=> '',
					'query_string' 				=> '',
					);
				foreach($tabs as $tab=>$_null) {
					$reg[1] = $tab;
					$data[$tab] = $history->switch_log($reg,$records);
				}
				$tpl = new tpl();
				echo $tpl->render($tpl->html_tabs_history, $data);
				die();
			}
			break;
		case 'delete_history_item':
			if(isset($_POST['delete_history_item'])) {
				$history=new history();
				$history->delete_history_item();
			}		
			break;
		case 'textarea_email_template':
			if(isset($_POST['textarea_email_template'])) {
				$rawlog = file_get_contents('createacct_log');
				$records = json_decode($rawlog);
				$records[$_POST['mail_id']]->email_template = $_POST['textarea_email_template'];
				$rawlog = json_encode($records);
				file_put_contents('createacct_log',$rawlog);
				echo $_POST['textarea_email_template'];
				die();
			}
			break;			
		default:
			break;
	}

}

$query_string = $core->WHM_API_string($fields);

$form = array();

// Create forms[] array with output grouped. Loop array['description'] to generate query_string and forms array
foreach($fields['descriptions'] as $key=>$value) {

	$tabset = 'NOT ASSIGNED!';
	// Search assigned group
	foreach($tabs as $tabname=>$tabarray) {
		if(in_array($key,$tabarray)) {
			$tabset = $tabname;
			break;
		}
	}

	// if field is inside required array values set html code
	$required = ''; // (in_array($key,$fields['required']))?' required="required" ':'';

	// analize each possible field to group output in form array
	switch($key) {

		case 'mxcheck':
			$values = array('local','secondary','remote','auto');
			foreach($values as $opt){
				$selected = ($opt==$fields['defaults'][$key])? ' selected="selected" ':'';
				$list_mxchecks .= '<option value="'.$opt.'" '.$selected.'>'.$opt.'</option>';
			}
			$data = array(
				'title' 			=> $fields['values'][$key],
				'key'				=> $key,
				'value'				=> $value,
				'list' 				=> $list_mxchecks,
				'first_opt_value' 	=> '',
				'first_opt_text' 	=> '',
				'readonly' 			=> $readonly,
				'codeerror' 		=> $core->has_errors($key),
				);
			$form[$tabset] .= $tpl->render($tpl->html_tpl_select, $data);
			break;

		case 'language':
			// seems there is no way to get the list of languages in the WHM, so forcing it to en. Users could change it later.
			$form[$tabset] .= '<input type="hidden" name="'.$key.'" id="'.$key.'" value="en">';
			break;			

		case 'cpmod':
			// calc a valid user
			$url = $server.'/json-api/listaccts?api.version=1';
			$obj = json_decode($core->launch_request($header,$url));
			$valid_cpanel_user = '';
			foreach($obj->data->acct as $_null=>$obj2) {
				$valid_cpanel_user = $obj2->user;
				break;  // only the first one is needed. A valid one
			}

			if($valid_cpanel_user == '') {
				// forcing to x3 due first user
				$list_cpmods = '<option value="x3">x3</option>'; 
			} else {
				// generate list of cpanel themes
				$url = $server.'/json-api/cpanel?cpanel_jsonapi_user='.$valid_cpanel_user.'&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Themes&cpanel_jsonapi_func=get_available_themes';
				$obj = json_decode($core->launch_request($header,$url));
				foreach($obj->cpanelresult->data as $id_featurelist=>$name_featurelist) {
					if(urlencode($_POST[$key]) == urlencode($name_featurelist)) {
						$selected = ' selected="selected" ';
						$done = 1;
					} else {
						$selected = '';
						if($done!==1)
							$selected = ($name_featurelist==$fields['defaults'][$key])? ' selected="selected" ':'';
					}
					
					$list_cpmods .= '<option value="'.$name_featurelist.'" '.$selected.'>'.$name_featurelist.'</option>';
				}
			}

			$data = array(
				'title' 			=> $fields['values'][$key],
				'key'				=> $key,
				'value'				=> $value,
				'list' 				=> $list_cpmods,
				'first_opt_value' 	=> '',
				'first_opt_text' 	=> '(default system value)',
				'readonly' 			=> $readonly,
				'codeerror' 		=> $core->has_errors($key),
				);
			$form[$tabset] .= $tpl->render($tpl->html_tpl_select, $data);
			break;
			
		case 'ip':
			if($_POST['ip'] AND $_POST['ip'] == "y") $required_y=' checked="checked" ';
			if($_POST['ip'] AND $_POST['ip'] == "n") $required_n=' checked="checked" ';
			if(!$_POST['ip']) {
				$required_y = ($fields['defaults'][$key] == 'y')? ' checked="checked" ':'';
				$required_n = ($fields['defaults'][$key] == 'n')? ' checked="checked" ':'';
			}
			
			$data = array(
				'title' 		=> 'oudur'.$fields['values'][$key],
				'key'			=> $key,
				'value'			=> $value,
				'required_y' 	=> $required_y,
				'required_n' 	=> $required_n,
				'readonly' 		=> $readonly,
				'codeerror' 	=> $core->has_errors($key),
				);
			$form[$tabset] .= $tpl->render($tpl->html_tpl_radio, $data);
			break;

		case 'featurelist':
			$url = $server."/json-api/get_available_featurelists?api.version=1";
			$pkgs = json_decode($core->launch_request($header,$url));
			foreach($pkgs->data->available_featurelists as $id_featurelist=>$name_featurelist) {
				if(urlencode($_POST[$key]) == urlencode($name_featurelist)) {
					$selected = ' selected="selected" ';
					$done = 1;
				} else {
					$selected = '';
					if($done!==1)
						$selected = ($name_featurelist==$fields['defaults'][$key])? ' selected="selected" ':'';
				}
				$list_features .= '<option value="'.$name_featurelist.'" '.$selected.'>'.$name_featurelist.'</option>';
			}
			$data = array(
				'title' 			=> $fields['values'][$key],
				'key'				=> $key,
				'value'				=> $value,
				'list' 				=> $list_features,
				'first_opt_value' 	=> '',
				'first_opt_text' 	=> '',
				'readonly' 			=> $readonly,
				'codeerror' 		=> $core->has_errors($key),
				);
			$form[$tabset] .= $tpl->render($tpl->html_tpl_select, $data);
			break;
		
		case 'plan':
			$url = $server."/json-api/listpkgs?api.version=1";
			$pkgs = json_decode($core->launch_request($header,$url));
			foreach($pkgs->data->pkg as $pkg) {
				$selected = (isset($_POST[$key]) AND $_POST[$key]==$pkg->name)? ' selected="selected" ':'';
				$list_pkgs .= '<option value="'.$pkg->name.'" '.$selected.'>'.$pkg->name.'</option>';
			}
			$data = array(
				'title' 			=> $fields['values'][$key],
				'key'				=> $key,
				'value'				=> $value,
				'list' 				=> $list_pkgs,
				'first_opt_value' 	=> 'manual',
				'first_opt_text' 	=> 'Manual',
				'readonly' 			=> $readonly,
				'codeerror' 		=> $core->has_errors($key),
				);
			$form[$tabset] .= $tpl->render($tpl->html_tpl_select, $data);
			break;

		case 'password':
			$input_value =(isset($_POST[$key]))?$_POST[$key]:$fields['defaults'][$key];
			$data = array(
				'title' 		=> $fields['values'][$key],
				'key'			=> $key,
				'value'			=> $value,
				'input_value' 	=> $input_value,
				'required' 		=> $required,
				'readonly' 		=> $readonly,
				'codeerror' 	=> $core->has_errors($key),
				'extra_buttons' => $tpl->extra_buttons
			);
			$form[$tabset] .= $tpl->render($tpl->html_tpl_input, $data);
			break;					

		default:
	
			// lets separate boolean
			switch($fields['types'][$key]) {
	
				case 'boolean':
					$checked =(isset($_POST[$key]))? ' checked="checked" ':($fields['defaults'][$key] == 1)? ' checked="checked" ':'';
					$data = array(
						'title' 		=> $fields['values'][$key],
						'key'			=> $key,
						'value'			=> $value,
						'input_value' 	=> $fields['defaults'][$key],
						'required' 		=> $checked,
						'readonly' 		=> $readonly,
						'codeerror' 	=> $core->has_errors($key),
						);
					$form[$tabset] .= $tpl->render($tpl->html_tpl_checkbox, $data);
					break;
	
				default:
					$input_value =(isset($_POST[$key]))?$_POST[$key]:$fields['defaults'][$key];
					$data = array(
						'title' 		=> $fields['values'][$key],
						'key'			=> $key,
						'value'			=> $value,
						'input_value' 	=> $input_value,
						'required' 		=> $required,
						'readonly' 		=> $readonly,
						'codeerror' 	=> $core->has_errors($key),
						'extra_buttons' => ''
						);
					$form[$tabset] .= $tpl->render($tpl->html_tpl_input, $data);
					break;					
			}
		break;		
	}
}

// ajax plan change
if(isset($_POST['ajax']) AND isset($_POST['plan'])) {
 	echo $form['Manual'];
 	die();
}

// Set output array
$data = array(
	'information'	=> $form['Information'],
	'dns'			=> $form['DNS'],
	'mail' 			=> $form['Mail'],	
	'manual'		=> $form['Manual']
	);

// errors
$msgs_error = $core->get_errors();
$data['errors'] = (!empty($msgs_error))? $tpl->error_alert.$msgs_error:'';

if(empty($msgs_error) AND $core->check_required($fields)==0) {
	$result_action = json_decode($core->launch_request($header,$server.'/json-api/createacct?api.version=1&'.$query_string));
	if(isset($result_action->metadata->reason) AND $result_action->metadata->result!==1 AND $result_action->metadata->reason !== "Account Creation Ok") {
		$data['errors'] .= '<div class="alert alert-danger">'.$result_action->metadata->reason.'</div>';		
	} else {
		// succesfully created
		$data['errors'] .= '<div class="alert alert-info">'.$result_action->metadata->reason.'</div>';		

		// save all data in log
		date_default_timezone_set('UTC');
		
		$data_email = array(
			'domain' 			=> $_REQUEST['domain'],
			'cpanel_account'	=> $_REQUEST['username'],
			'cpanel_password'	=> $_REQUEST['password'],
			'client_id' 		=> 'xxx',
			'hosting_package'   => $_REQUEST['plan']
			);
			
		$email_template = $tpl->render($tpl->email_plain_text, $data_email);

		$to_save = array(
			'query_string'  	=> $query_string,
			'result'			=> $result_action,
			'time_creation'		=> time(),
			'date_creation'		=> date("Y-m-d H:i:s"),
			'server_info'		=> $_SERVER,
			'request_info'		=> $_REQUEST,
			'cookie_info'		=> $_COOKIE,
			'env_info'			=> $_ENV,
			'email_template'	=> $email_template
		);

		// get current log 
		if (file_exists('createacct_log')) {
		    $rawlog = file_get_contents('createacct_log');
		} else {
		    file_put_contents('createacct_log', json_encode(array()));
		    $rawlog = file_get_contents('createacct_log');
		}
		
		$records 	= json_decode($rawlog);
		$records[] 	= $to_save;
		$rawlog		= json_encode($records);
		file_put_contents('createacct_log',$rawlog);
	}
}

if(file_exists('createacct_log')) {
	// read current log
	$rawlog 			= file_get_contents('createacct_log');
	$records 			= array_reverse(json_decode($rawlog),true);
	$history 			= new history();
	$data['history'] 	= $history->show_history($records);
} else {
	$data['history'] 	= '<div class="alert alert-info">Nothing recorded yet!.</div>';
}

$data['script_path'] 	= SCRIPT_PATH;
$data['select_servers'] = $core->get_select_servers($servers);
$data['serverid'] 		= $_REQUEST['serverid'];
$data['root_path'] 		= ROOT_PATH;
$data['html_navbar'] 	= $tpl->render($tpl->html_navbar, $data);

echo $tpl->render($tpl->html_header, $data).$tpl->render($tpl->html_tpl_main, $data);

exit();
?>