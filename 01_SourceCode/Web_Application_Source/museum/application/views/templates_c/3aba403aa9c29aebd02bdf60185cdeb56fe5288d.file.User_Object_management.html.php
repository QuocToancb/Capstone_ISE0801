<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-30 16:01:38
         compiled from "application/views/templates/User/User_Object_management.html" */ ?>
<?php /*%%SmartyHeaderCode:176250373058146b9e56ae59-41745188%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3aba403aa9c29aebd02bdf60185cdeb56fe5288d' => 
    array (
      0 => 'application/views/templates/User/User_Object_management.html',
      1 => 1477817761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176250373058146b9e56ae59-41745188',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_58146b9e57d354_41476196',
  'variables' => 
  array (
    'museum_object' => 0,
    'item' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58146b9e57d354_41476196')) {function content_58146b9e57d354_41476196($_smarty_tpl) {?><!-- Basic datatable -->
					<div class="panel panel-flat">
						<div class="datatable-header">
						<form action="" medthod="GET">
								<div class="row form-group">
									
									<div class="col-lg-4">
										<div class="has-feedback has-feedback-left" style="margin-left:9px;">
										<input type="search" name="txtObjectname" class="form-control" placeholder="Search">
										<div class="form-control-feedback">
											<i class="icon-search4 text-size-base text-muted"></i>
										</div>
										</div>
									</div>
									<div class="col-lg-1"><button type="submit" name="btnSearch" class="btn btn-success">Tìm kiếm</button></div>
									
								</div>
							
						</form>
						</div>
						<table class="table datatable-basic">
							<thead>
								<tr>
									<th class="col-md-1">ID</th>
									<th class="col-md-2">Tên hiện vật</th>
									<th class="col-md-2">Mô tả</th>
									<th class="col-md-1">Hình ảnh</th>
									<th class="col-md-1">Thuyết minh</th>
									<th class="col-md-1">Phim tư liệu</th>
									<th class="col-md-1">Trạng thái trước</th>
									<th class="col-md-1">Trạng thái hiện tại</th>
									<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['museum_object']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
				                    <?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==0||$_smarty_tpl->tpl_vars['item']->value['current_status']==2) {?>
					                    <tr>
					                    	<td><?php echo $_smarty_tpl->tpl_vars['item']->value['do_id'];?>
</td>
											<td><a href="#"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></td>
											<td><?php echo $_smarty_tpl->tpl_vars['item']->value['text_description'];?>
</td>
											<td><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
" style="width: 58px; height: 58px; border-radius: 2px;" alt=""></a></td>
											<td>Thuyết minh</td>
											<td>Phim tư liệu</td>
											<td><?php if ($_smarty_tpl->tpl_vars['item']->value['last_status']==1) {?><span class="label label-info"> AVAILABLE</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['last_status']==0) {?><span class="label label-default"> PENDING</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['last_status']==2) {?><span class="label label-success"> ACTIVED</span><?php }?></td>
											<td><?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==1) {?><span class="label label-info"> AVAILABLE</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==0) {?><span class="label label-default"> PENDING</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==2) {?><span class="label label-success"> ACTIVED</span><?php }?></td>
											<td class="text-center">
												<ul class="icons-list">
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
															<i class="icon-menu9"></i>
														</a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a data-toggle="modal" href="#edit_modal" class="open_edit_request_form"  data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['do_id'];?>
" ><i class="icon-file-pdf" data-toggle="modal" data-target="#modal_default"></i> Yêu cầu sửa</a></li>
															<li><a data-toggle="modal" href="#delete_modal" class="open_delete_request_form" data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['do_id'];?>
"><i class="icon-file-pdf" data-toggle="modal" data-target="#modal_default" ></i> Yêu cầu xóa</a></li>
														</ul>
													</li>
												</ul>
											</td>    
					                    </tr>
					                 <?php }?>
                                <?php } ?>
							</tbody>
						</table>
						<!-- Request to Edit Modal -->
						<div id="edit_modal" class="modal fade" data-backdrop="false">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="modal-title"><span><i class="icon-pencil4"></i></span> &nbsp;Gửi yêu cầu sửa dữ liệu hiện vật</h5>
									</div>

									<form action="" method="POST">
									<div class="modal-body">
										<div class="form-group">
											<input type="hidden" name="hdndo_id" id="do_id_edit" value=""/>
											<div class="row">	
												<div class="col-sm-12">											
												<input type="textarea" name="txtreason" placeholder="Lý do gửi yêu cầu" class="form-control">
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
												<br>
													<p><i>Sau khi yêu cầu được được phê duyệt chấp nhận. Hiện vật sẽ có trạng thái "Pending", cho phép chỉnh sửa dữ liệu.</i></p>													
												</div>												
											</div>
										</div>	
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
										<button type="submit" name="btnSendEditRequest" value="btnSendEditRequest" class="btn btn-primary">Gửi yêu cầu</button>
									</div>
									</form>
								</div>
							</div>
						</div>
					<!-- /Request to Edit Modal -->
					<!-- Request to Delete Modal -->
						<div id="delete_modal" class="modal fade" data-backdrop="false">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="modal-title"><i class="icon-eraser2"></i> &nbsp;Gửi yêu cầu xóa hiện vật</h5>
									</div>

									<form action="" method="POST">
									<div class="modal-body">
										<div class="form-group">
											<input type="hidden" name="hdndo_id" id="do_id_delete" value=""/>
											<div class="row">	
												<div class="col-sm-12">											
												<input type="textarea" name="txtreason" placeholder="Lý do gửi yêu cầu" class="form-control">
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
												<br>
													<p><i>Sau khi yêu cầu được được phê duyệt chấp nhận. Hiện vật sẽ được xóa và không còn xuất hiện trong danh sách quản lí hiện vật.</i></p>													
												</div>												
											</div>
										</div>	
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
										<button type="submit" name="btnSendDeleteRequest" class="btn btn-danger">Gửi yêu cầu</button>
									</div>
									</form>
								</div>
							</div>
						</div>
					<!-- /Request to Delete Modal -->
					</div>
					<!-- /basic datatable -->
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
index.php/main/user_manage_object/add">Add new</a>
					<?php echo '<script'; ?>
>
						$(document).on("click", ".open_edit_request_form", function () {
							var do_id = $(this).data('id');
							$(".modal-body #do_id_edit").val( do_id );
						});
						$(document).on("click", ".open_delete_request_form", function () {
							var do_id = $(this).data('id');
							$(".modal-body #do_id_delete").val( do_id );
						});

					<?php echo '</script'; ?>
>
					<?php }} ?>
