<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-31 14:40:38
         compiled from "application\views\templates\User\User_Requested.html" */ ?>
<?php /*%%SmartyHeaderCode:1418858143375745ed3-39281627%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06caf3b6fc8b047ec2880c59942c90f6541486cb' => 
    array (
      0 => 'application\\views\\templates\\User\\User_Requested.html',
      1 => 1477839878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1418858143375745ed3-39281627',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_58143375780860_12794649',
  'variables' => 
  array (
    'museum_request' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58143375780860_12794649')) {function content_58143375780860_12794649($_smarty_tpl) {?><!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Yêu cầu đang chờ xử lí</span></h4>
						</div>

											
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Yêu cầu đang chờ xử lí</li>
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
									<th class="col-md-1">ID Hiện vật</th>
									<th class="col-md-2">Tên hiện vật</th>									
									<th class="col-md-1">Hình ảnh</th>
									<th class="col-md-1">Yêu cầu đã gửi</th>
									<th class="col-md-1">Lý do</th>
									<th class="col-md-1">Thời gian gửi</th>									
								</tr>
							</thead>
							<tbody>
							<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['museum_request']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
								<tr>
									<td><?php echo $_smarty_tpl->tpl_vars['item']->value['do_id'];?>
</td>
									<td><a href="#"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></td>									
									<td><a href="#"><img src= "<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
"" style="width: 58px; height: 58px; border-radius: 2px;" alt=""></a></td>
									<td>
									<?php if ($_smarty_tpl->tpl_vars['item']->value['request_type']==0) {?> Yêu Cầu Xoá<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['item']->value['request_type']==1) {?> Yêu Cầu Sửa<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['item']->value['request_type']==2) {?> Yêu Cầu Kích Hoạt<?php }?>
									</td>
									<td><?php echo $_smarty_tpl->tpl_vars['item']->value['reason'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['item']->value['sent_time'];?>
</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					<!-- /basic datatable -->
</div>
				<!-- /content area -->

			</div>
			<!-- /main content --><?php }} ?>
