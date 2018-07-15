<?php

class m_cron {

	public $conn = null;

	function __construct() 
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
	
	public function set_message($user_id, $email, $fold, $uid, $date, $subject, $text, $from, $seen)
	{
		$sql = "INSERT into email_msg (user_id, email, folder, msg_id, date_time, subject, text, from_name, seen) values ('$user_id', '$email','$fold','$uid', '$date', '$subject', '$text','$from', '$seen')";
		$this->conn->query($sql) or die(debug($this->conn->errorInfo()));
	}
	
	public function unset_mbox($id)
	{
		$sql = "DELETE FROM email_msg WHERE user_id = '".$id."'";
		$this->conn->query($sql) or die($sql);
	}
	
	public function unset_inbox($id)
	{
		$sql = "DELETE FROM email_msg WHERE user_id = '".$id."' AND folder='INBOX'";
		$this->conn->query($sql) or die($sql);
	}
	
	public function get_count($email)
	{
		$sql = "SELECT count(msg_id) AS QTY FROM email_msg WHERE email='".$email."'";
		$sth = $this->conn->prepare($sql)or die($sql);
		$sth->execute();
		$result = $sth->fetchColumn();
		return $result;
		
	}
	
	public function check_reg($email)
	{
		$sql = "SELECT count(email) AS QTY FROM user WHERE email='".$email."'";
		$sth = $this->conn->prepare($sql)or die($sql);
		$sth->execute();
		$result = $sth->fetchColumn();
		return $result;
	}
	
	public function get_emails()
	{
		$sql = 'SELECT * from emails';
		$sth = $this->conn->prepare($sql)or die($sql);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_OBJ);
		return $result;
	}

	public function get_sorting($id)
	{
		$sql = "SELECT folder, from_name FROM sorting WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql) or die($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function get_delete($id)
	{
		$sql = "SELECT from_name FROM dele WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql) or die($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function get_messages_to_sort($id, $from_name, $folder)
	{
		$sql = "SELECT msg_id 
				FROM email_msg 
				WHERE NOT folder='".$folder."' AND folder='INBOX' AND from_name LIKE '%".$from_name."%' AND user_id='".$id."'
				ORDER BY msg_id";
		echo $sql;
		$sth = $this->conn->prepare($sql) or die($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function get_messages_to_delete($id, $from_name)
	{
		$sql = "SELECT msg_id 
				FROM email_msg 
				WHERE folder='INBOX' AND from_name LIKE '%".$from_name."%' AND user_id='".$id."'
				ORDER BY msg_id";
		echo $sql;
		$sth = $this->conn->prepare($sql) or die($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_COLUMN);
	}
	
	public function unset_folders($id)
	{
		$sql = "DELETE FROM folders WHERE user_id = '".$id."'";
		$this->conn->query($sql) or die($sql);
	}
	
	public function errorlog($text, $id)
	{
		$sql = "INSERT into folders (error, user_id) values ('$text', '$id')";
		debug($text);
		#$this->conn->query($sql) or die('Запрос не удался 3: ' . mysql_error());
	}
	
	public function insert_folder($user_id, $folder_name, $unread, $messages)
	{
		$sql = "INSERT into folders (user_id, folder, unread, messages) values ('$user_id', '$folder_name', '$unread', '$messages')";
		$this->conn->query($sql) or die(debug($this->conn->errorInfo()));
	}
	
	public function get_messages_to_answer($id, $from_name)
	{
		$sql = "SELECT from_name, subject 
				FROM email_msg 
				WHERE folder='INBOX' AND from_name LIKE '%".$from_name."%' AND user_id='".$id."'";
		echo $sql;
		$sth = $this->conn->prepare($sql) or die($this->errorlog($sql,$id));
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function get_answer($id)
	{
		$sql = "SELECT to_send, text_message FROM answer WHERE user_id='".$id."'";
		$sth = $this->conn->prepare($sql) or die($this->errorlog($sql,$id));
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function get_email($id)
	{
		$sql = "SELECT email from emails WHERE user_id = '".$id."'";
		$sth = $this->conn->prepare($sql)or die($this->errorlog($sql,$id));
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_COLUMN);
		return $result;
	}
	
	public function get_name($id)
	{
		$sql = "SELECT username from users WHERE id = '".$id."'";
		$sth = $this->conn->prepare($sql)or die($this->errorlog($sql,$id));
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_COLUMN);
		return $result;
	}
	
	public function move_message($id, $uid, $newfolder)
	{
		$sql = "UPDATE email_msg SET folder='$newfolder' WHERE user_id = '$id' AND msg_id='$uid' AND folder='INBOX'";
		$sth = $this->conn->prepare($sql)or die($this->errorlog($sql,$id));
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_COLUMN);
	}
}
?>