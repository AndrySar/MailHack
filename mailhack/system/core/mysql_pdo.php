<?php

class mysql_pdo {

	public $conn = null;

	function __construct() 
	{
		$dsn = 'mysql:dbname=admin_robot;host=localhost';
		$user = 'root';
		$password = '12qwaszx12';
		
		try {
			$this->conn = new PDO($dsn, $user, $password);
			$this->conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
		} catch (PDOException $e) {
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}

	public function set_msg_from_mail($msg)
	{
		$sql = "INSERT INTO email_msg(msg_id, date_time, from_msg, subject_msg, text_msg, email) values ('".$msg["msgno"]."', '".$msg["date"]."', '".$msg["from"]."', '".$msg["subject"]."', '".$msg["text"]."', '".$msg["email"]."')";
		$this->conn->query($sql) or die('Запрос не удался3: ' . mysql_error());
		
	}
	
	public function unset_msg($email)
	{
		$sql = "DELETE FROM email_msg WHERE email = '".$email."'";
		$this->conn->query($sql) or die('Запрос не удался3: ' . mysql_error());
	}
	
	public function get_count($email)
	{
		$sql = "SELECT count(msg_id) AS QTY FROM email_msg WHERE email='".$email."'";
		
		//$f = $this->conn->query($sql);
		//$f->setFetchMode(PDO::FETCH_ASSOC);
		//print_r($f->fetchAll());
		
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$result = $sth->fetchColumn();
		return $result;
		
	}
	
	public function check_reg($email)
	{
		$sql = "SELECT count(email) AS QTY FROM user WHERE email='".$email."'";
		
	}


}


?>