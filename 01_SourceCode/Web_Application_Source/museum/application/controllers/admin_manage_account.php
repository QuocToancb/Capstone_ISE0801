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
			
			$query = $this->db->query("SELECT * FROM museum, account WHERE museum.account_id = account.account_id");	
			$data['manage_account'] = $query->result_array();
			$data['temp']='Admin/Admin_Manage_Account.html';
			
			$act = $this->uri->segment(3);
			$id  = $this->uri->segment(4);
			echo $id;
			
				switch($act)
				{
					case 'admin_new_account':
						if (isset($_POST['btnSave']))//Khi nút Them moi hien vat thì them moi hien vat của bảo tàng
					 	{	
							$new_email = $this->input->post('txtEmail', TRUE);
							$new_password = $this->input->post('txtPassword', TRUE);
							$create_time = date("Y-m-d H:i:s", time()) ;
							$status = $this->input->post('status', TRUE);// trạng thái 1=acitve hay 0=deactive
							$role = $this->input->post('txtRole', TRUE); // quyền truy cập 2=museum hay là 1=addmin

							$museum_name = $this->input->post('txtMuseumName', TRUE);
							$house = $this->input->post('txtHouse', TRUE);
							$street = $this->input->post('txtStreet', TRUE);
							$city = $this->input->post('txtCity', TRUE);
							$phone = $this->input->post('txtPhone', TRUE);
							$website = $this->input->post('txtWebsite', TRUE);
							//$metadata = $this->input->post('txtMetadata', TRUE);

							//Insert thông tin in  table
							$this->Model->insert('account',
								array(
										'email'			=>$new_email, 
										'password'		=>$new_password, 
										'status'		=>$status,
										'created_time'	=>$create_time
									)
							);
							$data['account'] = $this->Model->selectOne('account', array('email'=>$new_email));
					 		$account_id_new =  $data['account']['account_id']; // Lấy Account_ID của tài khoản mới thêm

							$this->Model->insert('museum', // Thêm thông tin vào bảo museum.
								array(
										'account_id'		=>$account_id_new, 
										'museum_name'		=>$museum_name, 
										'museum_house_no'	=>$house,
										'museum_street'		=>$street,
										'museum_city'		=>$city,
										'museum_phone'		=>$phone,
										'museum_website'	=>$website

									)
							);
							}

							$data['temp']='Admin/Create_Account_Page.html';
						break;

					case 'edit_account':
					  $query = $this->db->query("SELECT * FROM account, museum, account_group WHERE (museum.account_id = account.account_id) and (account.account_id = account_group.account_id) and  (account.account_id = $id)");
					 	$data['edit_account'] = $query->result_array();
					if (isset($_POST['btnSave']))//Khi nút Them moi hien vat thì them moi hien vat của bảo tàng
					 	{

							$museum_email = $this->input->post('txtEmail', TRUE);
							$museum_password = $this->input->post('txtPassword', TRUE);
							$create_time = date("Y-m-d H:i:s", time()) ;
							$status = $this->input->post('status', TRUE);// trạng thái 1=acitve hay 0=deactive
							$role = $this->input->post('txtRole', TRUE); // quyền truy cập 2=museum hay là 1=addmin

							$museum_name = $this->input->post('txtMuseumName', TRUE);
							$house = $this->input->post('txtHouse', TRUE);
							$street = $this->input->post('txtStreet', TRUE);
							$city = $this->input->post('txtCity', TRUE);
							$phone = $this->input->post('txtPhone', TRUE);
							$website = $this->input->post('txtWebsite', TRUE);
							//$metadata = $this->input->post('txtMetadata', TRUE);

							//Insert thông tin in Target_Object table
							$this->Model->update('account',
								array(
										'password'		=>$museum_password, 
										'status'		=>$status
									),
								array(
									'account_id'=>$id )
							);
							$this->Model->update('account_group',
								array(
										'password'		=>$museum_password, 
										'status'		=>$status
									),
								array(
									'account_id'=>$id )
							);
						header('Location: '.$data['url'].'index.php/main/admin_manage_account');	
					}	
						$data['temp']='Admin/Admin_Edit_Account.html';

						break;
					case 'edit':
						break;
				}

		}
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>