<?php
require_once('libs/Smarty.class.php');
class CI_Smarty extends Smarty
{
	function __construct()
	{
		parent::__construct();//Gọi lại hàm khởi tạo của đt cha
		$this->template_dir=APPPATH.'views/templates/';
		$this->compile_dir=APPPATH.'views/templates_c/';
	}
	//Tạo Function View
	function view($file,$data)
	{
		if(is_array($data))
		{
			//Vòng lặp khai báo các biến tầng view
			foreach($data as $key=>$val)
			$this->assign($key,$val);
		} else
			$this->assign($data);
		//Gọi hiển thị tầng View
		$this->display($file.'.html');
	}
}


?>