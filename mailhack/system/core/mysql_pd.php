<?

class mysql_pd {

	public $conn = null;

	function __construct() 
	{
	    /* ����������� � ���� ������ ODBC, ��������� ����� �������� */
		$dsn = 'mysql:dbname=admin_robot;host=localhost';
		$user = 'root';
		$password = '12qwaszx12';

		try {
			$conn = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo '����������� �� �������: ' . $e->getMessage();
		}
		
		return $conn;
		
	}
	
}




?>