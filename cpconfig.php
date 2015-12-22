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

define('USERNAME','');  //ie: username for this script login
define('PASSWORD','');  // ie: password for this script login
define('MAILSERVER',''); // ie: info@mydomain.com, email used as FROM, REPLY-TO and RETURN-PATH headers to send mails to clients
define('BCCMAILSERVER','');  // ie: newaccounts@mydomain.com, email used to send BCC mails. Used as control only.
define('SUBJECTMAIL','Welcome! Your New Hosting Account is ready!');  // Email subject for clients.

// path and filename values
define('ROOT_PATH','');  // ie: http://www.mywebsite.com/cpmanager  
define('THIS_SCRIPT','cpmanager.php');  // ie: cpmanager.php
define('SCRIPT_PATH',ROOT_PATH."/".THIS_SCRIPT);

// servers array
$servers = array(
	'hostname1' => array(
		'whmuser' 	=> 'root',
		'ip_server' 	=> 'xxx.xxx.xxx.xxx',
		'server'		=> 'https://xxx.xxx.xxx.xxx:2087',
		'hash'			=> 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa5e8516e75a3a89dafe1333cdfb6b3b53589a0925c79725d993fe2624322f1d9e87cd759b9572f8f9082342f61ca1e8bd4bfca33be1c63d674db9fbcc4e54f7fed4e988a5740c647acb507352c8d87bdffffffffffffffffffdffffffffffffsdffffffffffffffffd4dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd0aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa5e8516e75a3a89dafe1333cdfb6b3b53589a0925c79725d993fe2624322f1d9e87cd759b9572f8f9082342f61ca1e8bd4bfca33be1c63d674db9fbcc4e54f7fed4e988a5740c647acb507352c8d87bdffffffffffffffffffdffffffffffffsdffffffffffffffffd4ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd',
		),
	'hostname2' => array(
		'whmuser' 	=> 'root',
		'ip_server' 	=> 'xxx.xxx.xxx.xxx',
		'server'		=> 'https://xxx.xxx.xxx.xxx:2087',
		'hash'			=> 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa5e8516e75a3a89dafe1333cdfb6b3b53589a0925c79725d993fe2624322f1d9e87cd759b9572f8f9082342f61ca1e8bd4bfca33be1c63d674db9fbcc4e54f7fed4e988a5740c647acb507352c8d87bdffffffffffffffffffdffffffffffffsdffffffffffffffffd4dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd0aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa5e8516e75a3a89dafe1333cdfb6b3b53589a0925c79725d993fe2624322f1d9e87cd759b9572f8f9082342f61ca1e8bd4bfca33be1c63d674db9fbcc4e54f7fed4e988a5740c647acb507352c8d87bdffffffffffffffffffdffffffffffffsdffffffffffffffffd4ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd',
		),
	);

?>