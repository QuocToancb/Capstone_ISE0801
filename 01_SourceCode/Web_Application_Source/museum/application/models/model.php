<?php

Class Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Phương thức check login
	function checkLogin($user, $pass)
	{
		$param = array('email' => $user, 'password' => $pass);
		$query = $this->db->get_where('account', $param); //Kiểm tra db xem có thông tin bản ghi của tk và mk đó không
		if ($query->num_rows() > 0 ) //Nếu trả về dữ liệu (trong db có bản ghi của tk và mk đó)
		{
			$detail = $query->row_array();//trả về dữ liệu dạng mảng theo tên, chỉ trả về 1 dòng đầu tiên	
			$this->session->set_userdata('nhomnguoidungss', $detail['group_id']);	
			return $query->row_array(); //trả về dữ liệu dạng mảng theo tên, chỉ trả về 1 dòng đầu tiên
				//return $query->result(); //trả về dữ liệu dạng mảng obj
		}
		
		
		
		/*if ($hs==TRUE)//Nếu là học sinh
		{
			$query = $this->db->get_where('hocsinh', $param);
			if ($query->num_rows() > 0)
			{// login thành công							
				return $query->row_array(); //trả về dữ liệu dạng mảng theo tên, chỉ trả về 1 dòng đầu tiên
				//return $query->result(); //trả về dữ liệu dạng mảng obj
			}
		}
		else
		{
			$query = $this->db->get_where('nhanvien', $param);
			//Nếu trả về dữ liệu (ít nhất 1 dòng thì..)
			if ($query->num_rows() > 0)
			{// login thành công			
				$detail = $query->row_array();//trả về dữ liệu dạng mảng theo tên, chỉ trả về 1 dòng đầu tiên
				$temp = $this->selectAll('taikhoan_nhomnguoidung', array('account_id'=>$detail['account_id']));
				$this->session->set_userdata('nhomnguoidungss', $temp);	
				return $query->row_array(); //trả về dữ liệu dạng mảng theo tên, chỉ trả về 1 dòng đầu tiên
				//return $query->result(); //trả về dữ liệu dạng mảng obj
			}	
			
		}*/
		return false; //login không thành công
	}
	//PT selectall: lấy về danh sách dữ liệu
	function selectAll($table, $param=array(), $order=array(), $p=0, $link='')
	{
		$query = $this->db->get_where($table, $param);
		if (count($order)>0) $this->db->order_by($order[0], $order[1]);
		//Cấu hình phân trang
		if ($p>0)
		{
				$config['base_url'] = $link;
				$config['total_rows'] = $query->num_rows();
				$config['per_page'] = $p;
				$this->pagination->initialize($config);
				$offset = $this->uri->segment(3);
				$query = $this->db->get_where($table, $param,$p, $offset);
		}
		$result = $query->result_array();
		return $result;
	}
	function selectOne($table, $param=array())
	{
		$query = $this->db->get_where($table, $param);
		$result= $query->row_array();
		return $result;
	}
	function insert($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	function update($table, $data, $condi=array())
	{
		$this->db->update($table, $data, $condi);	
	}
	function delete($table, $condi=array())
	{
		$this->db->delete($table, $condi);
	}
	function checkRole($group_id)
	{
		$func=$this->uri->segment(2);
		if ($func=='') $func='home';
		$act='';
		$act=$this->uri->segment(3);
		if ($act=='' || is_numeric($act))
		{
				if ( is_array($group_id))//Nếu người đăng nhập có nhiều quyền thì: ghép chuỗi rồi đưa vào câu truy vấn
				{
					$nhomnguoidung = '';
					foreach ($group_id as $val)
						$nhomnguoidung .= ','.$val['group_id'];
					$nhomnguoidung = trim($nhomnguoidung, ','); //cắt bỏ dấu phẩy ở hai đầu
				} else $nhomnguoidung = $group_id;
				
				$query=$this->db->query("SELECT * FROM group_role_action WHERE group_id IN ($nhomnguoidung) AND role_id IN (SELECT role_id FROM role WHERE role_function='$func')");			
				if ($query->num_rows() > 0) return true;
		}				
		else
		{
			if ( is_array($group_id))//Nếu người đăng nhập có nhiều quyền thì: ghép chuỗi rồi đưa vào câu truy vấn
			{
				$nhomnguoidung = '';
				foreach ($group_id as $val)
					$nhomnguoidung .= ','.$val['group_id'];
				$nhomnguoidung = trim($nhomnguoidung, ','); //cắt bỏ dấu phẩy ở hai đầu
				$query=$this->db->query("SELECT * FROM group_role_action WHERE group_id  IN ($nhomnguoidung) AND action_id IN (SELECT action_id FROM action WHERE action_title='$act') AND role_id IN (SELECT role_id FROM role WHERE role_function='$func')");
		
				if ($query->num_rows() > 0) return true;
			}			
		}
		
		return false;
	}
	//Hàm load menu ở trang index ()
	function loadMenu($url, $group_id, $parent=0)
	{
		$icon = array('icon-home4', 'icon-copy', 'icon-list-unordered');
		$active = $this->uri->segment(2);
		if ( is_array($group_id))//Nếu người đăng nhập có nhiều quyền thì: ghép chuỗi rồi đưa vào câu truy vấn
		{
				$nhomnguoidung = '';
				foreach ($group_id as $val)
					$nhomnguoidung .= ','.$val['group_id'];
				$nhomnguoidung = trim($nhomnguoidung, ','); //cắt bỏ dấu phẩy ở hai đầu
		} else $nhomnguoidung = $group_id;
		$query = $this->db->query("SELECT role_title, role_function, role_id 						  
							FROM role WHERE role_id IN
						 	 (SELECT role_id FROM group_role_action 
						      WHERE group_id IN ($nhomnguoidung) ) 
						AND role_function!='home' ");
		$result = $query->result_array();
		
		//return $result;
		if (is_array($result) && count($result)>0)
		{
				
				foreach ($result as $num => $item)
				{
					//if ($item['role_function'] == $active) echo '<li class="active">'; else echo "<li>";	
					echo '						
								<li ';
								if ($active == $item['role_function']) echo " class = 'active' ";
								echo '><a href="'.$url.'index.php/main/'.$item['role_function'].'"><i class="'.$icon[$num].'"></i> <span>'.$item['role_title'].'</span></a></li>
								';				
				}
		/*	if ( is_array($group_id))//Nếu người đăng nhập có nhiều quyền thì: ghép chuỗi rồi đưa vào câu truy vấn
			{
				$nhomnguoidung = '';
				foreach ($group_id as $val)
					$nhomnguoidung .= ','.$val['group_id'];
				$nhomnguoidung = trim($nhomnguoidung, ','); //cắt bỏ dấu phẩy ở hai đầu
			}  else $nhomnguoidung = $group_id;
			$query2 = $this->db->query("SELECT QUYENTRUYCAP_title, QUYENTRUYCAP_function, QUYENTRUYCAP_parent, role_id, span_class
						  FROM quyentruycap WHERE role_id IN
						  (SELECT role_id FROM group_role_action 
						      WHERE group_id IN ($nhomnguoidung)) 
						  AND QUYENTRUYCAP_parent=$parent AND QUYENTRUYCAP_function=''");
		    $result2 = $query2->result_array();
			if (is_array($result2) && count($result2)>0)
			{
				foreach ($result2 as $stt => $item)
				{
					$stt = $stt+1;
					echo "						
								<li><a href='index.html'><i class='icon-home4'></i> <span>Quản lí hiện vật</span></a></li>
								<li><a href='Request_user.html'><i class='icon-copy'></i> <span>Yêu cầu đã gửi<span class='label bg-blue-400'>10</span></span></a></li>								
								<li class='active'><a href='About_user.html'><i class='icon-list-unordered'></i> <span>Thông tin bảo tàng</a></li>		
					
					";
					
					echo "<li class='panel panel-default' id='dropdown'>
									<a data-toggle='collapse' href='#dropdown-lvl$stt'>
										<span class='".$item['span_class']."'></span> ".$item['QUYENTRUYCAP_title']."
									<span class='caret'></span></a>

									<div id='dropdown-lvl$stt' class='panel-collapse collapse'>
										<div class='panel-body'>
											<ul class='nav navbar-nav'>";
				
					$this->loadMenu($url, $group_id, $item['role_id']);
					echo "</ul></div><div></li>";
				}
			}  */
		}

	}
	//Hàm convert tiếng việt có dấu thành không dấu. ví dụ môn học có tên Tiếng Pháp , thì mã môn sẽ thành: TiengPhap
	function removeUnicode($str)
	{    
		if ($str == '')        return false;    $str = trim($str);    $chars = array(            'a'=>array(            'ấ',                    'ầ',                    'ẩ',                    'ẫ',                    'ậ',                    'Ấ',                    'Ầ',                    'Ẩ',                    'Ẫ',                    'Ậ',                    'ắ',                    'ằ',                    'ẳ',                    'ẵ',                    'ặ',                    'Ắ',                    'Ằ',                    'Ẳ',                    'Ẵ',                    'Ặ',                    'á',                    'à',                    'ả',                    'ã',                    'ạ',                    'â',                    'ă',                    'Á',                    'À',                    'Ả',                    'Ã',                    'Ạ',                    'Â',                    'Ă'            ),            'e'=>array(                    'ế',                    'ề',                    'ể',                    'ễ',                    'ệ',                    'Ế',                    'Ề',                    'Ể',                    'Ễ',                    'Ệ',                    'é',                    'è',                    'ẻ',                    'ẽ',                    'ẹ',                    'ê',                    'É',                    'È',                    'Ẻ',                    'Ẽ',                    'Ẹ',                    'Ê'            ),            'i'=>array(                    'í',                    'ì',                    'ỉ',                    'ĩ',                    'ị',                    'Í',                    'Ì',                    'Ỉ',                    'Ĩ',                    'Ị',                    'î'            ),            'o'=>array(                    'ố',                    'ồ',                    'ổ',                    'ỗ',                    'ộ',                    'Ố',                    'Ồ',                    'Ổ',                    'Ô',                    'Ộ',                    'ớ',                    'ờ',                    'ở',                    'ỡ',                    'ợ',                    'Ớ',                    'Ờ',                    'Ở',                    'Ỡ',                    'Ợ',                    'ó',                    'ò',                    'ỏ',                    'õ',                    'ọ',                    'ô',                    'ơ',                    'Ó',                    'Ò',                    'Ỏ',                    'Õ',                    'Ọ',                    'Ô',                    'Ơ'            ),            'u'=>array(                    'ứ',                    'ừ',                    'ử',                    'ữ',                    'ự',                    'Ứ',                    'Ừ',                    'Ử',                    'Ữ',                    'Ự',                    'ú',                    'ù',                    'ủ',                    'ũ',                    'ụ',                    'ư',                    'Ú',                    'Ù',                    'Ủ',                    'Ũ',                    'Ụ',                    'Ư'            ),            'y'=>array(                    'ý',                    'ỳ',                    'ỷ',                    'ỹ',                    'ỵ',                    'Ý',                    'Ỳ',                    'Ỷ',                    'Ỹ',                    'Ỵ'            ),            'd'=>array(                    'đ',                    'Đ'            ),            ''=>array(                    '/',                    '\\',                    ',',                    '.',                    '"',                    '\"',                    '-',                    "&quot;",                    '*',                    '{',                    '}',                    '<',                    '>',                    '(',                    ')',                    '&lt;',                    '&gt;',                    '?',                    "'",                    "\'",                    '~',                    '#',                    '^',                    '“',                    '”',                    ':',                    ';',                    '&',                    '&amp;',                    '+',                    '=',                    '%',                    '$',                    '@',                    '!',                    "'"            ),            'pc'=>array(                    '%'            ),            '-'=>array(                    ' ',                    '%20',                    '_'            )    );   
	 foreach ($chars as $key=>$arr)        
	 	foreach ($arr as $val)            
			$str = str_replace($val, $key, $str);
			
	 $str = str_replace('-','', $str);
     return $str;
	}
}


?>