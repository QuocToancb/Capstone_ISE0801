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
			$data['list_museum'] = $this->Model->selectAll('museum');


			$act = $this->uri->segment(3);
			$id  = $this->uri->segment(4);

			switch ($act){
				case 'view_museum_list_object':
					$query = $this->db->query("SELECT * FROM displayed_object WHERE museum_id = $id");
					$data['museum_object'] = $query->result_array();
					$data['mu_detail'] = $this->Model->selectOne('museum', array('museum_id'=>$id));	


					$data['temp']='Admin/Admin_View_Museum_Object.html';
					break;	
				case 'view_object_detail':
					echo 'asdfs'; exit;
					break;
				default:
					$data['temp']='Admin/Admin_Museum_management.html';

			}


		}
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>