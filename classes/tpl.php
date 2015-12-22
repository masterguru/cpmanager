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

// html code. Helper class
class tpl {

	var $html_minimal_select = '
	{html_header}
	<body>
		<div class="container">
			{html_navbar}
		</div>
		<div id="loading" class="modal"><!-- Place at bottom of page --></div>
	</body>
	</html>	
	';

	var $html_table_select_options_history = '
		<table class="table" id="history_table">
			<thead>
				<th></th>
				<th>date</th>
				<th>domain</th>
<!--
				<th>username</th>
				<th>IP</th>
-->				
				<th></th>
			</thead>
			<tbody>
				{out}
			</tbody>
		</table>';

	var $html_select_options_history = '
		<tr>
			<td><button class="btn btn-default" onclick="highlighting( this );open_tabs({item_id})"><i class="glyphicon glyphicon-pencil"></i> </button></td>
			<td>{date_creation}</td>
			<td>{info_domain}</td>
<!--
			<td><a href="https://{server_ip}:2083/" target="_blank">{info_username}</a></td>
			<td><a href="https://{server_ip}:2087/" target="_blank">{server_ip}</a></td>
			<td>{remote_addr}</td>
-->
			<td><button class="btn btn-default" class="del_history" id="delete__{item_id}" onclick="delete_history({item_id})"><i class="glyphicon glyphicon-trash"></i></button></td>
		</tr>';

	var $html_tabs_history = '
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#email_template" aria-controls="email_template" role="tab" data-toggle="tab">Email template</a></li>
    <li role="presentation"><a href="#result_metadata_output" aria-controls="result_metadata_output" role="tab" data-toggle="tab">WHM</a></li>
<!--
	<li role="presentation"><a href="#result_data" aria-controls="result_data" role="tab" data-toggle="tab">NS, PKG and IP</a></li>
-->	
    <li role="presentation"><a href="#request_info" aria-controls="request_info" role="tab" data-toggle="tab">Request</a></li>
    <li role="presentation"><a href="#query_string" aria-controls="query_string" role="tab" data-toggle="tab">WHM API</a></li>
    <li role="presentation"><a href="#server_info" aria-controls="server_info" role="tab" data-toggle="tab">Server</a></li>
    <li role="presentation"><a href="#env_info" aria-controls="env_info" role="tab" data-toggle="tab">Env</a></li>
    <li role="presentation"><a href="#cookie_info" aria-controls="cookie_info" role="tab" data-toggle="tab">Cookie</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="email_template">{email_template}</div>
    <div role="tabpanel" class="tab-pane" id="result_metadata_output">{result_metadata_output}</div>
<!--
	<div role="tabpanel" class="tab-pane" id="result_data">{result_data}</div>
-->	
    <div role="tabpanel" class="tab-pane" id="request_info">{request_info}</div>
	<div role="tabpanel" class="tab-pane" id="query_string">{query_string}</div>
    <div role="tabpanel" class="tab-pane" id="server_info">{server_info}</div>
    <div role="tabpanel" class="tab-pane" id="env_info">{env_info}</div>
    <div role="tabpanel" class="tab-pane" id="cookie_info">{cookie_info}</div>
  </div>  
	';


	var $html_ajax = '
		<div class="panel-heading">
			<h3 class="panel-title">Plan: {plan}</h3>
		</div>
		<div class="panel-body">
			<fieldset {disabled}>
				{fieldset}
			</fieldset>
		</div>
	';

	var $html_tpl_checkbox = '
		<div class="form-group" >
			<label for="{key}" class="col-sm-5 control-label">{value}</label>
			<div class="col-sm-6 {codeerror}">
				<div class="checkbox ">
					<label>
						<input type="checkbox" value="{input_value}" name="{key}" id="{key}" {required} {readonly}/> 
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="{title}"></i>			
			</div>
		</div>';

	var $html_tpl_select = '
		<div class="form-group" >
			<label for="{key}" class="col-sm-5 control-label">{value}</label>
			<div class="col-sm-6 {codeerror}" >
				<select class="form-control" name="{key}" id="{key}" {readonly}><option value="{first_opt_value}">{first_opt_text}</option>{list}</select>
			</div>
			<div class="col-sm-1">
				<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="{title}"></i>			
			</div>
		</div>';
	
	var $html_tpl_radio = '
		<div class="form-group">
			<label for="{key}" class="col-sm-5 control-label">{value}</label>
			<div class="col-sm-6 {codeerror}">
					<label class="radio-inline">
					  <input type="radio" name="{key}" id="{key}" value="y" {required_y} {readonly}/> Yes
					</label>
					<label class="radio-inline {codeerror}">
					  <input type="radio" name="{key}" id="{key}" value="n" {required_n} {readonly}/>  No
					</label>
			</div>
			<div class="col-sm-1">
				<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="{title}"></i>			
			</div>
		</div>
	';
	
	var $html_tpl_input = '
		<div class="form-group {codeerror}">
			<label for="{key}" class="col-sm-5 control-label" >{value}</label>
			<div class="col-sm-6 ">
<div class="input-group ">
  <input class="form-control" type="text" name="{key}" id="{key}" value="{input_value}" {required} {readonly} /> 
  {extra_buttons}
</div>  
			</div>
			<div class="col-sm-1">
				<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="{title}"></i>			
			</div>
		</div>
	';

	var $html_header = '<html>
<head>
<meta charset="UTF-8">
<title>Create a cpanel account</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script>

$(function () {
	$(\'[data-toggle="tooltip"]\').tooltip();
})

// To highlight rows
var highlighting = function(e) {
	// first remove all of them
	$(e).closest(\'table\').find( "tr" ).removeClass("highlight");
	// then highligth the nearest
	$(e).closest(\'tr\').toggleClass("highlight");
};

$( document ).ajaxStart(function() {
	$( "#loading" ).show();
});

$( document ).ajaxStop(function() {
	$( "#loading" ).hide();
});

function launch_spinner() {
	$("body").addClass("loading");
}	

function seendto(item_id,client_email) {
	$( "#preemail_template").show();
	var destination_email = prompt("Destination client email",client_email);
	if(!destination_email) {
		return;
	}
	var url = "{script_path}"; 
	var term = $( "#textarea_email_template" ).val();
	var posting = $.post( url, { ajax: 1, email_content: term, item_id: item_id, action: "destination_email", destination_email: destination_email, serverid: "{serverid}" });
	posting.done(function( data ) {
		$( "#pre_email_template" ).empty(); 
		$( "#pre_email_template" ).html( data );
	});
}

function open_tabs(item_id) {
	var url = "{script_path}"; 
	var posting = $.post( url, { ajax: 1, action: "open_tabs", open_tabs: 1, item_id: item_id, serverid: "{serverid}" });
	posting.done(function( data ) {
		$( "#log_history" ).empty();
		$( "#log_history" ).html( data );
	});
}

function goto(mail_id) {
	$( "#form_mail").toggle();
	$( "#preemail_template").toggle();
	var term = $( "#textarea_email_template" ).val();
	var url = "{script_path}"; 
	var posting = $.post( url, { ajax: 1, action: "textarea_email_template", textarea_email_template: term, mail_id: mail_id, serverid: "{serverid}" });
	posting.done(function( data ) {
		$( "#pre_email_template" ).empty(); 
		$( "#pre_email_template" ).html( data );
	});
}

function editmail() {
	$( "#form_mail").toggle();
	$( "#preemail_template").toggle();
}
</script>
<script>
function generate_new_password (player) {
  npwd = GeneratePassword();

  document.getElementById(player).value = npwd;
  // document.getElementById(rplayer).value = npwd;
  // document.getElementById(pgrlayer).innerHTML = \'Generated password: \'+npwd;
}

function GeneratePassword() {
    if (parseInt(navigator.appVersion) <= 3) {
        alert("This only runs with new browsers. Update yours!");
        return true;
    }

    var length=9;
    var sPassword = "";

    for (i=0; i < length; i++) {
        numI = getRandomNum();
        while (checkPunc(numI)) { numI = getRandomNum(); }
        sPassword = sPassword + String.fromCharCode(numI);
    }
	// alert(sPassword);
    return sPassword;
}

function getRandomNum() {
    // between 0 - 1
    var rndNum = Math.random()
    
    // rndNum from 0 - 1000
    rndNum = parseInt(rndNum * 1000);
    
    // rndNum from 33 - 127
    rndNum = (rndNum % 94) + 33;
    
    return rndNum;
}

function checkPunc(num) {
    if ((num >=33) && (num <=47)) { return true; }
    if ((num >=58) && (num <=64)) { return true; }
    if ((num >=91) && (num <=96)) { return true; } 
    if ((num >=123) && (num <=126)) { return true; }
    
    return false;
}
</script>
<style>

.highlight td {
    color: #ffffff !important; 
	background-color: #86abd9 !important;
}
.highlight td a {
    color: #ffffff !important; 
    text-decoration:underline;
}

.fa-spin-custom, .glyphicon-spin {
    -webkit-animation: spin 1000ms infinite linear;
    animation: spin 1000ms infinite linear;
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
}

@keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
}


/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                50% 50% 
                url(\'loader.gif\')  
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}
</style>
</head>';

	var $html_navbar = '
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">CPanel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>
	      <form class="navbar-form navbar-left">
	        <div class="form-group">
	        	<label>Select a server: </label>
		        {select_servers}
	        </div>
	      </form>
        </li>
      </ul>

      <ul class="nav navbar-nav pull-right">
        <li>
			<form action="" method="POST" class="navbar-form navbar-left pull-right">
		    	<div class="form-group">
		            <input type="hidden" name="action" value="logout">
		            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-log-out"></i> Log Out</button>
		       	</div>
	        </form>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
';


	var $html_tpl_main = '
<body>
<div class="container">
	{html_navbar}
	<div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#create_cpanel" aria-controls="create_cpanel" role="tab" data-toggle="tab">Create a cpanel account</a></li>
			<li role="presentation"><a href="#history_cpanel" aria-controls="history_cpanel" role="tab" data-toggle="tab">History</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="create_cpanel">
				<h1>Create a cpanel account </h1>
				{errors}
				<form class="form-horizontal" method="POST">
					<div>
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Information</h3>
								</div>
								<div class="panel-body">
									{information}
									<div class="row">
									<div class="col-sm-offset-5 col-sm-6">
										<input type="submit" value="Create" class="btn btn-primary form-control" onclick="javascript:launch_spinner();"/>
									</div>
									</div>
									
								</div>
							</div>		
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">DNS</h3>
								</div>
								<div class="panel-body">
									{dns}
								</div>
							</div>		
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Mail</h3>
								</div>
								<div class="panel-body">
									{mail}
								</div>
							</div>		
						</div>
						<div class=" col-md-6" id="Others" >
							<div class="panel panel-default" >
								<div class="panel-heading">
									<h3 class="panel-title">Plan</h3>
								</div>
								<div class="panel-body" id="manual_content">
									{manual}
								</div>
							</div>		
						</div>
					</div>
				</form>
		    </div>
			<div role="tabpanel" class="tab-pane" id="history_cpanel">
				<div class="row">
					<div class="col-md-12">
						<h1>History</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div id="history">
							<div id="div_history_table">
								{history}
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div id="log_history" ></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	$("#plan").change(function () {
		var term = $( "#plan" ).val();
		var url = "{script_path}"; 
		var posting = $.post( url, { ajax: 1, action: "plan", plan: term, serverid: "{serverid}" });
		posting.done(function( data ) {
			$( "#manual_content" ).empty();
			$( "#manual_content" ).html( data );
		});
	
	});

	function delete_history(e) {
		if(confirm(\'Are you sure? \')) {
			var url = "{script_path}"; 
			var posting = $.post( url, { ajax: 1, action: "delete_history_item", delete_history_item: e, serverid: "{serverid}"});
			posting.done(function( data ) {
				$( "#div_history_table" ).empty();
				$( "#div_history_table" ).html( data );
			});
		}
	}

</script>
<div id="loading" class="modal"><!-- Place at bottom of page --></div>
</body>
</html>';

	var $show_login = '
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">CPanel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav pull-right">
        <li>
		    <form class="navbar-form navbar-left form-inline pull-right" action="" method="POST">
		        <input type="hidden" name="action" value="login">
		    	<div class="form-group">
			        <input type="text" class="form-control pull-left" name="user_name" value="" placeholder="Username"/>
		       	</div>
		    	<div class="form-group">
			        <input type="password" class="form-control pull-left" name="password" value="" placeholder="Password"/>
		       	</div>
		    	<div class="form-group">
			        <button class="btn btn-primary" type="submit">Login</button>
		       	</div>
		    </form>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
';

	var $html_email_template_frame = '
	<form style="display:none;" id="form_mail">
		<div class="col-md-6">
			<button class="btn btn-default form-control" type="button" onclick="goto({item_id});"><i class="glyphicon glyphicon-floppy-disk"></i> Save changes</button>
		</div>
		<div class="col-md-12">
			<textarea id="textarea_email_template"  class="form-control" style="height:240px;">{txtarea_content}</textarea>
		</div>
		<div class="col-md-6">
			<input class="btn btn-default form-control" type="button" onclick="goto({item_id});" value="Save changes" />
		</div>
	</form>
	{previous_sends}
	<div id="preemail_template">
		<button type="button" id="edit_mail" name="edit_mail" class="btn btn-default" onclick="editmail();return false"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
		<button class="btn btn-default" onclick="seendto({item_id},\'{client_email}\')"><i class="glyphicon glyphicon-envelope"></i> Send to ...</button>
		<pre id="pre_email_template">{txtarea_content}</pre>
	</div>
	';

	var $html_select_servers_short = '
		<select class="form-control" name="serverid" id="serverid" onchange="window.location.href=\'?serverid=\' + this.value;launch_spinner();">
			<option value=""></option>
				{options}
		</select>
	';

	var $html_show_login = '
{html_header}
<body>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			{show_login}
		</div>
	</div>
</div>
</body>
</html>';

	var $extra_buttons = '
		<span class="input-group-btn">
			<button type="button" class="btn btn-default" onclick="generate_new_password (\'password\');">
				<i class="glyphicon glyphicon-repeat"></i> Generate
			</button>
		</span>	
	';

	var $error_alert = '<div class="alert alert-danger">Errors occurred. Review the values in the form fields in red.</div>';

	function __construct() {
		/**
		 * domain -> deinedomain.at
		 * cpanel_account -> deinedomain
		 * cpanel_password -> xxx
		 * client_id -> xxx
		 * */
		$this->email_plain_text = file_get_contents('classes/mail_template.txt');
	}

	/**
	 * Template function
	 */
	function replace_vars($buffer, $data)	{
	
		/* replace declared var names */
		foreach ($data as $k => $v)
		{
			if (is_string($v) || is_numeric($v) || $v == NULL)
			{
				$buffer = preg_replace('/\{'.strtolower($k).'\}/', $v, $buffer);
			}
		}
		return $buffer;
	}

	function render($buffer, $data) {
		return $this->replace_vars($buffer, $data);
	}

}
?>