<?php

class Cron {
	
	public function __construct() 
	{
		$this->db = new m_cron();
	}
	
	public function maildata()
	{
			$go = microtime(true);
		
		$emails = $this->db->get_emails();
		debug($emails);
		
		foreach($emails as $email)
		{
			$start = microtime(true);
			
			$mail = $email->email;
			$password = $email->email_password; 
			$source = explode("@",$mail)[1];
			$source = '{imap.'.$source.':143}';
			$mbox = imap_open($source, $mail, $password);
			debug($email->user_id);
			
			$time = microtime(true) - $start;
			printf('<br>OPEN Скрипт 1 выполнялся %.4F сек. <br>', $time);
			
			
			if ($mbox != false)
			{
				
					$start = microtime(true);
				
				$this->db->unset_folders($email->user_id);

					$time = microtime(true) - $start;
					printf('<br>UNSET FOLDERS Скрипт 2 выполнялся %.4F сек. <br>', $time);
				
					$start = microtime(true);
					
				$maildb = $this->mailinfo($mbox, $source);
					$time = microtime(true) - $start;
					printf('<br>MAILS Скрипт 2 выполнялся %.4F сек. <br>', $time);
					
					$start = microtime(true);
					
				foreach($maildb as $folder)
				{
					$this->db->insert_folder($email->user_id, $folder['folder'], $folder['status']['unseen'], $folder['status']['messages']);
					if($folder['folder']=="INBOX")
					{
						$this->db->unset_inbox($email->user_id);
						foreach($folder as $message)
						{
							if(isset($message->from))
							{
								if($message->seen == 0)
								{
									$this->db->set_message($email->user_id, $email->email, $folder['folder'], $message->uid, date("Y-m-d H:i:s", $message->udate), $message->subject, $message->text, $message->from, $message->seen);
								}
							}
						}
					}
				}
				
				$time = microtime(true) - $start;
				printf('<br>INBOX Скрипт 2 выполнялся %.4F сек. <br>', $time);
				
				$start = microtime(true);
				
				$this->answer($email->user_id);
				
				$time = microtime(true) - $start;
				printf('<br>ANSWER Скрипт 2 выполнялся %.4F сек. <br>', $time);
				
				$start = microtime(true);
				
				$this->dele($email->user_id, imap_open($source, $mail, $password));
				
				$time = microtime(true) - $start;
				printf('<br>DELETE Скрипт 3 выполнялся %.4F сек. <br>', $time);
				
				$start = microtime(true);
				
				$this->sorting($email->user_id, imap_open($source, $mail, $password));
				
				$time = microtime(true) - $start;
				printf('<br>SORTING Скрипт выполнялся %.4F сек. <br>', $time);
			}
			
		}
		
			$go = microtime(true) - $go;
			printf('<br>ALL Скрипт 1 выполнялся %.4F сек. <br>', $go);
	}
	
	public function mailinfo($mbox, $source)
	{
		$boxes = array();
			$start = microtime(true);
		$folders = imap_listmailbox($mbox, "{imap.example.org:143}", "*");
			$time = microtime(true) - $start;
			printf('<br>FOLDERS Скрипт выполнялся %.4F сек. <br>', $time);
			
		foreach ($folders as $val) 
		{
				$start = microtime(true);
			$val = str_replace("{imap.example.org:143}","",$val);
			imap_reopen($mbox, $source.$val);
			
			$utf_val = mb_convert_encoding($val, "UTF-8", "UTF7-IMAP");
			
			
				$time = microtime(true) - $start;
				printf('<br>_____FOLDER# Скрипт выполнялся %.4F сек. <br>', $time);
			
			if($utf_val == 'INBOX')
			{
				echo '<br>'.$utf_val.'<br>';
				
					$start = microtime(true);
				$MC = imap_check($mbox);
				$boxes[$utf_val] = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
				
				foreach ($boxes[$utf_val] as $over)
				{
					if($over->seen == 0)
					{
						$over->subject = imap_mime_header_decode($over->subject)[0]->text;
						#$over->text = imap_utf8(imap_fetchbody($mbox,$over->msgno,"1",FT_PEEK));
						$over->text = imap_utf8(imap_fetchbody($mbox,$over->msgno,"1",FT_PEEK)); 
						$over->from = imap_utf8($over->from);
						#echo '<br>'.$over->from.'<br>';
					}
				}
					$time = microtime(true) - $start;
					printf('<br>_____Status# Скрипт выполнялся %.4F сек. <br>', $time);
			}
			
			$list = imap_status($mbox, $source.$val, SA_ALL);
			foreach ($list as $key => $value) 
			{
				$boxes[$utf_val]['status'][$key] = $value;
			}
			$boxes[$utf_val]['folder'] = $utf_val;
		}
		
		imap_close($mbox);
		return $boxes;
	}
	
	public function sorting($id, $mbox)
	{
		$arr = $this->db->get_sorting($id);
		debug($arr);
		foreach($arr as $val)
		{
			$mass = $this->db->get_messages_to_sort($id, $val->from_name, $val->folder);
			debug($mass);
			foreach($mass as $item)
			{	
				imap_mail_move($mbox, strval($item), $val->folder, CP_UID) or die(debug($this->conn->errorInfo()));
				$this->db->move_message($id, $item, $val->folder);
			}
		}
		imap_close($mbox,CL_EXPUNGE); 
	}
	
	public function dele($id, $mbox)
	{
		echo '<br> DELETE <br>';
		$arr = $this->db->get_delete($id);
		debug($arr);
		foreach($arr as $val)
		{
			$mass = $this->db->get_messages_to_delete($id, $val->from_name);
			debug($mass);
			foreach($mass as $item)
			{	
				imap_delete($mbox, $item, FT_UID) or die("<br> can't delete email");
			}
		}
		imap_close($mbox,CL_EXPUNGE); 
	}
	
	public function answer($id)
	{
		echo '<br> ANSWER <br>';
		$header = $this->db->get_email($id);
		$header = $header[0];
		echo '<br> email <br>';
		debug($header);
		echo '<br> email <br>';
		$from = $this->db->get_name($id);
		$from = $from[0];
		$head = "From: ".$from." <".$header.">";
		debug($head);
		echo $head.'<br>';
		$arr = $this->db->get_answer($id);
		debug($arr);
		if(count($arr) > 0)
		{
			foreach($arr as $val)
			{
				$to = explode(", ",$val->to_send);
				debug($to);
				foreach($to as $row)
				{
					$mass = $this->db->get_messages_to_answer($id, $row);
					debug($mass);
					foreach($mass as $item)
					{	
						debug($item);
						echo $item->from_name.'  '.$item->subject.'   '.$val->text_messageю.'<br>';
						debug(mail($item->from_name, $item->subject, $val->text_message, $head));
					}
				}
			}
		}
	}
}	
?>