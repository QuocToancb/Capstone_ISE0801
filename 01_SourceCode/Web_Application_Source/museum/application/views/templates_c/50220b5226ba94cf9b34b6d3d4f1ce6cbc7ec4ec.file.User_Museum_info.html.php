<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-29 16:51:37
         compiled from "application/views/templates/User/User_Museum_info.html" */ ?>
<?php /*%%SmartyHeaderCode:110886963558146cdf977250-44454484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '50220b5226ba94cf9b34b6d3d4f1ce6cbc7ec4ec' => 
    array (
      0 => 'application/views/templates/User/User_Museum_info.html',
      1 => 1477733800,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110886963558146cdf977250-44454484',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_58146cdf98a485_70879017',
  'variables' => 
  array (
    'museum_info' => 0,
    'account' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58146cdf98a485_70879017')) {function content_58146cdf98a485_70879017($_smarty_tpl) {?><!-- Horizontal form -->
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
                            <!-- /horizotal form --><?php }} ?>
