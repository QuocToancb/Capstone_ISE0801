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
			$query = $this->db->query("SELECT * FROM museum,account WHERE museum.account_id = account.account_id && account.status = 1 "); // chỉ lấy bảo tàng được kích hoạt
			$data['list_museum'] = $query->result_array();


			$act = $this->uri->segment(3);
			$id  = $this->uri->segment(4);

			switch ($act){
				case 'view_museum_list_object':
					$query = $this->db->query("SELECT * FROM  museum_request right join displayed_object on displayed_object.do_id = museum_request.do_id where displayed_object.museum_id = $id ");
					$data['museum_object'] = $query->result_array();
					
					$data['mu_detail'] = $this->Model->selectOne('museum', array('museum_id'=>$id));	

					// $query = $this->db->query("SELECT * FROM request_info WHERE do_id = $id");
					// $data['request_info'] = $this->Model->selectOne('museum_request', array('do_id'=>$id));


					$data['temp']='Admin/Admin_View_Museum_Object.html';
					break;	
				case 'view_object_detail':
					$data['ob_detail'] = $this->Model->selectOne('displayed_object', array('do_id'=>$id));	
					$data['target_detail'] = $this->Model->selectOne('target_object', array('target_id'=>$data['ob_detail']['target_id']));

					$data['temp']='Admin/Admin_View_Object.html';
					break;
				case 'manage_request_museum':
					$query = $this->db->query("SELECT * FROM  museum_request, displayed_object where displayed_object.do_id = museum_request.do_id and displayed_object.museum_id = $id and museum_request.request_status = 0");
					$data['museum_object'] = $query->result_array();
					$data['museum_detail'] = $this->Model->selectOne('museum', array('museum_id'=>$id));
					if (isset($_POST['btnAccept']))// Nhấn nút accept đồng ý yêu cầu và gửi mail thông báo
					{
						
						$m_request_id = $this->input->post('hdnm_request_id', TRUE);
						$do_id = $this->input->post('hdndo_id', TRUE);
						$request_type = $this->input->post('hdnrequest_type', TRUE); //(0=Delete request;1=Change request; 2 active request).
						$responded_time = date("Y-m-d H:i:s", time()) ;	

						$status_expect = 0; //( Trạng thái mong muốn sửa đổi -1=Deleted, 0=Pending, 1=Available, 2=Active.)
						if($request_type == '0') $status_expect = -1;
						elseif($request_type == '1' ) $status_expect = 0;
						elseif ($request_type == '2' ) $status_expect = 2;					
						
						//Update vào bảng request
						$this->Model->update('museum_request',
							array(
									'request_status'		=> 1,  //(0 = Pending, 1=Accepted,2=Deny)
									'responded_time'	=> $responded_time
								), 
							array(
									'm_request_id'=>$m_request_id
								)
						);

						$this->Model->update('displayed_object',
							array(
									'current_status'		=> $status_expect,  									
								), 
							array(
									'do_id'=>$do_id
								)
						);
						//TODO gửi mail thông báo đã chuyển trạng thái
						//echo "phe duyệt thành công";exit;
					}

					if (isset($_POST['btnDeny']))// Nhấn nút Deny từ chối yêu cầu và gửi mail thông báo
					{
						$m_request_id = $this->input->post('hdnm_request_id', TRUE);
						$do_id = $this->input->post('hdndo_id', TRUE);
						$request_type = $this->input->post('hdnrequest_type', TRUE); //(0=Delete request;1=Change request; 2 active request).
						$responded_time = date("Y-m-d H:i:s", time()) ;	

						//Update vào bảng request
						$this->Model->update('museum_request',
							array(
									'request_status'		=> 2,  //(0 = Pending, 1=Accepted,2=Deny)
									'responded_time'	=> $responded_time
								), 
							array(
									'm_request_id'=>$m_request_id
								)
						);

						if($request_type = '2'){ //Nếu yêu cầu kích hoạt bị từ chối, chuyển về pending cho user
							$this->Model->update('displayed_object',
							array(
									'current_status'		=> 0,  		// chuyển trang thái về pending để user có thể sửa đổi							
								), 
							array(
									'do_id'=>$do_id
								)
							);
						}

						//TODO gửi mail thông báo đã bị tự chối, yêu cầu xủa đổi lại thông tin
						//echo "yêu cầu đã bị phê duyệt từ chối";exit;

					}
					

					$data['temp']='Admin/Admin_Manage_Request_Museum.html';
					break;					
				default:
					$data['temp']='Admin/Admin_Museum_management.html';

			}


		}
		$data['menudacap'] = $this->Model;
		$this->smarty->view('home', $data);
	
?>