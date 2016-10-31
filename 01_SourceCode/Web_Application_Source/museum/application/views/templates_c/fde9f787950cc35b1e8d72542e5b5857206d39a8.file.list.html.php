<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-21 20:43:57
         compiled from "application/views/templates/nhapdiem/list.html" */ ?>
<?php /*%%SmartyHeaderCode:1746056192559b77a0070366-24972798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fde9f787950cc35b1e8d72542e5b5857206d39a8' => 
    array (
      0 => 'application/views/templates/nhapdiem/list.html',
      1 => 1437480413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1746056192559b77a0070366-24972798',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559b77a014bdd8_13295261',
  'variables' => 
  array (
    'baicham' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559b77a014bdd8_13295261')) {function content_559b77a014bdd8_13295261($_smarty_tpl) {?><div class="panel panel-primary filterable">
    <div class="panel-heading">
                                 <h3 class="panel-title">Danh sách bài chấm</h3>
                          </div>
                              <table class="table table-hover">
                                  <thead>
                                      <tr class="filters">
                                        <th width="13%" scope="col"><input type="text" class="form-control" placeholder="Mã số bài chấm" disabled></th>
                                        <th width="18%" scope="col"><input type="text" class="form-control" placeholder="Tên bài chấm" disabled></th>
                                        <th width="12%" scope="col"><input type="text" class="form-control" placeholder="Số lượng" disabled></th>
                                        <th width="14%" scope="col"><input type="text" class="form-control" placeholder="Hệ số" disabled></th>
                                        <th width="13%" scope="col"><input type="text" class="form-control" placeholder="Trạng thái" disabled></th>
                                        <th width="10%" scope="col"><input type="text" class="form-control" placeholder="Thao tác" disabled></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                   <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['thutu'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['baicham']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['thutu']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                    <tr>
                                      <td><div align="left"><?php echo $_smarty_tpl->tpl_vars['item']->value['BAICHAM_maso'];?>
</div></td>
                                      <td><div align="left"><?php echo $_smarty_tpl->tpl_vars['item']->value['BAICHAM_ten'];?>
</div></td>
                                      <td><div align="left"><?php echo $_smarty_tpl->tpl_vars['item']->value['BAICHAM_sobai'];?>
</div></td>
                                      <td><div align="left"><?php echo $_smarty_tpl->tpl_vars['item']->value['BAICHAM_heso'];?>
</div></td>
                                      <td><div align="left"><?php if (($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==0) {?>Chưa chấm<?php }?>
                                      <?php if (($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==-2) {?><span style="font-weight:bold; color:red">Cần chấm lại</span><?php }
if (($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==1) {?>Đã chấm<?php }
if ($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai']==2||$_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai']==3||$_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai']==4) {?>Đã duyệt<?php }?></div></td>
                                      <td><div align="left"><?php if (($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==0) {?><a href="nhapdiem/edit/<?php echo $_smarty_tpl->tpl_vars['item']->value['BAICHAM_id'];?>
">Nhập điểm</a><?php }?>
                                      <?php if (($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==1||($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==-2) {?><a href="nhapdiem/edit/<?php echo $_smarty_tpl->tpl_vars['item']->value['BAICHAM_id'];?>
">Sửa điểm</a><?php }?>
                                      <?php if (($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai'])==2||($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai']==3)||($_smarty_tpl->tpl_vars['item']->value['BAICHAM_trangthai']==4)) {?><span style="font-weight:bold; font-style:italic; color:green">Đã duyệt</span><?php }?>     	  
                                      </div></td>      
                                    </tr>
   									<?php } ?>		                    
                                   </tbody>
                              </table>
    </div>
 
 

<section class="page">
	
</section>
<?php }} ?>
