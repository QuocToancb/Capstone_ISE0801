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
						//$data['temp']='User/User_Add_Object.html';
						$data['title'] = 'Quan li';
			}
				
		}

		

				
				
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>