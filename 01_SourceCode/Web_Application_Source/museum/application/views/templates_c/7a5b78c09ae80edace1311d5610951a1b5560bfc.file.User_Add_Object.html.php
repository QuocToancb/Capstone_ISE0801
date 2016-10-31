<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-30 18:51:42
         compiled from "application/views/templates/User/User_Add_Object.html" */ ?>
<?php /*%%SmartyHeaderCode:13807350835815b6f5d23a16-27225908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a5b78c09ae80edace1311d5610951a1b5560bfc' => 
    array (
      0 => 'application/views/templates/User/User_Add_Object.html',
      1 => 1477828133,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13807350835815b6f5d23a16-27225908',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5815b6f5d35624_21639364',
  'variables' => 
  array (
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5815b6f5d35624_21639364')) {function content_5815b6f5d35624_21639364($_smarty_tpl) {?>	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/plugins/forms/selects/select2.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/pages/form_layouts.js"><?php echo '</script'; ?>
>

							<div class="panel panel-flat">	
								<div class="panel-body">
									<form class="form-vertical" action="" method="POST">
										<div class="row ">
											<div class="col-lg-6">
												<div class="col-lg-12">
													<div class="form-group">
														<label class="text-semibold" >Tên hiện vật<span class="text-danger">*</span></label>
														<input name="txtObjectName" type="text" class="form-control" required
														value="">
													</div>
													
													<div class="form-group">
														<label class="control-label text-semibold">Mô tả hiện vật</label>
														<textarea name="txtDescription" rows="5" cols="5" class="form-control" placeholder="" required></textarea>
													</div>
													
													<div class="form-group">
														<label class="text-semibold">Hình ảnh hiện vật:</label>
														<div class="media no-margin-top">
															<div class="media-left">
																<a href="#"><img src="assets/images/placeholder.jpg" style="width: 58px; height: 58px; border-radius: 2px;" alt="" name="txtImage"></a>
															</div>

															<div class="media-body">
																<input type="file" class="file-styled">
																<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
															</div>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label text-semibold">Audio thuyết minh</label>
														<input type="file" class="file-styled" name="txtAudio">
														<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>														
													</div>
													
													<div class="form-group">
														<label class="control-label text-semibold">Phim tư liệu</label>
														<input type="file" class="file-styled" name="txtVideo">
														<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
													</div>
													
													<div class="form-group">
														<label class="control-label text-semibold">Model 3D</label>
														<input type="file" class="file-styled" name="txtModel">
														<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="col-lg-12">
												<div class="form-group">
													<label class="control-label text-semibold">Target Name</label>
													<input type="text" name="txtTargetName" class="form-control" value="" required>
												</div>
												<div class="form-group">
													<label class="control-label text-semibold">Target Image</label>
													<input type="file" class="file-styled" name="txtTargetImage" value="">
													<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
												</div>
												<div class="form-group ">
													<label class="control-label text-semibold">Target Object 3D</label>
													<input type="file" class="file-styled" name="txtatargetObject3D">
													<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
												</div>
												
												<div class="form-group">
													<label class="display-block text-semibold">Trạng thái:</label>

													<label class="radio-inline">
														<input type="radio" class="styled" name="status" value="0" checked="checked">
														Pending
													</label>

													<label class="radio-inline">
														<input type="radio" class="styled" name="status"  value="1">
														Available
													</label>
												</div>
												
												<div class="text-right">
													<a href="#" class="btn"><i class="icon-arrow-left13 position-left"></i>Trở lại</a>
													<button type="submit" name="btnAddObject" class="btn btn-primary">Thêm hiện vật<i class="icon-arrow-right14 position-right"></i></button>
												</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- /horizotal form --><?php }} ?>
