<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/mails.php");
	include("$currDir/mails_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('mails');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "mails";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`mails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"if(CHAR_LENGTH(`mails`.`mail`)>100, concat(left(`mails`.`mail`,100),' ...'), `mails`.`mail`)" => "mail",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"concat('<i class=\"glyphicon glyphicon-', if(`mails`.`default`, 'check', 'unchecked'), '\"></i>')" => "default"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`mails`.`id`',
		2 => '`kinds1`.`name`',
		3 => 3,
		4 => '`contacts1`.`id`',
		5 => '`companies1`.`id`',
		6 => 6
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`mails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"`mails`.`mail`" => "mail",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"`mails`.`default`" => "default"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`mails`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "Kind",
		"`mails`.`mail`" => "Mail",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "Contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "Company",
		"`mails`.`default`" => "Default"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`mails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Kind */" => "kind",
		"`mails`.`mail`" => "Mail",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"concat('<i class=\"glyphicon glyphicon-', if(`mails`.`default`, 'check', 'unchecked'), '\"></i>')" => "default"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'kind' => 'Kind', 'contact' => 'Contact', 'company' => 'Company');

	$x->QueryFrom = "`mails` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`mails`.`kind` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`mails`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`mails`.`company` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "mails_view.php";
	$x->RedirectAfterInsert = "mails_view.php?SelectedID=#ID#";
	$x->TableTitle = "Mails";
	$x->TableIcon = "resources/table_icons/email.png";
	$x->PrimaryKey = "`mails`.`id`";

	$x->ColWidth   = array(  150, 150, 150);
	$x->ColCaption = array("Kind", "Mail", "Default");
	$x->ColFieldName = array('kind', 'mail', 'default');
	$x->ColNumber  = array(2, 3, 6);

	// template paths below are based on the app main directory
	$x->Template = 'templates/mails_templateTV.html';
	$x->SelectedTemplate = 'templates/mails_templateTVS.html';
	$x->TemplateDV = 'templates/mails_templateDV.html';
	$x->TemplateDVP = 'templates/mails_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `mails`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='mails' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `mails`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='mails' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`mails`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: mails_init
	$render=TRUE;
	if(function_exists('mails_init')){
		$args=array();
		$render=mails_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: mails_header
	$headerCode='';
	if(function_exists('mails_header')){
		$args=array();
		$headerCode=mails_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: mails_footer
	$footerCode='';
	if(function_exists('mails_footer')){
		$args=array();
		$footerCode=mails_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>