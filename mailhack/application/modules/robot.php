<?php

class Robot {
	
	public function __construct() 
	{
		$this->view = new view();
		$this->db = new m_robot();
	}
	
	public function robotinfo()
	{
		$this->view->cp_show('robot/robotinfo');
	}
	
	public function del()
	{		
		if(isset($_REQUEST['delete_from']) && strlen($_REQUEST['delete_from']) > 0)
		{
			$str = array_values($_REQUEST)[2];
			$folder = array_keys($_REQUEST)[2];
			$arr = explode(", ",$str);
			$this->db->unset_delete();
			foreach($arr as $val)
			{
				$this->db->delete_set($val);
			}
			sleep(1);
			$_SESSION['_USER']['delete'] = $this->db->delete_get();
			$this->view->cp_show('robot/delete',$data);
		}
		else
		{
			$_SESSION['_USER']['delete'] = $this->db->delete_get();
			$this->view->cp_show('robot/delete');
		}
	}
	
	public function sorting()
	{	
		if(count($_REQUEST)==3)
		{
			$str = array_values($_REQUEST)[2];
			$folder = array_keys($_REQUEST)[2];
			$arr = explode(", ",$str);
			$this->db->unset_sorting($folder);
			foreach($arr as $val)
			{
				$this->db->sorting_set($folder, $val);
			}
			sleep(1);
			$_SESSION['_USER']['sorting'] = $this->db->sorting_get();
			$this->view->cp_show('robot/sorting',$data);
		}
		else
		{
			$_SESSION['_USER']['sorting'] = $this->db->sorting_get();
			$this->view->cp_show('robot/sorting');
		}
	}
	
	public function answer()
	{
		if(count($_REQUEST) > 2)
		{
			$array = array_splice($_REQUEST, 2);
			$arr = array();
			
			foreach($array as $value)
			{
				$arr[] = $value;
			}
			$this->db->unset_answer();
			for ($i=0; $i<count($arr); $i+=2)
			{
				$j = $i+1;
				if(strlen($arr[$i])>0)
				{
					$this->db->answer_set($arr[$i], $arr[$j]);
				}
			}
		}

		$_SESSION['_USER']['answer'] = $this->db->answer_get();
		$this->view->cp_show('robot/answer',$data);
	}
	
	public function search()
	{	
		if(count($_REQUEST)==3 && strlen(array_values($_REQUEST)[2])>0)
		{
			$key = array_values($_REQUEST)[2];
			$_SESSION['_USER']['search'] = $this->db->search_get($key);
		}
		else
		{
			unset($_SESSION['_USER']['search']);
		}
		$this->view->cp_show('robot/search');
	}
	
}
?>