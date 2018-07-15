<?php

Class m_welcome 
{
	
	public function __construct()
	{
		$dsn = 'mysql:dbname=admin_robot;host=localhost';
		$user = 'root';
		$password = '12qwaszx12';

		try {
			$this->conn = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}
	
	
	public function get_count_user($user)
	{
		
		$sql = "SELECT count(login) FROM users WHERE login = '$user'";
		
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$result = $sth->fetchColumn();
		return $result;
	}
	
	public function add_user($login, $username, $password)
	{
		$password = md5($password);
		$sql = "INSERT into users (login, username, password) values ('$login', '$username', '$password')";
		return $this->conn->query($sql) or die('Запрос не удался');
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
	
	public function _get_info($login)
	{
		$sql = "SELECT * FROM users WHERE login='".$login."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_OBJ);
		return $result;
	}		
	
	public function _check_email($id)
	{
		$sql = "SELECT * FROM emails WHERE user_id = '$id'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();	
		$result = $sth->fetch(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function _get_email($id)
	{
		$sql = "SELECT * FROM emails WHERE user_id = '$id' LIMIT 1";
		$sth = $this->conn->prepare($sql);
		$sth->execute();	
		$result = $sth->fetch(PDO::FETCH_OBJ);
		return $result;
	}
	
	public function change_password($data)
	{
		$new_password = md5($data);
		$id = $_SESSION['uid'];
		$sql = "UPDATE users SET password='$new_password' WHERE id = '$id'";
		$this->conn->query($sql) or die('Запрос не удался');
	}
}
?>