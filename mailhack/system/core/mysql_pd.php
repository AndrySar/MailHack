<?

class mysql_pd {

	public $conn = null;

	function __construct() 
	{
	    /* Подключение к базе данных ODBC, используя вызов драйвера */
		$dsn = 'mysql:dbname=admin_robot;host=localhost';
		$user = 'root';
		$password = '12qwaszx12';

		try {
			$conn = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
		
		return $conn;
		
	}
	
}




?>