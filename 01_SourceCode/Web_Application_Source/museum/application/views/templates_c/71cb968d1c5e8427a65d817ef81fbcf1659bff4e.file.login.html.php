<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-26 20:46:32
         compiled from "application\views\templates\login.html" */ ?>
<?php /*%%SmartyHeaderCode:221345810b3b8853a37-95779289%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71cb968d1c5e8427a65d817ef81fbcf1659bff4e' => 
    array (
      0 => 'application\\views\\templates\\login.html',
      1 => 1476926755,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '221345810b3b8853a37-95779289',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'thongbao' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5810b3b8cff058_10691489',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5810b3b8cff058_10691489')) {function content_5810b3b8cff058_10691489($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>


<!--META-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>

<!--STYLESHEETS-->
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/css/loginform.css"/>

<!--SCRIPTS-->
<?php echo '<script'; ?>
 type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"><?php echo '</script'; ?>
>
<!--Slider-in icons-->
<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {
	$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});
});
<?php echo '</script'; ?>
>

</head>
<body>

<!--WRAPPER-->
<div id="wrapper">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->
<form name="login-form" class="login-form" action="" method="post">

	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Museum</h1><!--END TITLE-->
    <!--DESCRIPTION--><span><?php if (isset($_smarty_tpl->tpl_vars['thongbao']->value)) {?><span style="color:red"><?php echo $_smarty_tpl->tpl_vars['thongbao']->value;?>
</span><?php } else { ?>Bạn hãy nhập tên đăng nhập và mật khẩu để truy cập vào hệ thống Museum<?php }?></span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content">
	<!--USERNAME--><input name="txtUsername" type="text" class="input username" value="Username" autofocus onfocus="this.value=''" /><!--END USERNAME-->
    <!--PASSWORD--><input name="txtPassword" type="password" class="input password" value="Password" onfocus="this.value=''" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="btnLogin" value="Login" class="button" /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->

<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

</body>
</html><?php }} ?>
