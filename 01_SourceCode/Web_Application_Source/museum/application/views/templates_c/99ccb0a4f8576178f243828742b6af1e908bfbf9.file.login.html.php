<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-10-29 16:51:25
         compiled from "application/views/templates/login.html" */ ?>
<?php /*%%SmartyHeaderCode:193305860758146b83062075-38139482%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99ccb0a4f8576178f243828742b6af1e908bfbf9' => 
    array (
      0 => 'application/views/templates/login.html',
      1 => 1477562842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193305860758146b83062075-38139482',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_58146b8307c320_13294180',
  'variables' => 
  array (
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58146b8307c320_13294180')) {function content_58146b8307c320_13294180($_smarty_tpl) {?><!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Material Login Form</title>
    
    
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/css/reset.css">

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/css/style.css">

    
    
    
    
  </head>

  <body>

    
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>Login</h1>
  <span>Pen <i class='fa fa-code'></i> by <a href='http://andytran.me'>M.a.D Team</a></span>
</div>
<div class="rerun"><a href="index.html">Back</a></div>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
	<form name="login-form" action="" method="post">
      <div class="input-container">
        <input type="text" id="Username" name="txtUsername" required/>
        <label for="Username">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="Password" name="txtPassword" required/>
        <label for="Password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button name="btnLogin"><span>Go</span></button>
      </div>
    </form>
  </div>
  <div class="card alt">
    <div class="toggle"></div>
    <h1 class="title">Register
      <div class="close"></div>
    </h1>
    <form>
      <div class="input-container">
        <input type="text" id="Username" required/>
        <label for="Username">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="Password" required/>
        <label for="Password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="RepeatPassword" required/>
        <label for="Repeat Password">Repeat Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="text" id="MuseumID" required/>
        <label for="Repeat Password">Museum ID</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="text" id="MusiumName" required/>
        <label for="Repeat Password">Museum Name</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="email" id="Email" required/>
        <label for="Repeat Password">Email</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="text" id="Address" required/>
        <label for="Repeat Password">Address</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="number" id="PhoneNumber" required/>
        <label for="Repeat Password">Phone Number</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button><span>Next</span></button>
      </div>
    </form>
  </div>
</div>
    <?php echo '<script'; ?>
 src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'><?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
resource/js/index.js"><?php echo '</script'; ?>
>

    
    
  </body>
</html>
<?php }} ?>
