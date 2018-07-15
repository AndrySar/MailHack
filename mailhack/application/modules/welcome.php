<?php
class Welcome {
	
	public function __construct() 
	{
		$this->view = new view();		
	}
	
	public function index()
	{
		$this->view->show('login/login');
	}
	
	public function login()
	{
		if((isset($_REQUEST["login"])) && (isset($_REQUEST["password"])))
		{
			$login = $_REQUEST["login"];
			$password = $_REQUEST["password"];
			
			if($login=='smartmail_team25@mail.ru' && $password=='SmartMailHacK_2018')
			{
				$user["USERNAME"] = $login;
				$user["TIMESTAMP"] = time();
				$user["USER_ID"] = '1';
				$_SESSION["_USER"] = $user;
					
				header("Location: ".BASE_URL."?module=config&method=account");
					
			}
			else
			{
				$msg = 'User does not exist';
				$this->view->show('login/register',array('msg'=>$msg));
			}
		}
		else
		{
			$this->view->show('login/login');
		}
	}
	
	public function logout()
	{
		unset($_SESSION["_USER"]);
		unset($_REQUEST["password"]);
		header("Location: ".BASE_URL."?module=welcome&method=login");
	}
	
}
?>