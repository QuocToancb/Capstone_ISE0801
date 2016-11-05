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

				$muse_id = $account['museum_id'];

				$query = $this->db->query("SELECT * FROM displayed_object WHERE displayed_object.museum_id = $muse_id  AND (
										displayed_object.do_id NOT IN (SELECT do_id FROM museum_request 
											WHERE museum_request.request_status=0)
														) AND displayed_object.current_status IN (0,2)");	
				$data['museum_object'] = $query->result_array();

				if (isset($_POST['btnSendEditRequest']))//Khi nút Submit thì lưu lại thông tin mới (đã sửa) của bảo tàng
				{
					
					$do_id = $this->input->post('hdndo_id', TRUE);
					$museum_id = $account['museum_id'];
					$reason = $this->input->post('txtreason', TRUE);
					$request_status = 0; //(0 = Pending, 1=Accepted,2=Deny)
					$request_type = 1; //0=Delete request;1=Change request
					$sent_time = date("Y-m-d H:i:s", time()) ;
					
					//Update thông tin
					$this->Model->insert('museum_request',
						array(	
								'do_id'				=>$do_id, 
								'museum_id'			=>$museum_id, 
								'reason'			=>$reason, 
								'request_status'	=>$request_status, 
								'request_type'		=>$request_type,
								'sent_time'			=>$sent_time
						)
					);
					header('Location: '.$data['url'].'index.php/main/user_requested');
				}	

				if (isset($_POST['btnSendDeleteRequest']))//Khi nút Submit thì lưu lại thông tin mới (đã sửa) của bảo tàng
				{
					$do_id = $this->input->post('hdndo_id', TRUE);
					$museum_id = $account['museum_id'];
					$reason = $this->input->post('txtreason', TRUE);
					$request_status = 0; //(0 = Pending, 1=Accepted,2=Deny)
					$request_type = 0;
					$sent_time = date("Y-m-d H:i:s", time()) ;
					
					//Update thông tin
					$this->Model->insert('museum_request',
						array(
								'do_id'				=>$do_id, 
								'museum_id'			=>$museum_id, 
								'reason'			=>$reason, 
								'request_status'	=>$request_status, 
								'request_type'		=>$request_type,
								'sent_time'			=>$sent_time
						)
					);
					header('Location: '.$data['url'].'index.php/main/user_requested');

				}	

				if (isset($_GET['btnSearch']))//Khi nút Search thì tìm kiếm theo tên
				{
					
					$Object_name = $this->input->get('txtObjectname', TRUE);
					
					//Update thông tin
					$query = $this->db->query("SELECT * FROM displayed_object WHERE displayed_object.museum_id = $muse_id  AND (
										displayed_object.do_id NOT IN (SELECT do_id FROM museum_request 
											WHERE museum_request.request_status=0)
														) AND displayed_object.current_status IN (0,2) and name LIKE '%".$Object_name."%'");
				$data['museum_object'] = $query->result_array();

				}	

				$data['temp']='User/User_Object_management.html';	

				$act = $this->uri->segment(3);
				$id = $this->uri->segment(4);
			
				switch($act)
				{
					case 'view_object_detail':
						$data['ob_detail'] = $this->Model->selectOne('displayed_object', array('do_id'=>$id));	
						$data['target_detail'] = $this->Model->selectOne('target_object', array('target_id'=>$data['ob_detail']['target_id']));
						//echo 'xem thong tin hien vat'; exit;
						$data['temp']='User/User_View_Object.html';
						break;
					case 'edit_object_detail':
						$data['ob_detail'] = $this->Model->selectOne('displayed_object', array('do_id'=>$id));	
						$data['target_detail'] = $this->Model->selectOne('target_object', array('target_id'=>$data['ob_detail']['target_id']));
						
						if ($data['ob_detail']['current_status'] != 0){
							header('Location: '.base_url().'index.php/main/norole');
						}else{
						//echo 'SUA thong tin hien vat'; exit;
						$data['temp']='User/User_Edit_Object.html';		
						}				
						break;
					case 'add':
						if (isset($_POST['btnAddObject']))//Khi nút Them moi hien vat thì them moi hien vat của bảo tàng
						{
							
							$name = $this->input->post('txtObjectName', TRUE);
							$description = $this->input->post('txtDescription', TRUE);
							$image = $this->input->post('txtImage', TRUE);
							$audio = $this->input->post('txtAudio', TRUE);
							$video = $this->input->post('txtVideo', TRUE);
							$model = $this->input->post('txtModel', TRUE);
							$status = $this->input->post('status', TRUE);
							$target_name = $this->input->post('txtTargetName', TRUE);
							$target_image = $this->input->post('txtTargetImage', TRUE);
							$target_object3D = $this->input->post('txtTargetObject3D', TRUE);
							//$metadata = $this->input->post('txtMetadata', TRUE);

							//Insert thông tin in Target_Object table
							$this->Model->insert('target_object',
								array(
										'target_name'		=>$target_name, 
										'target_image'		=>$target_image, 
										'scaned_object'		=>$target_object3D
										//'metadata'			=>$metadata 
									)
							);

							$data['target_object'] = $this->Model->selectOne('target_object', array('target_name'=>$target_name));
							$target_id =  $data['target_object']['target_id']; // Lấy Target_ID của hiện vật mới thêm
							$this->Model->insert('displayed_object', //insert dữ liệu vào bảng Displayed_Object
								array(
										'museum_id'			=>$account['museum_id'], 
										'target_id'			=>$target_id, 
										'name'				=>$name,
										'text_description'	=>$description,
										'image'				=>$image,
										'audio'				=>$audio, 
										'video'				=>$video, 
										'model'				=>$model, 
										'audio'				=>$audio,
										'current_status'	=>$status
									)
							);
							// truong hop nguoi dung de status la avaibale thi du lieu se insert vao bang museum_request
							if ($status == 1)
							{
								$sent_time = date("Y-m-d H:i:s", time());
								$data['displayed_object'] = $this->Model->selectOne('displayed_object', array('target_id'=>$target_id));
								$do_id =  $data['displayed_object']['do_id']; 
								$this->Model->insert('museum_request', //insert dữ liệu vào bảng museum_request
								array(
										'museum_id'			=>$account['museum_id'], 
										'do_id'				=>$do_id,
										'reason'			=>"Đã sẵn sàng kích hoạt",
										'request_type'		=>2, //2 Active request
										'request_status'	=>0, // 0 Pendings
										'sent_time'			=>$sent_time
									)
								);
								header('Location: '.$data['url'].'index.php/main/user_requested');// status la available go to request
							} else 
							{
							header('Location: '.$data['url'].'index.php/main/user_manage_object');
							} // status la pending chuyen den manage
						}	
						$data['temp']='User/User_Add_Object.html';

						break;
					case 'edit':
						break;
				}
				
		}
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>