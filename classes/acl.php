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

/**
 * Class acl
 */
class acl {
	
	// Validating user
	function validate_user() {
		if(isset($_REQUEST['user_name']) AND isset($_REQUEST['password']) AND !empty($_REQUEST['user_name']) AND !empty($_REQUEST['password']))  
		{
		    if($_REQUEST['user_name']==USERNAME AND $_REQUEST['password']==PASSWORD) 
		    {
		        $_SESSION['user_name'] = $_REQUEST['user_name'];
		    } 
		} 
	}
	
	// redirecting to login page
	function check_session() {
		if(!isset($_SESSION['user_name'])) 
		{
			$tpl= new tpl();
			$data = array(
				'html_header' => $tpl->html_header,
				'show_login'  => $tpl->show_login
				);
			echo $tpl->replace_vars($tpl->html_show_login,$data);
		    die();
		}
	}
	
	// closing the session
	function check_logout() {
		if($_REQUEST['action'] == 'logout') 
		{
			$_SESSION['user_name'] = NULL;
			header('location:'.$this_script);
			die();
		}
	}
	
}
?>