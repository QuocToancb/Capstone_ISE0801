<?php
		$data['url']=base_url();
		$account = $this->session->userdata('accountlog');
		$data['account']=$account['accountlog']; //đưa ra thông tin người dùng ta tầng view
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss'); //gán vào biến trung gian rồi đưa ra
		$data['nhomnguoidung']=$this->session->userdata('nhomnguoidungss'); //đưa nhóm người dùng (quyền)ra
		$this->norole=$this->Model->checkRole($nhomnguoidung);
		if ($this->norole==false) //Nếu không có quyền truy cập thì:
			header('Location: '.base_url().'index.php/main/norole');
		else	//Nếu có quyền truy cập thì load
		{
			//Load Data base tu museum request
			$query = $this->db->query("SELECT * FROM museum_request, displayed_object WHERE museum_request.do_id = displayed_object.do_id and museum_request.museum_id = ".$account['museum_id']." and museum_request.request_status = 0");
			$data['museum_request'] = $query->result_array();
			// chuyen huong den User_Requested.html
			$data['temp']='User/User_Requested.html';		
		}
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>