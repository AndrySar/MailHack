<?php

class m_robot {
	
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
	
	public function subjects()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT subject FROM email_msg WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$_SESSION['mails']['subject'] = $sth->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function from_name()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT from_name FROM email_msg WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		$_SESSION['mails']['from'] = $sth->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function unset_sorting($folder)
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "DELETE FROM sorting WHERE user_id = '".$id."' AND folder = '".$folder."'";
		$this->conn->query($sql) or die('Запрос не удался3: ' . mysql_error());
	}
	
	public function sorting_set($folder, $sort)
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "INSERT INTO sorting (user_id, folder, from_name) values ('$id', '$folder', '$sort')";
		return $this->conn->query($sql) or die('Truble');
	}
	
	public function sorting_get()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT folder, from_name FROM sorting WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function unset_delete()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "DELETE FROM dele WHERE user_id = '".$id."'";
		$this->conn->query($sql) or die('Запрос не удался3: ' . mysql_error());
	}
	
	public function delete_set($del)
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "INSERT INTO dele (user_id, from_name) values ('$id', '$del')";
		return $this->conn->query($sql) or die('Truble');
	}
	
	public function delete_get()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT from_name FROM dele WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function unset_answer()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "DELETE FROM answer WHERE user_id = '".$id."'";
		$this->conn->query($sql) or die('Запрос не удался3: ' . mysql_error());
	}
	
	public function answer_set($to, $text)
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "INSERT INTO answer (user_id, to_send, text_message) values ('$id', '$to', '$text')";
		return $this->conn->query($sql) or die('Truble');
	}
	
	public function answer_get()
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT to_send, text_message FROM answer WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql);
		$sth->execute();		
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function search_get($key)
	{
		$id = $_SESSION['_USER']['USER_ID'];
		$sql = "SELECT from_name, subject, text FROM email_msg 
				WHERE user_id='".$id."' AND (from_name LIKE '%".$key."%' OR subject LIKE '%".$key."%' OR text LIKE '%".$key."%')";
		$sth = $this->conn->prepare($sql);
		$sth->execute();	
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
}

?>