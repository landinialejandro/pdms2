<!DOCTYPE html>
<?php if(!defined('PREPEND_PATH')) define('PREPEND_PATH', ''); ?>
<?php if(!defined('datalist_db_encoding')) define('datalist_db_encoding', 'UTF-8'); ?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="<?php echo datalist_db_encoding; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Pdms | <?php echo (isset($x->TableTitle) ? $x->TableTitle : ''); ?></title>
		<link id="browser_favicon" rel="shortcut icon" href="<?php echo PREPEND_PATH; ?>resources/images/appgini-icon.png">

		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>LTE/dist/bootstrap/dist/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>resources/lightbox/css/lightbox.css" media="screen">
		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>resources/select2/select2.css" media="screen">
		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>resources/timepicker/bootstrap-timepicker.min.css" media="screen">
		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>resources/datepicker/css/datepicker.css" media="screen">
		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>resources/bootstrap-datetimepicker/bootstrap-datetimepicker.css" media="screen">
		<link rel="stylesheet" href="<?php echo PREPEND_PATH; ?>dynamic.css.php">
                <!-- LTE adding -->
                    <!-- Font Awesome -->
                    <link rel="stylesheet" href="LTE/font-awesome/css/font-awesome.min.css">
                    <!-- Ionicons -->
                    <link rel="stylesheet" href="LTE/Ionicons/css/ionicons.min.css">
                    <!-- Theme style -->
                    <link rel="stylesheet" href="LTE/dist/css/AdminLTE.min.css">
                    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
                        page. However, you can choose any other skin. Make sure you
                        apply the skin class to the body tag so the changes take effect. -->
                    <link rel="stylesheet" href="LTE/dist/css/skins/skin-blue.min.css">
                <!-- \LTE adding -->
		<!--[if lt IE 9]>
			<script src="<?php echo PREPEND_PATH; ?>resources/initializr/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<![endif]-->
		<script src="<?php echo PREPEND_PATH; ?>resources/jquery/js/jquery-1.12.4.min.js"></script>
		<script>var $j = jQuery.noConflict();</script>
                <script src="<?php echo PREPEND_PATH; ?>LTE/dist/js/adminlte.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/moment/moment-with-locales.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/jquery/js/jquery.mark.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>LTE/dist/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>LTE/dist/jquery-slimscroll/jquery.slimscroll.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>LTE/dist/fastclick/lib/fastclick.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/lightbox/js/prototype.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/lightbox/js/scriptaculous.js?load=effects"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/select2/select2.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/timepicker/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/jscookie/js.cookie.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/datepicker/js/datepicker.packed.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>common.js.php"></script>
                

		<?php if(isset($x->TableName) && is_file(dirname(__FILE__) . "/hooks/{$x->TableName}-tv.js")){ ?>
			<script src="<?php echo PREPEND_PATH; ?>hooks/<?php echo $x->TableName; ?>-tv.js"></script>
		<?php } ?>

	</head>
	<body class="hold-transition skin-blue fixed sidebar-mini">
		<div  class="wrapper">
			<?php if(function_exists('handle_maintenance')) echo handle_maintenance(true); ?>

                        <?php
                        $memberInfo = getMemberInfo();
                        ?>

			<?php if(class_exists('Notification')) echo Notification::placeholder(); ?>

			<!-- process notifications -->
			<?php $notification_margin = ($_REQUEST['Embedded'] ? '15px 0px' : '-15px 0 -45px'); ?>
			<div style="height: 60px; margin: <?php echo $notification_margin; ?>;">
				<?php if(function_exists('showNotifications')) echo showNotifications(); ?>
			</div>

			<?php if(!defined('APPGINI_SETUP') && is_file(dirname(__FILE__) . '/hooks/header-extras.php')){ include(dirname(__FILE__).'/hooks/header-extras.php'); } ?>
			<?php if($_REQUEST['Embedded']){ ?>
				<?php return; ?>
			<?php } ?>
                    
			<!-- Add header template below here .. -->
                        <?php include('header_lte_main.php'); ?>

                        <?php if(isset($_GET['loginFailed']) || isset($_GET['signIn'])){return;} ?>
                    
                        <!-- Left side column. contains the logo and sidebar -->
                        <?php include ('header_lte_leftSideMenu.php') ?>

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                      <!-- Content Header (Page header) -->
                      <section class="content-header">
                          
                        <section class="content container-fluid">
