<?php
/**
 * Class history
 */
class history {

	/**
	 * Returns formated html history
	 */
	function show_history($to_list) {
		$tpl = new tpl();
		$out = '';
		foreach($to_list as $lid=>$obj) {
			$data = array(
				'date_creation' => $obj->date_creation,
				'info_domain'	=> $obj->request_info->domain,
				'server_ip'	=> $obj->result->data->ip,
				'info_username' => $obj->request_info->username,
				'remote_addr' => $obj->server_info->REMOTE_ADDR,
				'item_id' => $lid,
				);
			$out.= $tpl->render($tpl->html_select_options_history, $data);
		}
		$data = array(
			'out' => $out,
			);
		$bigout = $tpl->render($tpl->html_table_select_options_history, $data);
		return $bigout;
	}
	
	/**
	 * 
	 */
	function delete_history_item() {
		$other = file_get_contents('createacct_log');
		$to_list = json_decode($other);
		if(is_numeric($_POST['delete_history_item'])) {
			unset($to_list[$_POST['delete_history_item']]);
			$to_list = array_values($to_list);  // reindex array
			$_log1 = json_encode($to_list);
			file_put_contents('createacct_log',$_log1);
		}
		echo $this->show_history($to_list);
		die();
	}

	/**
	 * 
	 */
	function switch_log($splitt,$to_list) {
		switch($splitt[1]) {
			case result_data:
				foreach($to_list[$splitt[0]]->result->data as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return '<pre>'.$outt.'</pre>';
				break;
			case server_info:
				foreach($to_list[$splitt[0]]->server_info as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return '<pre>'.$outt.'</pre>';
				break;
			case request_info:
				foreach($to_list[$splitt[0]]->request_info as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return  '<pre>'.$outt.'</pre>';
				break;
			case env_info:
				foreach($to_list[$splitt[0]]->env_info as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return  '<pre>'.$outt.'</pre>';
				break;
			case result_metadata_output:
				$other = file_get_contents('createacct_log');
				$to_list = array_reverse(json_decode($other),true);
				foreach($to_list[$splitt[0]]->result->metadata->output as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return  '<pre>'.$outt.'</pre>';
				break;
			case cookie_info:
				foreach($to_list[$splitt[0]]->cookie_info as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return  '<pre>'.$outt.'</pre>';
				break;
			case result_data:
				foreach($to_list[$splitt[0]]->result->data as $id1=>$value1) {
						$outt .= '<li>'.$id1.': '.$value1.'</li>';
				}
				return  '<pre>'.$outt.'</pre>';
				break;
			case query_string:
				return  htmlspecialchars($to_list[$splitt[0]]->query_string);
				break;
			case email_template:
				$tpl = new tpl();
				$previous_sends = '';
				if(!empty($to_list[$splitt[0]]->data_mail)) {
						$previous_sends = '<div class="col-md-12 alert alert-info" role="alert">Last sent: '.date("Y-m-d H:i:s" ,$to_list[$splitt[0]]->data_mail->time)." => ".$to_list[$splitt[0]]->data_mail->to.'</div>';
				}
				$client_email = (isset($to_list[$splitt[0]]->request_info->contactemail))? $to_list[$splitt[0]]->request_info->contactemail : 'none';
				$data = array(
					'item_id'	=> $splitt[0],
					'txtarea_content' => $to_list[$splitt[0]]->email_template,
					'previous_sends' => $previous_sends,
					'client_email' => $client_email
					);
				return $tpl->render($tpl->html_email_template_frame, $data);
				break;
			default:
				break;
		}
	}
}	

?>