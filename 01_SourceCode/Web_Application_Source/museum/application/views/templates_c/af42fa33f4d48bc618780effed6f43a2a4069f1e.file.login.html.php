<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-31 11:11:24
         compiled from "application\views\templates\login.html" */ ?>
<?php /*%%SmartyHeaderCode:1741257fe05c2ce7264-44560099%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'af42fa33f4d48bc618780effed6f43a2a4069f1e' => 
    array (
      0 => 'application\\views\\templates\\login.html',
      1 => 1477887071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1741257fe05c2ce7264-44560099',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57fe05c2d2d771_22613306',
  'variables' => 
  array (
    'url' => 0,
    'thongbao' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fe05c2d2d771_22613306')) {function content_57fe05c2d2d771_22613306($_smarty_tpl) {?><!DOCTYPE html>
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
resource/assets/js/core/app.js"><?php echo '</script'; ?>
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

        <li class="active" style="background: #18BC9C;">
          <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
index.php/main/login">
            <i class="icon-user-tie"></i> <span class=" position-right"> Đăng nhập</span>
          </a>
        </li>

        <li>
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

          <!-- Simple login form -->
          <form action="" method="POST">
            <div class="panel panel-body login-form">
              <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Đăng nhập vào hệ thống <small class="display-block">Nhập vào tài khoản của bạn</small></h5>
              </div>

              <div class="form-group has-feedback has-feedback-left">
                <input type="text" name="txtEmail" class="form-control" placeholder="Địa chỉ email">
                <div class="form-control-feedback">
                  <i class="icon-mention text-muted"></i>
                </div>                
              </div>

              <div class="form-group has-feedback has-feedback-left">
                <input type="password" name="txtPassword" class="form-control" placeholder="Mật khẩu">
                <div class="form-control-feedback">
                  <i class="icon-lock2 text-muted"></i>
                </div>
              </div>

              <span class="help-block text-danger"><?php if (isset($_smarty_tpl->tpl_vars['thongbao']->value)) {?><i class="icon-cancel-circle2 position-left"></i><?php echo $_smarty_tpl->tpl_vars['thongbao']->value;
}?></span> 

              <div class="form-group">
                <button type="submit" name="btnLogin" class="btn btn-primary btn-block">Đăng nhập <i class="icon-circle-right2 position-right"></i></button>
              </div>

              <div class="text-center">
                <a href="login_password_recover.html">Quên mật khẩu?</a>
              </div>
            </div>
          </form>
          <!-- /simple login form -->


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
