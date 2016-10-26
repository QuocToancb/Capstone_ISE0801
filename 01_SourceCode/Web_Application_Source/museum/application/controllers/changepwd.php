<?php

		$data['url']=base_url();
		$account = $this->session->userdata('accountlog');
		$data['account']=$account['accountlog']; //đưa ra thông tin người dùng ta tầng view
		//$nhomnguoidung = $this->session->userdata('nhomnguoidungss'); //gán vào biến trung gian rồi đưa ra
		if ( is_array($this->session->userdata('nhomnguoidungss'))) //Nếu là nhân viên (nhomnguoidungss) là mảng
			$data['nhomnguoidung']=$this->session->userdata('nhomnguoidungss'); //đưa nhóm người dùng (quyền)ra
		else //Nếu là học sinh thì đưa 'NHOMNGUOIDUNG_id ra
			$data['nhomnguoidung'] = $account['accountlog']['NHOMNGUOIDUNG_id'];
		

		$username = $account['accountlog']['username'];
		if (isset($_POST['btnChangepwd']))
		{
				$test_nhanvien = $this->Model->selectOne('nhanvien', array('username' => $username,
																	  'password' => $this->input->post('txtOldpwd', TRUE)));
				$test_hocsinh = $this->Model->selectOne('hocsinh', array('username' => $username,
																	  'password' => $this->input->post('txtOldpwd', TRUE)));														  
				if ( count($test_nhanvien)>0 || count($test_hocsinh)>0 )	
				{
						if (count($test_nhanvien)>0)
						{//Nếu tồn tại tài khoản và mật khẩu cũ trong db thì update mật khẩu
							$this->Model->update('nhanvien', array('password' => $this->input->post('txtNewpwd')),
															 array('username' => $username));
							$data['thongbao'] = 'Bạn đã đổi mật khẩu thành công nhé!';
						}
						if (count($test_hocsinh)>0)
						{//Nếu tồn tại tài khoản và mật khẩu cũ trong db thì update mật khẩu
							$this->Model->update('hocsinh', array('password' => $this->input->post('txtNewpwd')),
															 array('username' => $username));
							$data['thongbao'] = 'Bạn đã đổi mật khẩu thành công nhé!';
						}
				}
				else  //Nếu không tồn tại tài khoản và mật khẩu cũ trong db
					$data['thongbao'] = 'Hình như bạn nhập sai mật khẩu cũ rồi, nhập lại nhé!';
				
		}
		$data['temp']='changepwd.html';
		$data['menudacap'] = $this->Model;
		$this->smarty->view('index', $data);
	
?>