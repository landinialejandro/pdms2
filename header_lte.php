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

		<!--[if lt IE 9]>
			<script src="<?php echo PREPEND_PATH; ?>resources/initializr/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<![endif]-->
		<script src="<?php echo PREPEND_PATH; ?>resources/jquery/js/jquery-1.12.4.min.js"></script>
		<script>var $j = jQuery.noConflict();</script>
                <script src="LTE/dist/js/adminlte.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/moment/moment-with-locales.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>resources/jquery/js/jquery.mark.min.js"></script>
		<script src="<?php echo PREPEND_PATH; ?>LTE/dist/bootstrap/dist/js/bootstrap.min.js"></script>
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
	<body class="hold-transition skin-blue sidebar-mini">
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
                    
                        
                    <!-- Main Header -->
                    <header class="main-header">

                      <!-- Logo -->
                      <a href="index.php" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b><i class="glyphicon glyphicon-home"></i></b>&nbsp;PDMS</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><b><i class="glyphicon glyphicon-home"></i>&nbsp;PDMS</b></span>
                      </a>

                      <!-- Header Navbar -->
                      <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                          <span class="sr-only">Toggle navigation</span>
                        </a>
                        <p class="navbar-text hidden-xs" style="color: white;">Piattaforma Digitale Management System</p>

                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                             <!-- User Account Menu -->
                                <li class="dropdown user user-menu">
                                  <!-- Menu Toggle Button -->
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="images/248167a0f974c903e_mpi.jpg?m=1539632256714" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs"><?php echo getLoggedMemberID(); ?></span>
                                  </a>
                                  <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                      <img src="images/248167a0f974c903e_mpi.jpg?m=1539632256714" class="img-circle user-image" alt="User Image">

                                      <p>
                                        <?php echo getLoggedMemberID(); ?> - <?php echo $memberInfo['group']; ?>
                                        <small>Member since <?php echo $memberInfo['signupDate']; ?></small>
                                      </p>
                                    </li>
                                    <?php if(!$_GET['signIn'] && !$_GET['loginFailed']){ ?>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                      <div class="row">
                                        <div class="col-xs-6 text-center">
                                          <a href="#" class="btn btn-app"><i class="fa fa-shopping-cart"></i> My Orders</a>
                                        </div>
                                            <?php if(getLoggedAdmin()){ ?>
                                            <div class="col-xs-6 text-center">
                                                <a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-app" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="fa fa-cogs"></i>&nbsp;<?php echo $Translation['admin area']; ?></a>
                                            </div>
                                            <?php } ?>
                                      </div>
                                      <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                      <div class="col-xs-6 text-center">
                                        <a href="membership_profile.php" class="btn btn-app"><i class="fa fa-user"></i>&nbsp;Profile</a>
                                      </div>
                                      <div class="col-xs-6 text-center">
                                        <!--<a href="#" class="btn btn-app">Sign out</a>-->
                                        
                                            <?php if(getLoggedMemberID() == $adminConfig['anonymousMember']){ ?>
                                                    <a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-app"><?php echo $Translation['sign in']; ?></a>
                                                            <?php echo $Translation['not signed in']; ?>
                                            <?php }else{ ?>
                                                            <a class="btn btn-app" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1">
                                                                <i class="glyphicon glyphicon-log-out"></i> 
                                                                <?php echo $Translation['sign out']; ?>
                                                            </a>
                                                    <script>
                                                            /* periodically check if user is still signed in */
                                                            setInterval(function(){
                                                                    $j.ajax({
                                                                            url: '<?php echo PREPEND_PATH; ?>ajax_check_login.php',
                                                                            success: function(username){
                                                                                    if(!username.length) window.location = '<?php echo PREPEND_PATH; ?>index.php?signIn=1';
                                                                            }
                                                                    });
                                                            }, 60000);
                                                    </script>
                                            <?php } ?>
                                      </div>
                                    </li>
                                  </ul>
                                </li>
                                        <?php } ?>
                                </ul>
                        </div>
                        <!-- /Navbar Right Menu -->
                      </nav>
                    </header>

                    <?php 
                    if(isset($_GET['loginFailed']) || isset($_GET['signIn'])){
                        return ;
                    }
                    @include("{$currDir}/hooks/links-home.php"); 
                    ?>
                    
                    <!-- Left side column. contains the logo and sidebar -->
                    <aside class="main-sidebar">

                      <!-- sidebar: style can be found in sidebar.less -->
                      <section class="sidebar">
                        <!-- Sidebar Menu -->
                        <ul class="sidebar-menu" data-widget="tree">
                          <?php
                          /* accessible tables */
                          $arrTables = get_tables_info();
                          if(is_array($arrTables) && count($arrTables)){
                              /* how many table groups do we have? */
                              $groups = get_table_groups();
                              $multiple_groups = (count($groups) > 1 ? true : false);

                              /* construct $tg: table list grouped by table group */
                              $tg = array();
                              if(count($groups)){
                                      foreach($groups as $grp => $tables){
                                              foreach($tables as $tn){
                                                      $tg[$tn] = $grp;
                                              }
                                      }
                              }

                              $i = 0; $current_group = '';

                              foreach ($groups as $lte_group => $lte_tables) {
                                  if (count($lte_tables)){
                                  ?>

                                          <li class="treeview <?php echo ($i ? '' : 'active');?>">
                                          <a href="#"><i class="fa fa-table"></i> <span><?php echo $lte_group; ?></span>
                                              <span class="pull-right-container">
                                              <i class="fa fa-angle-left pull-right"></i>
                                              </span>
                                          </a>
                                          <ul class="treeview-menu">
                                              <?php
                                                      $len = 17;
                                                      foreach ($lte_tables as $lte_table){
                                                          $tc = $arrTables[$lte_table];
                                                          $count_badge ='';
                                                          if($tc['homepageShowCount']){
                                                              $sql_from = get_sql_from($lte_table);
                                                              $count_records = ($sql_from ? sqlValue("select count(1) from " . $sql_from) : 0);
                                                              $count_badge = '<small class="label pull-right bg-green">' . number_format($count_records) . '</small>';
                                                          }
                                                          /* hide current table in homepage? */
                                                          $tChkHL = array_search($tn, array('ordersDetails','creditDocument'));
                                                          if($tChkHL === false || $tChkHL === null){ /* if table is not set as hidden in homepage */ ?>
                                                              <li>
                                                                  <a href="<?php echo $lte_table; ?>_view.php">
                                                                      <?php echo ($tc['tableIcon'] ? '<img src="' . $tc['tableIcon'] . '">' : '');?>
                                                                      <strong class="table-caption">
                                                                          <?php 
                                                                              $dot = (strlen($tc['Caption']) > $len) ? "..." : "";
                                                                              echo substr($tc['Caption'],0,$len).$dot; 
                                                                          ?>
                                                                      </strong>
                                                                      <?php echo $count_badge; ?>
                                                                  </a>
                                                              </li>
                                                              <?php
                                                          }
                                                      }
                                                      foreach($homeLinks as $link){
                                                          if(!isset($link['url']) || !isset($link['title'])) continue;
                                                          if($lte_group != $link['table_group'] && $lte_group != '*') continue;
                                                          if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
                                                            $title = $link['subGroup'] ? $link['subGroup']." - ".$link['title'] : $link['title'];
                                                            $dot = (strlen($title) > $len+3) ? "..." : "";
                                                              ?>
                                                              <li>
                                                                  <a href="<?php echo $link['url']; ?>" title="<?php echo $title; ?>">
                                                                      <?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?>
                                                                          <?php 
                                                                          
                                                                              echo substr($title,0,$len + 3).$dot; 
                                                                          ?>
                                                                  </a>
                                                              </li>
                                                              <?php
                                                          }
                                                      }
                                              ?>
                                          </ul>
                                      </li>
                                  <?php
                                  $i ++;
                                  }else{
                                   ?>
                                   <li class="active"><a href="#"><i class="fa fa-link"></i> <span><?php echo $lte_group; ?></span></a></li>

                                  <?php
                                  }
                              }
                              foreach($homeLinks as $link){
                                  if(!isset($link['url']) || !isset($link['title'])) continue;
                                  if($link['table_group'] != '*' && $link['table_group'] != '') continue;
                                  if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
                                      ?>
                                      <li>
                                          <a href="<?php echo $link['url']; ?>">
                                              <?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?>
                                              <?php echo $link['subGroup'] ? $link['subGroup']." - ".$link['title'] : $link['title']; ?>
                                          </a>
                                      </li>
                                      <?php
                                  }
                              }
                          }else{
                                  ?><script>window.location='index.php?signIn=1';</script><?php
                          }
                          ?>

                        </ul>
                        <!-- /.sidebar-menu -->
                      </section>
                      <!-- /.sidebar -->
                    </aside>

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                      <!-- Content Header (Page header) -->
                      <section class="content-header">
                          
                        <section class="content container-fluid">
