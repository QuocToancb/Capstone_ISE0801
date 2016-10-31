<?php
//Tạo đối tượng Main bắt buộc kế thừa từ đối tượng CI_Controller
class Main extends CI_Controller
{
	public $norole=false;
	//PT khởi tạo của đối tượng Main: luôn tự động được chạy 
	function __construct()
	{
		parent::__construct();//Gọi lại  PT khởi tạo của đối tượng cha
				//Phương thức gọi thư viện trong CI
		$this->load->library('session');
		$this->load->helper('url');//Gọi thư viện HELP để sử dụng hàm base_url
		//kết nối với tầng model
		$this->load->model('Model');
		$this->load->library('pagination');
		$data['url']=base_url();		
		$this->load->library('smarty');//Load thư viện smarty để tách tầng view thành file html
		//$this->load->library('PHPExcel');//Load thư viện PHPExcel để đọc file excel
		
		$this->load->library('pagination'); //Thư viện phân trang
		date_default_timezone_set('Asia/Ho_Chi_Minh');	
	}
	//Phương thức index (PT do CI định nghĩa): tự động đc gọi khi ko có PT nào đc gọi
	function index()
	{		
		$data['url']=base_url();
		$data['menudacap'] = $this->Model;
		$this->smarty->view('trangchu',$data);
	}
	function home()
	{	
		$data['url']=base_url();
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load home	
			{
				$data['account'] = $account['accountlog'];
				$data['nhomnguoidung'] = $nhomnguoidung;
				$data['menudacap'] = $this->Model;
				$this->smarty->view('home',$data);
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	//Phương thức đăng nhập
	function login()
	{
		require_once('login.php');
	}

	function register()
	{
		require_once('register.php');
	}

	//Phương thức đổi mật khẩu
	function changepwd()
	{
		$data['url']=base_url();
		
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  
		//Nếu là học sinh (biến $nhomnguoidung rỗng )thì
		if ( ! is_array($nhomnguoidung))
			$nhomnguoidung = $account['accountlog']['NHOMNGUOIDUNG_id'];
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load index	
			{
				require_once('changepwd.php');
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	//phương thức đăng xuất
	function logout()
	{
		$this->session->unset_userdata('accountlog');
		$newdata['accountlog']='';
		$this->session->set_userdata($newdata);
		$this->session->sess_destroy();
		header('Location: '.base_url().'index.php');
	}
	
	//Nếu không có quyền thì điều hướng sang norole
	function noRole()
	{
		$data=array();
		$this->smarty->view('norole', $data);
	}
	//Công thức tính lương
	function congthuctinhluong()
	{	
		$data['url']=base_url();
		
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  		
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load index	
			{
				require_once('congthuctinhluong.php');
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	function user_museum_info()
	{	
		$data['url']=base_url();
		
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  		
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load index	
			{
				require_once('user_museum_info.php');
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	
	function user_requested()
	{	
		$data['url']=base_url();
		
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  		
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load index	
			{
				require_once('user_requested.php');
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	function user_manage_object()
	{	
		$data['url']=base_url();
		
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  		
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load index	
			{
				require_once('user_manage_object.php');
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	function admin_manage_museum()
	{
		$data['url']=base_url();
		
		$account = $this->session->userdata('accountlog');
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss');  		
		if (is_array($account))
		{//Nếu login rồi thì
			$this->norole=$this->Model->checkRole($nhomnguoidung);
			//Nếu không có quyền truy cập thì:	
			if ($this->norole==false) 
				header('Location: '.base_url().'index.php/main/norole');
			else	//Nếu có quyền truy cập thì load index	
			{
				require_once('admin_manage_museum.php');
			}
		}
		else //nếu chưa login thì chuyển qua trang login
			header('Location: '.base_url().'index.php/main/login');
	}
	function upload()
	{
		$tenfile = $this->uri->segment(4);
		$folder = $this->uri->segment(3);
		//Mảng cấu hình cho chức năng upload file
		$config['upload_path'] = './uploads/'.$folder;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|xls|xlsx|doc|docx|pdf|JPG|JPEG|PNG|DOC|DOCX|XLS|XLSX';
		$config['max_size']	= '2000';
		$config['overwrite']= TRUE;
		$config['max_width']  = '3000';
		$config['max_height']  = '3000';
		$config['file_name'] = "$tenfile";
		$this->load->library('upload', $config);
			
		if ( ! $this->upload->do_upload('formup'))
			echo 'Error';
		else 
			$detail_file = array('upload_data' => $this->upload->data());
			//Trả về trên file và đuôi mở rộng
			echo $detail_file['upload_data']['file_name'];
	}
	function crop()
	{
		$this->load->library('image_lib');
		
		$img = './uploads/hocsinh/house.jpg';
		list($width, $height, $type, $attr) = getimagesize($img);

        
        $config['image_library'] = 'gd2';
        $config['source_image'] = $img;
        $config['x_axis'] = '70';
        $config['y_axis'] = '70';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width-200;
        $config['height'] = $height-200;
		$config['new_image']= './uploads/hocsinh/test';
		//$config['image_library'] = 'imagemagick';
		//$config['library_path'] = '/usr/X11R6/bin/';
		
		
		$this->image_lib->initialize($config); 
		
		if ( ! $this->image_lib->crop())
		{
			echo $this->image_lib->display_errors();
		} else echo 'crop successfully';
	}


}
//date(strtotime($mysql_date), "d-m-Y")) convert
?>

