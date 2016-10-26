<?php
		$data['url']=base_url();
		
		if (isset($_POST['btnLogin']))//Khi nút login được ấn 
		{
			$user = $this->input->post('txtUsername', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
			$pass = $this->input->post('txtPassword', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
			/*phpinfo();
			echo "Thành công";
			echo '<pre>';
			print_r($this->input->post());
			echo '</pre>';
			exit;
			*/
			
			//Kiểm tra nếu là học sinh
			
				$result = $this->Model->checkLogin($user, $pass, TRUE);
				if (is_array($result))
				{
					
					$newdata['accountlog']=$result;
					$this->session->set_userdata('accountlog',$newdata);
					print_r($this->session->userdata('accountlog')); exit;
					
					$this->Model->update('hocsinh', array('dangnhapcuoi'=> date('Y-m-d G:i:s')), array('username'=>$user, 'password'=>$pass));
					header('Location: '.base_url().'index.php/main');
				}
				else 
					$data['thongbao'] = 'Tên đăng nhập hoặc mật khẩu của bạn chưa đúng. Nếu quên mật khẩu bạn có thể dùng chức năng QUÊN MẬT KHẨU.';
			
			/*else
			{
				$result = $this->Model->checkLogin($user, $pass);
				if (is_array($result))
				{
					$newdata['accountlog']=$result;
					$this->session->set_userdata('accountlog',$newdata);
					$this->Model->update('nhanvien', array('dangnhapcuoi'=> date('Y-m-d G:i:s')), array('username'=>$user, 'password'=>$pass));
					header('Location: '.base_url().'index.php/main');
				}
				else
					$data['thongbao'] = 'Tên đăng nhập hoặc mật khẩu của bạn chưa đúng. Nếu quên mật khẩu xin hãy liên hệ với email chamsockhachhang@unix.vn';
			}			*/
			///$data['thongbao']='Hình như sai tên tài khoản hoặc mật khẩu mất rồi!';
		}
				
		$this->smarty->view('login', $data); //Load tầng view và truyền thêm biến $data(file HTML)
?>