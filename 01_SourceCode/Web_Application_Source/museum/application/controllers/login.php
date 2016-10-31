<?php
		$data['url']=base_url();
		
		if (isset($_POST['btnLogin']))//Khi nút login được ấn 
		{
			$user = $this->input->post('txtEmail', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
			$pass = $this->input->post('txtPassword', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
			
			
			$result = $this->Model->checkLogin($user, $pass, TRUE);
			if (is_array($result))
			{
				if($result['status'] == 1 ){ //Tài khoản ở trạng thái active	
					$newdata['accountlog']=$result;
					$museum_info = $this->Model->selectOne('museum', array('account_id' =>$result['account_id']));					
					$newdata['museum_id'] = $museum_info['museum_id']; 	//đưa id bảo tàng vào sesion			
					$this->session->set_userdata('accountlog',$newdata);
					header('Location: '.base_url().'index.php/main/home');
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