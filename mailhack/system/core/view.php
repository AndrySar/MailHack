<?php

Class View {

	public function show($path_tpl, $array = array(), $name_theme = 'main')
	{
		$path_body = 'views/'.$path_tpl.'.php';
		$path_head = 'application/theme/'.$name_theme.'.php';		
		extract($array);
		
		ob_start();
		
		include $path_head;	
		include $path_body;
		
		global $array;
		if(count($array)>0)
		{
			foreach (get_object_vars($array) as $_ci_key => $_ci_var)
			{			
				$this->$_ci_key = $_ci_var;			
			}		
		}
			
		
		$str = ob_get_contents();
		@ob_end_clean();
		echo  $str;	
		
		exit();
	}
	
	
	public function cp_show($path_tpl, $array = array(), $name_theme = 'main')
	{
		
		if(!isset($_SESSION["_USER"]))
		{
			header("Location: ".BASE_URL."?module=welcome&method=login");
			exit();
		}
		
		
		$path_body = 'views/'.$path_tpl.'.php';
		$path_head = 'application/theme/admin/'.$name_theme.'.php';		
		$path_bottom = 'application/theme/admin/bottom.php';		
		extract($array);
		
		ob_start();
		
		include $path_head;	
		include $path_body;
		include $path_bottom;
		
		global $array;
		foreach (get_object_vars($array) as $_ci_key => $_ci_var)
		{			
			$this->$_ci_key = $_ci_var;			
		}		
		
		$str = ob_get_contents();
		@ob_end_clean();
		echo  $str;	
		
		exit();
	}
	
	
}

?>