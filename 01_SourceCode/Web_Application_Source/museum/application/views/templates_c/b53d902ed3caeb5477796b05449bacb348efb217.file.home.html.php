<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-31 09:17:38
         compiled from "application\views\templates\home.html" */ ?>
<?php /*%%SmartyHeaderCode:20115811cb058ce4f8-17764149%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b53d902ed3caeb5477796b05449bacb348efb217' => 
    array (
      0 => 'application\\views\\templates\\home.html',
      1 => 1477838569,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20115811cb058ce4f8-17764149',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5811cb059cc3a9_81216370',
  'variables' => 
  array (
    'url' => 0,
    'nhomnguoidung' => 0,
    'menudacap' => 0,
    'temp' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5811cb059cc3a9_81216370')) {function content_5811cb059cc3a9_81216370($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/plugins/loaders/pace.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/core/libraries/jquery.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/core/libraries/bootstrap.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/plugins/loaders/blockui.min.js"><?php echo '</script'; ?>
>
	
	<!-- /core JS files -->
	
	<!-- Theme JS files -->	
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/plugins/forms/styling/uniform.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/core/app.js"><?php echo '</script'; ?>
>	
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/js/pages/form_inputs.js"><?php echo '</script'; ?>
>
	<!-- /theme JS files -->

</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

				
			</ul>

			<p class="navbar-text"><span class="label bg-success-400">Online</span></p>

			<ul class="nav navbar-nav navbar-right">
					

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/images/placeholder.jpg" alt="">
						<span>Bảo tàng lịch sử quốc gia Hà Nội</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-plus"></i>Thông tin bảo tàng</a></li>
						<li class="divider"></li>
						<li><a href="../main/logout"><i class="icon-switch2"></i> Đăng xuất</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main ">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold">Bảo tàng lịch sử quốc gia Hà Nội</span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> &nbsp;Quận Ba Đình, Hà Nội
									</div>
								</div>								
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Tính năng</span> <i class="icon-menu" title="Main pages"></i></li>
                                <?php echo $_smarty_tpl->tpl_vars['menudacap']->value->loadMenu($_smarty_tpl->tpl_vars['url']->value,$_smarty_tpl->tpl_vars['nhomnguoidung']->value);?>

								<!--<li><a href="index.html"><i class="icon-home4"></i> <span>Quản lí hiện vật</span></a></li>
								<li><a href="Request_user.html"><i class="icon-copy"></i> <span>Yêu cầu đã gửi<span class="label bg-blue-400">10</span></span></a></li>								
								<li class="active"><a href="About_user.html"><i class="icon-list-unordered"></i> <span>Thông tin bảo tàng</a></li>-->	
                                							
								<!-- /main -->
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			
			<?php if (isset($_smarty_tpl->tpl_vars['temp']->value)) {?>
                 <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['temp']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <?php }?>					

			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
<?php }} ?>
