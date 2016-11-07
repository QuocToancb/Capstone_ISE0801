<?php
		$data['url']=base_url();
		$account = $this->session->userdata('accountlog');
		$data['account']=$account['accountlog']; //đưa ra thông tin người dùng ta tầng view
		$nhomnguoidung = $this->session->userdata('nhomnguoidungss'); //gán vào biến trung gian rồi đưa ra
		$data['nhomnguoidung']=$this->session->userdata('nhomnguoidungss'); //đưa nhóm người dùng (quyền)ra
		$data['museum_log']=$this->Model->selectOne('museum', array('account_id' =>$data['account']['account_id']));
		$this->norole=$this->Model->checkRole($nhomnguoidung);
		if ($this->norole==false) //Nếu không có quyền truy cập thì:
			header('Location: '.base_url().'index.php/main/norole');
		else	//Nếu có quyền truy cập thì load
		{		
				$data['museum_info'] = $this->Model->selectOne('museum', array('account_id'=>$nhomnguoidung));	
				
				if (isset($_POST['btnSave']))//Khi nút Submit thì lưu lại thông tin mới (đã sửa) của bảo tàng
				{
					$name = $this->input->post('txtMuseumName', TRUE);
					$house = $this->input->post('txtHouseno', TRUE);
					$street = $this->input->post('txtStreet', TRUE);
					$city = $this->input->post('txtCity', TRUE);
					$phone = $this->input->post('txtPhone', TRUE);
					$website = $this->input->post('txtWebsite', TRUE);
					
					//Update thông tin
					$this->Model->update('museum',
						array(
								'museum_name'		=>$name, 
								'museum_house_no'	=>$house, 
								'museum_street'		=>$street, 
								'museum_city'		=>$city, 
								'museum_phone'		=>$phone,
								'museum_website'	=>$website
							), 
						array(
								'account_id'=>$nhomnguoidung
							)
					);
					//echo 'testing'.$nhomnguoidung['account_id'];
					header('Location: '.$data['url'].'index.php/main/user_museum_info');									
					
				}
				
				$data['temp']='User/User_Museum_info.html';			
		}
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>