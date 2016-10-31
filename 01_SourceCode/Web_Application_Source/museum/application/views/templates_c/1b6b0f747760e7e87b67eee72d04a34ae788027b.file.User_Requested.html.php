<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-29 22:02:57
         compiled from "application/views/templates/User/User_Requested.html" */ ?>
<?php /*%%SmartyHeaderCode:633236055814718338e900-23667262%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b6b0f747760e7e87b67eee72d04a34ae788027b' => 
    array (
      0 => 'application/views/templates/User/User_Requested.html',
      1 => 1477753367,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '633236055814718338e900-23667262',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_581471833a3d02_31541191',
  'variables' => 
  array (
    'museum_request' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581471833a3d02_31541191')) {function content_581471833a3d02_31541191($_smarty_tpl) {?><!-- Basic datatable -->
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
					<!-- /basic datatable --><?php }} ?>
