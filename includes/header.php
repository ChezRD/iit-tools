<?php session_start(); ?>
<?php //ini_set('display_errors', 'On'); ?>
<?php if (!$_SESSION['logged_in']) { header("Location: login.php"); } ?>
<?php require_once "$INC_DIR/xcrud/xcrud/xcrud.php"; ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <title>UC Admin Tools</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/css/bootstrap-hover-menu.css" rel="stylesheet" media="screen">
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/custom/css/sticky-footer-navbar.css" rel="stylesheet" media="screen">
    <link href="/custom/css/custom.css" rel="stylesheet" media="screen">
    <?php echo Xcrud::load_css(); ?>
</head>
<body>
<div id="wrap">
    <nav class="navbar-wrapper navbar-default navbar-left navbar-fixed-top " role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <l1><a class="navbar-brand" href="/index.php"><span class="glyphicon glyphicon-home right-margin-glyp"></span> <b class="text-danger">Home</b></a></l1>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php if ($_SESSION['role'] == '1'): ?>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle <?php echo preg_match('/ctl/i', basename($_SERVER['SCRIPT_FILENAME'])) ? 'active': '';?>"><span class="glyphicon glyphicon-phone-alt right-margin-glyph"></span>CTL Remover</a>
                        <ul class="dropdown-menu">
                            <li><a href="ctl.php"><span class="glyphicon"></span>Load Phones</a></li>
                            <li><a href="reportPhones.php"><span class="glyphicon"></span>Report Phones</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-asterisk text-danger"></span> Log Out</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="adminOptions.php?username=<?php echo $_SESSION['username']; ?>" ><span class="text-info"></span> Hello <b class="text-info"><?php echo $_SESSION['username']; ?></b></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
