<?php
class Apivk {
	
	public function __construct() 
	{
		$this->view = new view();
	}
	
	public function getfriends()
	{	
		echo 'fdfdf';
		$url = 'https://api.vk.com/method/friends.get?user_id=266848086&oder=name&fields=nickname,photo_200&v=5.80&access_token=fec8db0ac6d78a8a15b292295e390c941656cf065414b8a70910831466bbff4233f69f9cc0934dd7516b0';
		$obj = $this->json_go($url);
		
		$this->console_log($obj);
		$this->view->cp_show('apivk/friends');
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
	
}


?>