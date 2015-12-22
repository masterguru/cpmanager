<?php
// list of fields overwriten by a selected plan (as shown in listpkgs)
$fields['overplan'] = array(
	'featurelist',
    'quota',
    'maxaddon',
    'maxsub',
	'MAX_DEFER_FAIL_PERCENTAGE',  	// 'max_defer_fail_percentage',
    'cgi',
    '_package_extensions',
	'hasshell',
	'digestauth',
    'lang',
	'MAX_EMAIL_PER_HOUR', 			// 'max_email_per_hour',
    'maxftp', 						// 'max_ftp',
    'cpmod',
    'name',
    'maxlst',
    'maxpark',
    'bwlimit',
    'frontpage',
    'ip',
    'maxsql',
    'maxpop');

// Fields name descriptions
$fields['descriptions'] = array(
    'username'  => 'User name',
    'domain' => 'Domain',  
    'password' => 'Password',
    'contactemail'=>'Contact email',
    'plan' => 'Plan (package)',
    'featurelist' => 'Feature List',
    'cpmod'=>'CP Theme',
    'quota'=> 'Quota',
    'ip'=>'Dedicated IP',
    'cgi'=>'CGI Support',
    'hasshell'=>'Shell',
    'cpmod'=>'CP Theme',
    'maxftp'=>'Max FTP',
    'maxsql'=>'Max SQL',
    'maxpop'=>'Max POP',
    'maxlst'=>'Max Maillist', 
    'maxsub'=>'Max Subdomains', 
    'maxpark'=>'Max Park',
    'maxaddon'=>'Max Addon',
    'bwlimit'=>'Bandwitch Limit',
    'language'=>'Language',
    'useregns'=>'Use Registered Nameservers', 
    // 'hasuseregns'=>'Has Registered Nameservers',
    'reseller'=>'Reseller',   
    'forcedns'=>'Force DNS',   
    'mxcheck'=>'MX Check',
    'MAX_EMAIL_PER_HOUR'=>'Max Email per Hour',
    'MAX_DEFER_FAIL_PERCENTAGE'=>'Max Defer Fail Percentage',
    'dkim' => 'DKIM',
    'spf' => 'SPF'
);

// Fields types
$fields['types'] = array(
	'username' => 'string',	
	'domain' => 'string',
	'plan' => 'string',
	'pkgname' => 'string',
	'savepkg' => 'boolean',
	'featurelist' => 'string',
	'quota' => 'integer',
	'password' => 'string',
	'ip' => 'string',
	'cgi' => 'boolean',
	'frontpage' => 'boolean',
	'hasshell' => 'boolean',
	'contactemail' => 'string',
	'cpmod' => 'string',
	'maxftp' => 'string',
	'maxsql' => 'string',
	'maxpop' => 'string',
	'maxlst' => 'string',
	'maxsub' => 'string',
	'maxpark' => 'string',
	'maxaddon' => 'string',
	'bwlimit' => 'string',	
	'customip' => 'string',
	'language' => 'string',
	'useregns' => 'boolean',
	'hasuseregns' => 'boolean',
	'reseller' => 'boolean',
	'forcedns' => 'boolean',
	'mxcheck' => 'string',
	'MAX_EMAIL_PER_HOUR' => 'integer',
	'MAX_DEFER_FAIL_PERCENTAGE' => 'integer',
	'uid' => 'integer',
	'gid' => 'integer',
	'homedir' => 'string',
	'dkim' => 'boolean',
	'spf' => 'boolean'
);

// Fields possible values
$fields['values'] = array(
	'username' => 'A valid cPanel username.',	
	'domain' => 'A valid domain name.',
	'plan' => 'A hosting plan (package) name on the server.',
	'pkgname' => 'A new valid plan (package) name.',  // not used
	'savepkg' => '0-save, 1-no save', // not used
	'featurelist' => 'A valid feature list name on the server.',
	'quota' => '0=unlimited, Values=1-999999MB',
	'password' => 'A secure password.',
	'ip' => 'y=dedicated ip, n=non-dedicated ip',
	'cgi' => '1-Enabled,0-Disabled',
	'frontpage' => '1-Enabled,0-Disabled',
	'hasshell' => '1-Enabled,0-Disabled',
	'contactemail' => 'A valid email address.',
	'cpmod' => 'The account\'s cPanel theme.',
	'maxftp' => '0, unlimited, or null - The account has unlimited FTP accounts. Values=1-999999',
	'maxsql' => 'A positive integer between one and 999,999.  0, unlimited, or null - The account has unlimited databases.',
	'maxpop' => 'A positive integer between one and 999,999. 0, unlimited, or null - The account has unlimited email accounts.',
	'maxlst' => '0, unlimited, or null - The account has unlimited mailing list. Values=1-999999',
	'maxsub' => '0, unlimited, or null - The account has unlimited subdomains. Values=1-999999',
	'maxpark' => '0, unlimited, or null - The account has unlimited parked domains. Values=1-999999',
	'maxaddon' => '0, unlimited, or null - The account has unlimited addon domains. Values=1-999999',
	'bwlimit' => '0, unlimited, or null - The account has unlimited bandwidth. Values=1-999999 MB',	
	'customip' => 'A valid IP address.',
	'language' => 'A two-letter ISO-3166 code.',
	'useregns' => '1-Enabled,0-Disabled',
	'hasuseregns' => '1-Enabled,0-Disabled',
	'reseller' => '1-Enabled,0-Disabled',
	'forcedns' => '1-Enabled,0-Disabled',
	'mxcheck' => 'local/secondary/remote/auto',
	'MAX_EMAIL_PER_HOUR' => 'A positive integer. 0 or unlimited - The account can send an unlimited number of emails.',
	'MAX_DEFER_FAIL_PERCENTAGE' => 'A positive integer. 0 or unlimited - The account can send an unlimited number of failed or deferred messages.',
	'uid' => 'A positive integer that is not already associated with disk usage, and that does not already exist on the server.',
	'gid' => 'A positive integer that is not already associated with disk usage, and that does not already exist on the server.',
	'homedir' => 'The absolute path to a location on the server.',
	'dkim' => '1-Enabled,0-Disabled',
	'spf' => '1-Enabled,0-Disabled'
);

// Fields defaults                                                                                                            
$fields['defaults'] = array(     
    'username'  => '',
    'domain' => '',      
    'plan' => '',  
    'featurelist' => 'default',
    'quota'=> '0', 
    'password' => '',
    'ip'=>'n', 
    'cgi'=>'1',
    'frontpage' => '0',
    'hasshell'=>'1', 
    'contactemail'=>'',
    'cpmod'=>'',  // defaults to the server's default cPanel theme.
    'maxftp'=>'unlimited', 
    'maxsql'=>'unlimited', 
    'maxpop'=>'unlimited',  
    'maxlst'=>'unlimited', 
    'maxsub'=>'unlimited', 
    'maxpark'=>'unlimited', 
    'maxaddon'=>'unlimited', 
    'bwlimit'=>'unlimited',   
    'language'=>'',   // defaults to the server's default locale
    'useregns'=>'0', 
    'hasuseregns'=>'1', // only when useregns=1. Unique value.
    'reseller'=>'0', 
    'forcedns'=>'0', 
    'mxcheck'=>'auto',     
    'MAX_EMAIL_PER_HOUR'=>'unlimited',   
    'MAX_DEFER_FAIL_PERCENTAGE'=>'unlimited',
    'homedir' => '', // defaults to the /home/user directory, where user is the account's username
    'dkim' => '', // defaults to the Enable DKIM on domains for newly created accounts setting's value in WHM's Tweak Settings interface (Home >> System Configuration >> Tweak Settings).
    'spf' => '', // defaults to the Enable SPF on domains for newly created accounts setting's value in WHM's Tweak Settings interface (Home >> System Configuration >> Tweak Settings).
    'owner' => '' // defaults to the authenticated user.
);    

// required fields
$fields['required'] = array(
	'username',
	'domain',
	'password'
);

// Groups
$tabs = array(
	'Information' => array('username','domain','password','contactemail','language','reseller','uid','gid','homedir','plan','pkgname','savepkg','cpmod','customip'),
	'Manual' => array(	'featurelist',
		'quota',
		'maxaddon',
		'maxsub',
		'MAX_DEFER_FAIL_PERCENTAGE',
		'cgi',
		'_package_extensions',
		'hasshell',
		'digestauth',
		'lang',
		'MAX_EMAIL_PER_HOUR',
		'maxftp',  // max_ftp!!!!
		'cpmod',
		'name',
		'maxlst',
		'maxpark',
		'bwlimit',
		'frontpage',
		'ip',
		'maxsql',
		'maxpop'),
	'DNS' => array('useregns','hasuseregns','forcedns'),
	'Mail' => array('mxcheck','dkim','spf')
);

?>