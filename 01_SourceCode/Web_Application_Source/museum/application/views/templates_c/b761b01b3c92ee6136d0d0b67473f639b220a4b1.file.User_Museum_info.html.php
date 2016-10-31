<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-31 14:40:44
         compiled from "application\views\templates\User\User_Museum_info.html" */ ?>
<?php /*%%SmartyHeaderCode:2979758143006e4dbb9-79058055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b761b01b3c92ee6136d0d0b67473f639b220a4b1' => 
    array (
      0 => 'application\\views\\templates\\User\\User_Museum_info.html',
      1 => 1477839764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2979758143006e4dbb9-79058055',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_58143006e5d5c7_25172103',
  'variables' => 
  array (
    'museum_info' => 0,
    'account' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58143006e5d5c7_25172103')) {function content_58143006e5d5c7_25172103($_smarty_tpl) {?><!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Thông tin bảo tàng</span></h4>
						</div>		
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>							
							<li class="active">Thông tin bảo tàng</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
<!-- Horizontal form -->
<div class="panel panel-flat">	
								<div class="panel-body">
									<form class="form-vertical" action="" method="post">
										<div class="row ">
											<div class="col-lg-12">
												
													<div class="form-group">
														<label class="text-semibold" >Tên bảo tàng<span class="text-danger">*</span></label>
														<input name="txtMuseumName" type="text" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['museum_info']->value)) {
echo $_smarty_tpl->tpl_vars['museum_info']->value['museum_name'];
}?>">
													</div>
													
													<div class="form-group">
														<label class="control-label text-semibold">Email</label>
														<input name="txtEmail" type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['account']->value['email'];?>
" disabled></input>
													</div>
													
													<div class="row ">
														<div class="col-lg-4">
															<div class="form-group">
															<label class="control-label text-semibold">Số nhà</label>
															<input name="txtHouseno" type="text" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['museum_info']->value)) {
echo $_smarty_tpl->tpl_vars['museum_info']->value['museum_house_no'];
}?>"></input>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
															<label class="control-label text-semibold">Xã/Phường/Quận</label>
															<input name="txtStreet" type="text" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['museum_info']->value)) {
echo $_smarty_tpl->tpl_vars['museum_info']->value['museum_street'];
}?>"></input>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
															<label class="control-label text-semibold">Tỉnh/Thành phố</label>
															<input name="txtCity" type="text" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['museum_info']->value)) {
echo $_smarty_tpl->tpl_vars['museum_info']->value['museum_city'];
}?>"></input>
															</div>
														</div>
														
													</div>
													
													
													<div class="form-group">
														<label class="control-label text-semibold">Số điện thoại</label>
														<input name="txtPhone" type="text" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['museum_info']->value)) {
echo $_smarty_tpl->tpl_vars['museum_info']->value['museum_phone'];
}?>"></input>
													</div>
													
													<div class="form-group">
														<label class="control-label text-semibold">Website</label>
														<input name="txtWebsite" type="text" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['museum_info']->value)) {
echo $_smarty_tpl->tpl_vars['museum_info']->value['museum_website'];
}?>"></input>
													</div>
													
													
													
													<div class="text-right">
													
													<button type="submit" class="btn btn-primary" name="btnSave">Lưu<i class="icon-arrow-right14 position-right"></i></button>
												</div>
												
											</div>
											
										</div>
										
										
									</form>
								</div>
							</div>
                            <!-- /horizotal form -->
</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->
<?php }} ?>
