<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-30 20:30:44
         compiled from "application\views\templates\Admin\Admin_Museum_management.html" */ ?>
<?php /*%%SmartyHeaderCode:281095815ebd1074ed3-10960173%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1acf367a0c0c6a3044f37d974b8f44d354edbada' => 
    array (
      0 => 'application\\views\\templates\\Admin\\Admin_Museum_management.html',
      1 => 1477834238,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '281095815ebd1074ed3-10960173',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5815ebd1085f12_22981599',
  'variables' => 
  array (
    'list_museum' => 0,
    'stt' => 0,
    'url' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5815ebd1085f12_22981599')) {function content_5815ebd1085f12_22981599($_smarty_tpl) {?>
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Quản lí bảo tàng</span></h4>
						</div>											
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Quản lí bảo tàng</li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
				<!-- Basic datatable -->
					<div class="panel panel-flat">
						<table class="table datatable-basic">
							<thead>
								<tr>
									<th class="col-md-1">STT</th>
									<th class="col-md-3">Tên bảo tàng</th>
									<th class="col-md-2">SL hiện vật sẵn sàng</th>
									<th class="col-md-2">SL hiện vật kích hoạt</th>
									<th class="col-md-2">Yêu cầu đang chờ xử lí</th>
									<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['stt'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list_museum']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['stt']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
								<tr>
									<td><?php echo $_smarty_tpl->tpl_vars['stt']->value+1;?>
</th>
									<td><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
index.php/main/admin_manage_museum/view_museum_list_object/<?php echo $_smarty_tpl->tpl_vars['item']->value['museum_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['museum_name'];?>
</a></td>
									<td>3</td>
									<td>3</td>
									<td>3</td>
									<td class="text-center">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
													<li><a data-toggle="modal" href="#edit_modal"><i class="icon-file-pdf" data-toggle="modal" data-target="#modal_default" ></i> Xem các yêu cầu</a></li>																																						
												</ul>
											</li>
										</ul>
									</td>
								</tr>					            
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

									<form action="#">
									<div class="modal-body">
										<div class="form-group">
											
											<div class="row">	
												<div class="col-sm-12">											
												<input type="textarea" placeholder="Lý do gửi yêu cầu" class="form-control">
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
										<button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
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

									<form action="#">
									<div class="modal-body">
										<div class="form-group">
											
											<div class="row">	
												<div class="col-sm-12">											
												<input type="textarea" placeholder="Lý do gửi yêu cầu" class="form-control">
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
										<button type="submit" class="btn btn-danger">Gửi yêu cầu</button>
									</div>
									</form>
								</div>
							</div>
						</div>
					<!-- /Request to Delete Modal -->
					</div>
					<!-- /basic datatable -->
					


					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->
<?php }} ?>
