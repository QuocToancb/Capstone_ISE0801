<?php
		$data['url']=base_url();
		
		if (isset($_POST['btnLogin']))//Khi nút login được ấn 
		{
			$email = $this->input->post('txtEmail', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
			$pass = $this->input->post('txtPassword', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
			if(empty($email)){ 
				$data['thongbao_email'] = 'Email không thể trống'; 
				$this->smarty->view('login', $data); }

			if(empty($pass)){ 
				$data['thongbao_matkhau'] = 'Mật khẩu không thể trống'; 
				$this->smarty->view('login', $data); }

			
			if(!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)){ 
				$data['thongbao_email'] = 'Không đúng định dạng email'; 
				$this->smarty->view('login', $data); }	
			
			$pass_md5 = md5($pass);

			$result = $this->Model->checkLogin($email, $pass_md5, TRUE);
			if (is_array($result))
			{
				if($result['status'] == 1 ){ //Tài khoản ở trạng thái active	
					$newdata['accountlog']=$result;
					$museum_info = $this->Model->selectOne('museum', array('account_id' =>$result['account_id']));
					$newdata['museum_info'] = $museum_info; 	//đưa id bảo tàng vào sesion
					$this->session->set_userdata('accountlog',$newdata);
					//Nếu id bảo tàng rỗng thì
					if ($museum_info['museum_id']=='')
						{
						header('Location: '.base_url().'index.php/main/admin_manage_museum');
						}
					else
						{
						header('Location: '.base_url().'index.php/main/user_manage_object');
						}
				}
				else if($result['status'] == 0){
					$data['thongbao'] = 'Tài khoản này đã bị vô hiệu';
				}else{	
					$data['thongbao'] = 'Tài khoản này đang chờ phê duyệt bởi admin';
				}
			}
			else 
				$data['thongbao'] = 'Sai địa chỉ email hoặc mật khẩu. Nếu quên mật khẩu bạn có thể dùng chức năng QUÊN MẬT KHẨU.';
			
		}
				
		$this->smarty->view('login', $data); //Load tầng view và truyền thêm biến $data(file HTML)

?>