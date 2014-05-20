<?php session_start(); ?>
<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . "/includes"; ?>
<?php if (isset($_SESSION['logged_in'])): ?>
    <?php header("Location: index.php"); ?>
<?php endif ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>IIT Tools</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/custom/css/signin.css" rel="stylesheet" media="screen">
    <link href="/custom/css/sticky-footer-navbar.css" rel="stylesheet" media="screen">
  </head>
  <body>
      <div id="wrap">
        <div class="container buffer-login">
            <form class="form-signin col-md-4 col-md-offset-4 sign-in-top-margin" role="form" method="post" action="authenticate.php">
                <h2 class="form-signin-heading text-center">Log In</h2>
              <input type="text" class="form-control" placeholder="Username" name="Username"required autofocus>
              <input type="password" class="form-control" placeholder="Password" name="Password"required>
              <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
              </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                <div class="col-md-12 text-center top-buffer-col">
                    <?php if(isset($_GET['auth']) == 'fail'): ?>
                    <?php echo '<div id="loginfail"><h1 class="text-danger">Login Failed! </h1><small>try again...</small></div>' ?>
                    <?php endif; ?>
                </div>
            </form>

 <?php require_once "$INC_DIR/footer.php";
