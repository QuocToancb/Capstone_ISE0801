<?php
		$data['url']=base_url();
		
		 if (isset($_POST['btnRequestAccout']))//Khi nút login được ấn 
			{
				$email = $this->input->post('txtEmail', TRUE); // returns all POST items with XSS filter - Lọc chuỗi, chống hack XSS
				$temp_password = $this->input->post('txtPassword', TRUE); 
				$created_time = date("Y-m-d H:i:s", time()) ;
				$status = 2; // (0 = De-active ; 1 = Active ; 2 = Pending)

				$name = $this->input->post('txtMuseumName', TRUE);
				$house = $this->input->post('txtHouseno', TRUE);
				$street = $this->input->post('txtStreet', TRUE);
				$city = $this->input->post('txtCity', TRUE);
				$phone = $this->input->post('txtPhone', TRUE);
				$website = $this->input->post('txtWebsite', TRUE);
			
				$password = md5($temp_password);

				$this->Model->insert('account',
						array(	
								'email'				=>$email, 
								'password'			=>$password ,
								'created_time'		=>$created_time, 
								'status'			=>$status
						)
					);

				$data['account'] = $this->Model->selectOne('account', array('email'=>$email));
				$account_id =  $data['account']['account_id']; // Lấy account_ID của tài khoản mới tạo

				$this->Model->insert('museum',
						array(	
								'account_id'		=>$account_id, 
								'museum_name'		=>$name, 
								'museum_house_no'	=>$house, 
								'museum_street'		=>$street, 
								'museum_city'		=>$city, 
								'museum_phone'		=>$phone,
								'museum_website'	=>$website
						)
					);

				
				echo "tao thành công"; exit;		
			
		 	}
				
		$this->smarty->view('register', $data); //Load tầng view và truyền thêm biến $data(file HTML)
?>