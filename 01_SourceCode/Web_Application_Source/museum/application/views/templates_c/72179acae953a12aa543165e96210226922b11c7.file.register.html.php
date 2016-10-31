<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-31 11:11:26
         compiled from "application\views\templates\register.html" */ ?>
<?php /*%%SmartyHeaderCode:292815816b69e64db76-15377147%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72179acae953a12aa543165e96210226922b11c7' => 
    array (
      0 => 'application\\views\\templates\\register.html',
      1 => 1477887080,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '292815816b69e64db76-15377147',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5816b69e67fc98_64537120',
  'variables' => 
  array (
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5816b69e67fc98_64537120')) {function content_5816b69e67fc98_64537120($_smarty_tpl) {?><!DOCTYPE html>
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
resource/assets/js/pages/login.js"><?php echo '</script'; ?>
>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
		        <li>
		          <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">
		            <i class="icon-display4"></i> <span class="position-right"> Trang chủ</span>
		          </a>
		        </li>

		        <li>
		          <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
index.php/main/login">
		            <i class="icon-user-tie"></i> <span class=" position-right"> Đăng nhập</span>
		          </a>
		        </li>

		        <li class="active" style="background: #18BC9C;">
		          <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
index.php/main/register">
		            <i class="icon-cog3"></i>
		            <span class=" position-right"> Đăng kí</span>
		          </a>
		        </li>
	      </ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Registration form -->
					<form action="" method="POST">
						<div class="row">
							<div class="col-lg-6 col-lg-offset-3">
								<div class="panel registration-form">
									<div class="panel-body">
										<div class="text-center">
											<div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
											<h5 class="content-group-lg">Yêu cầu tài khoản <small class="display-block">Nhập đầy đủ tất cả các trường</small></h5>
										</div>

										<div class="content-divider text-muted form-group"><span>Thông tin đăng nhập</span></div>
										
										<div class="form-group has-feedback">
											<input type="email" name="txtEmail" class="form-control" placeholder="Địa chỉ email">
											<div class="form-control-feedback">
												<i class="icon-mention text-muted"></i>
											</div>
										</div>									

										<div class="row">
											<div class="col-md-6">
												<div class="form-group has-feedback">
													<input type="password" name="txtPassword" class="form-control" placeholder="Mật khẩu">
													<div class="form-control-feedback">
														<i class="icon-user-lock text-muted"></i>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group has-feedback">
													<input type="password" class="form-control" placeholder="Nhập lại mật khẩu">
													<div class="form-control-feedback">
														<i class="icon-user-lock text-muted"></i>
													</div>
												</div>
											</div>
										</div>

										<div class="content-divider text-muted form-group"><span>Thông tin bảo tàng</span></div>
										
										<div class="form-group has-feedback">
											<input type="text" name="txtMuseumName" class="form-control" placeholder="Tên bảo tàng">
											<div class="form-control-feedback">
												<i class="icon-office text-muted"></i>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-4">
												<div class="form-group has-feedback">
													<input type="text" name="txtHouseno" class="form-control" placeholder="Số nhà">
													<div class="form-control-feedback">
														<i class="icon-map4 text-muted"></i>
													</div>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group has-feedback">
													<input type="text" name="txtStreet" class="form-control" placeholder="Phường/ Quận/ Huyện">
													<div class="form-control-feedback">
														<i class="icon-map4 text-muted"></i>
													</div>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group has-feedback">
													<input type="text" name="txtCity" class="form-control" placeholder="Tỉnh/ Thành phố">
													<div class="form-control-feedback">
														<i class="icon-map4 text-muted"></i>
													</div>
												</div>
											</div>
										</div>
										
										<div class="form-group has-feedback">
											<input type="text" name="txtPhone" class="form-control" placeholder="Số điện thoại">
											<div class="form-control-feedback">
												<i class="icon-phone text-muted"></i>
											</div>
										</div>
										
										<div class="form-group has-feedback">
											<input type="text" name="txtWebsite" class="form-control" placeholder="Địa chỉ website">
											<div class="form-control-feedback">
												<i class="icon-display4 text-muted"></i>
											</div>
										</div>

										<!-- <div class="form-group">
											<div class="checkbox">
												<label>
													<input type="checkbox" class="styled">
													Đồng ý <a href="#">quyền và điều khoản</a>
												</label>
											</div>
										</div> -->

										<div class="text-right">
											<button type="submit" class="btn btn-link"><i class="icon-arrow-left13 position-left"></i> Trở lại trang đăng nhập</button>
											<button type="submit" name="btnRequestAccout" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b> Yêu cầu tài khoản</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<!-- /registration form -->


					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
<?php }} ?>
