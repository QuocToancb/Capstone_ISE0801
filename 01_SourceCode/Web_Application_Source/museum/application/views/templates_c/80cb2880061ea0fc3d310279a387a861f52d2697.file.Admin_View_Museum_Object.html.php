<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-30 21:41:10
         compiled from "application\views\templates\Admin\Admin_View_Museum_Object.html" */ ?>
<?php /*%%SmartyHeaderCode:209365815f86e7a01d3-78760750%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '80cb2880061ea0fc3d310279a387a861f52d2697' => 
    array (
      0 => 'application\\views\\templates\\Admin\\Admin_View_Museum_Object.html',
      1 => 1477838466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209365815f86e7a01d3-78760750',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5815f86e7d2c11_09772427',
  'variables' => 
  array (
    'mu_detail' => 0,
    'museum_object' => 0,
    'item' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5815f86e7d2c11_09772427')) {function content_5815f86e7d2c11_09772427($_smarty_tpl) {?>
			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Danh sách hiện vật <?php echo $_smarty_tpl->tpl_vars['mu_detail']->value['museum_name'];?>
</span></h4>
						</div>											
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="index.html">Quản lí bảo tàng</a></li>
							<li class="active"><?php echo $_smarty_tpl->tpl_vars['mu_detail']->value['museum_name'];?>
</li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
				<!-- Basic datatable -->
					<div class="panel panel-flat">
						<div class="datatable-header">
						<form action="#">
								<div class="row form-group">
									
									<div class="col-lg-4">
										<div class="has-feedback has-feedback-left" style="margin-left:9px;">
										<input type="search" class="form-control" placeholder="Search">
										<div class="form-control-feedback">
											<i class="icon-search4 text-size-base text-muted"></i>
										</div>
										</div>
									</div>
									<div class="col-lg-1"><button type="submit" class="btn btn-success">Tìm kiếm</button></div>
									
								</div>
							
						</form>
						</div>
						<table class="table datatable-basic">
							<thead>
								<tr class="bg-teal-400">
									<th class="col-md-1">ID</th>
									<th class="col-md-2">Tên hiện vật</th>									
									<th class="col-md-1">Hình ảnh</th>
									<th class="col-md-2">Thuyết minh</th>
									<th class="col-md-2">Phim tư liệu</th>									
									<th class="col-md-2">Trạng thái hiện tại</th>
									<th class="col-md-2">Yêu cầu</th>	
									
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['museum_object']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>				                    
					                    <tr>
					                    	<td><?php echo $_smarty_tpl->tpl_vars['item']->value['do_id'];?>
</td>
											<td><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
index.php/main/admin_manage_museum/view_object_detail/<?php echo $_smarty_tpl->tpl_vars['item']->value['do_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></td>											
											<td><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
" style="width: 58px; height: 58px; border-radius: 2px;" alt=""></a></td>
											<td>Thuyết minh</td>
											<td>Phim tư liệu</td>											
											<td><?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==1) {?><span class="label label-info"> AVAILABLE</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==0) {?><span class="label label-default"> PENDING</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==-1) {?><span class="label label-danger"> DE-ACTIVE</span><?php }?>
											<?php if ($_smarty_tpl->tpl_vars['item']->value['current_status']==2) {?><span class="label label-success"> ACTIVED</span><?php }?></td>
											<td>Yêu cầu kích hoạt</td>   
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

			</div>
			<!-- /main content -->

		<?php }} ?>
