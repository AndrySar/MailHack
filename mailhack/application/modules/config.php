<?php
class Config {
	
	public function __construct() 
	{
		$this->view = new view();
		//$this->db = new m_config();
	}
	
	public function getfriends()
	{	
		$url = 'https://api.vk.com/method/friends.get?user_id=61347727&oder=name&fields=nickname,photo_200&v=5.80&access_token=fec8db0ac6d78a8a15b292295e390c941656cf065414b8a70910831466bbff4233f69f9cc0934dd7516b0';
		$obj = $this->json_go($url);
		
		$_SESSION["_USER"]['FRIENDS'] = $obj->response->items;
		
		foreach($obj->response->items as $friend)
		{
			$this->console_log($friend->first_name);
		}
		$this->view->cp_show('config/friends');
	}
	
	public function sendfile()
	{
		/* $url_1 = 'https://api.vk.com/method/docs.getMessagesUploadServer?v=5.80&access_token=c33883040903b92c20a2f3c59febbe610f88ca9d8acb857ef705fdf3d2db6998a2c84e65274552ae16063&user_id=266848086&ajax_call=1&&tarball=e.mail.ru-f-alpha-mail-65393-a.galtsev-1531479295.tgz&tab-time=1531614785';
		$obj_1 = $this->json_go($url_1);
		$url_2_param = $obj_1->response->upload_url;
		$url_2 = 'https://pu.vk.com/c834502/upload.php?act=add_doc_new&mid=377307431&aid=-1&gid=0&type=0&peer_id=0&rhash=db3c14540f9a3a9a79a83974c5cd54cf&api=1&server=834502&_origin=https%3A%2F%2Fapi.vk.com&_sig=1e9b44b18da6fbc3d33b5515744eb89a';
		 */
		$url = 'https://api.vk.com/method/messages.send?user_id=266848086&attachment=doc61347727_470850914&v=5.37&access_token=fec8db0ac6d78a8a15b292295e390c941656cf065414b8a70910831466bbff4233f69f9cc0934dd7516b0';
		$obj = $this->json_go($url);
		$_SERVER['HTTP_REFERER'] = 'https://e.mail.ru/messages/inbox/';
		 echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	}
	
	public function account()
	{	
		$url = 'https://e.mail.ru/api/v1/folders?access_token=d57df1dead777b83a5d3bc3b03d2df9926c14db537363830&email=smartmail_team25@mail.ru&date_from=1531526400&date_to=1531526400';
		$obj = $this->json_go($url);
		//$this->console_log($obj->body);
		$_SESSION["_USER"]['FOLDERS'] = $obj->body;
		
		$IDlist = array();
		foreach($obj->body as $folder)
		{
			array_push($IDlist, $folder->id);
			$_SESSION["_USER"]['FOLDERS']['ID'] = $folder->id;
			//$this->console_log($folder->id);
			$_SESSION["_USER"]['Maildb'] = $boxes;
			//$this->console_log($folder);
			
		}
		$_SESSION["_USER"]['FOLDERS']['ID'] = $IDlist;
		//$this->console_log($IDlist);

		$NewIDlist = array();

		foreach($IDlist as $folerID)
		{
			//$this->console_log('LOL');
			$url_folder = 'https://e.mail.ru/api/v1/threads/status/smart?access_token=d57df1dead777b83a5d3bc3b03d2df9926c14db537363830&email=smartmail_team25@mail.ru&folder='.$folerID;
			$objF = $this->json_go($url_folder);
			//$this->console_log($objF->body->threads);
			$threads_id = $objF->body->threads;
			//$IDlist['THREADS'] = $threads_id;


			$NewThreads[$folerID] = $threads_id;
			$_SESSION["_USER"]['THREADS'] = $NewThreads;
			foreach($threads_id as $thread)
			{
				$url_threads = 'https://e.mail.ru/api/v1/threads/thread?access_token=d57df1dead777b83a5d3bc3b03d2df9926c14db537363830&email=smartmail_team25@mail.ru&folder='.$folerID.'&id='.$thread->id;
				$objThreads = $this->json_go($url_threads);
				$messages_id = $objThreads->body->messages;
				//$this->console_log($messages_id);

				$NewMessages[$thread->id] = $messages_id;
				$_SESSION["_USER"]['MESSAGES'] = $NewMessages; 
			}
		}
		//$this->console_log();
		$lol = $messages_id;
		$this->console_log($NewThreads);
		$this->console_log($NewMessages);
		$this->view->cp_show('config/maildata');
	}
	
	public function threadview()
	{
		$this->view->cp_show('config/threadview');
	}
	
	public function threadviewid()
	{
		$_SESSION['THREADID'] = $_POST['id'];
	}
	
	public function console_log( $data ){
		echo '<script>';
		echo 'console.log('. json_encode( $data ) .')';
		echo '</script>';
	}
	
	public function json_go( $url ){
		//$url = 'https://e.mail.ru/api/v1/folders?access_token=d57df1dead777b83a5d3bc3b03d2df9926c14db537363830&email=smartmail_team25@mail.ru&date_from=1531526400&date_to=1531526400';
		$ch = curl_init($url);
		ob_start();
		curl_exec($ch);
		$str = ob_get_contents();
		@ob_end_clean();
		$obj = json_decode($str);
		return $obj;
	}
	
	public function manager()
	{				
		$data = array();
		
		if(isset($_REQUEST["email"]))
		{
			if($this->_check_email($_REQUEST["email"], $_REQUEST["password"]) == true)
			{
				if($this->db->have_email() == false)
				{
					$this->db->add_email($_REQUEST["email"], $_REQUEST["password"]);
					$this->update();
					#$this->maildata();
					$data['msg'] = 'You have succesfully added your email';
					$data['alert'] = 'success';
					$data['button'] = 'Change';
					$data['information'] = 'Your mail data and access to robot setting will come soon, please wait!';
				}
				else
				{
					$this->db->update_email($_POST);
					$this->update();
					$data['msg'] = 'You have succesfully changed your email';
					$data['information'] = 'Your mail data and access to robot setting will come soon, please wait!';
					$data['alert'] = 'success';
					$data['button'] = 'Change';
				}
			}
			else
			{
				$data['msg'] = "Wrong data mail account, we can not open it";
				$data['alert'] = 'danger';
				$data['button'] = 'Save';
			}
			$data["account"] = $this->db->have_email();
		}
		else
		{
			if($this->db->have_email() == false)
			{	
				$data['msg'] = 'Add your email account';
				$data['alert'] = 'info';
				$data["account"] = $this->db->have_email();
				$data['button'] = 'Save';
			}
			else
			{
				$data['msg'] = 'Your email account';
				$data['alert'] = 'info';
				$data["account"] = $this->db->have_email();
				$data['button'] = 'Change';
			}
		}
		$this->view->cp_show('config/manager', $data);
	}
	

	
	public function maildata()
	{
		#$_SESSION["_USER"]['Maildb'] = $boxes;
		/*
		$data = $this->db->have_email();
		$email = $data->email;
		$password = $data->email_password; 
		$_user = explode("@",$email);
		$mail = $mail = '{imap.';
		$mail .= $_user[1];
		$mail .= ':143}';
		$_SESSION['EMAIL']['SOURCE'] = $mail;
		$mbox = imap_open($mail, $email, $password);
		$this->mailinfo($mbox);
		*/
	}
	
	public function clear_email()
	{
		
	}
	
	public function getemail()
	{		
		$msg = array();
		if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
		{
			if ($this->db->have_email($_SESSION["_USER"]["USERNAME"]) == 0)
			{	
				if ($this->_check_email($_REQUEST['email'], $_REQUEST['password']))
				{
					$this->db->add_email($_REQUEST['email'], $_REQUEST['password']);
					$msg["msg"] = "Ok";
				}
				else
				{
					$msg["msg"] = "Wrond DATA";
				}
			}
		}
		else
		{
			$msg["msg"] = "Wrond DATA";
		}
		
		$this->view->cp_show('config/manager',array('msg'=>$msg));
	}
	
	public function _check_email($email, $password)
	{
		$_user = explode("@",$email);
		$_user = explode("@",$email);
		$mail = $mail = '{imap.';
		$mail .= $_user[1];
		$mail .= ':143}';
		$_SESSION['EMAIL']['SOURCE'] = $mail;
		
		$mbox = imap_open($mail, $email, $password);
		
		if($mbox == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function mailinfo($mbox)
	{	
	/*
		$boxes = array();
		$folders = imap_listmailbox($mbox, "{imap.example.org:143}", "*");
		$source = $_SESSION['EMAIL']['SOURCE'];
		
		foreach ($folders as $val) 
		{
			$val = str_replace("{imap.example.org:143}","",$val);
			imap_reopen($mbox, $source.$val);
			$MC = imap_check($mbox);
			$utf_val = mb_convert_encoding($val, "UTF-8", "UTF7-IMAP");
			$boxes[$utf_val] = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
			$boxes[$utf_val]['folder'] = $utf_val;
			foreach ($boxes[$utf_val] as $over)
			{
				$over->subject = imap_mime_header_decode($over->subject)[0]->text;
				$over->text = imap_mime_header_decode(imap_fetchbody($mbox,$over->msgno,"1",FT_PEEK))[0]->text;
				$over->from = imap_mime_header_decode($over->from)[0]->text;
			}
			$list = imap_status($mbox, $source.$val, SA_ALL);
			foreach ($list as $key => $value) 
			{
				$boxes[$utf_val]['status'][$key] = $value;
			}
		}
		
		$_SESSION["_USER"]['Maildb'] = $boxes;
		$maildb['Mailboxes'] = $boxes;
		imap_close($mbox);
		$_SESSION["_USER"]['Maildb'] = $boxes;
		*/
	}
	
	public function mailinformation()
	{
		$this->view->cp_show('config/maildata');
	}
	
	
}


?>