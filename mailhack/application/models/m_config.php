<?php

class m_config {
	
	public function __construct()
	{
		$dsn = 'mysql:dbname=admin_robot;host=localhost';
		$user = 'root';
		$password = '12qwaszx12';
		try 
		{
			$this->conn = new PDO($dsn, $user, $password);
		} 
		catch (PDOException $e)
		{
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}
	
	public function have_email()
	{
		$id_user = (isset($_SESSION["_USER"]["USER_ID"])) ? $_SESSION["_USER"]["USER_ID"] : 0;
		$sql = "SELECT * FROM emails WHERE user_id = '$id_user' LIMIT 1";
		$sth = $this->conn->prepare($sql);
		$sth->execute();	
		$result = $sth->fetch(PDO::FETCH_OBJ);
	
		if(isset($result->user_id))
		{
			return $result;
		}
		else
		{
			return false;
		}
	
	}
	
	public function update_email($data)
	{
			
		$email = $data['email'];
		$password = $data['password'];
		$login_id = $data['login_id'];
		
		$sql = "UPDATE emails SET email='$email', email_password='$password'  WHERE user_id = '$login_id'";
		$this->conn->query($sql) or die('Запрос не удался');
	}
	
	public function add_email($email, $password)
	{
		$id = $_SESSION["_USER"]["USER_ID"];
		$sql = "INSERT into emails (user_id, email, email_password) values ('$id', '$email', '$password')";
		return $this->conn->query($sql) or die('Запрос не удался');
		debug(error_get_last());
	}
	
	public function check_mail($email)
	{
		$sql = "SELECT count(msg_id) AS QTY FROM email_msg WHERE email='".$email."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$result = $sth->fetchColumn();
		return $result;
	}
	
	public function _get_user_info($login)
	{
		$sql = "SELECT * FROM users WHERE login='".$login."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_OBJ);
		return $result;
	}		
	
	public function change_password($data)
	{

		$password = $data['password'];
		$new_password = md5($data['new_password1']);
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "UPDATE users SET password='$new_password' WHERE id = '$id'";
		$this->conn->query($sql) or die('Запрос не удался');
	}
	
	public function change_login($data)
	{
		$login = $data['new_login'];
		$password = $data['password'];
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "UPDATE users SET login='$login' WHERE id = '$id'";
		$this->conn->query($sql) or die('Запрос не удался');
	}
	
	public function get_maildata($folder)
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT subject, from_name FROM email_msg WHERE folder='".$folder."' AND user_id = '".$id."'";
		$sth = $this->conn->prepare($sql) or die('lol');
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function get_folders()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT * FROM folders WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql) or die('lol');
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function _get_email($id)
	{
		$sql1 = "SELECT * FROM emails WHERE user_id = '$id' LIMIT 1";
		$sth1= $this->conn->prepare($sql1);
		$sth1->execute();	
		$result1 = $sth1->fetch(PDO::FETCH_OBJ);
		#debug($result);
		
		$sql2 = "SELECT * FROM folders WHERE user_id = '$id' LIMIT 1";
		$sth2 = $this->conn->prepare($sql2);
		$sth2->execute();	
		$result2 = $sth2->fetch(PDO::FETCH_OBJ);
		#debug($result2);
		if(isset($result1->email) && isset($result2->folder))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>