<?php
// This script and data application were generated by AppGini 5.73
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/regimeFiscale.php");
	include("$currDir/regimeFiscale_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('regimeFiscale');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "regimeFiscale";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`regimeFiscale`.`code`" => "code",
		"`regimeFiscale`.`text`" => "text"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => 1,
		2 => 2
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`regimeFiscale`.`code`" => "code",
		"`regimeFiscale`.`text`" => "text"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`regimeFiscale`.`code`" => "Code",
		"`regimeFiscale`.`text`" => "Text"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`regimeFiscale`.`code`" => "code",
		"`regimeFiscale`.`text`" => "text"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`regimeFiscale` ";
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
	$x->ScriptFileName = "regimeFiscale_view.php";
	$x->RedirectAfterInsert = "regimeFiscale_view.php?SelectedID=#ID#";
	$x->TableTitle = "RegimeFiscale";
	$x->TableIcon = "table.gif";
	$x->PrimaryKey = "`regimeFiscale`.`code`";

	$x->ColWidth   = array(  150, 150);
	$x->ColCaption = array("Code", "Text");
	$x->ColFieldName = array('code', 'text');
	$x->ColNumber  = array(1, 2);

	// template paths below are based on the app main directory
	$x->Template = 'templates/regimeFiscale_templateTV.html';
	$x->SelectedTemplate = 'templates/regimeFiscale_templateTVS.html';
	$x->TemplateDV = 'templates/regimeFiscale_templateDV.html';
	$x->TemplateDVP = 'templates/regimeFiscale_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `regimeFiscale`.`code`=membership_userrecords.pkValue and membership_userrecords.tableName='regimeFiscale' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `regimeFiscale`.`code`=membership_userrecords.pkValue and membership_userrecords.tableName='regimeFiscale' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`regimeFiscale`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: regimeFiscale_init
	$render=TRUE;
	if(function_exists('regimeFiscale_init')){
		$args=array();
		$render=regimeFiscale_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: regimeFiscale_header
	$headerCode='';
	if(function_exists('regimeFiscale_header')){
		$args=array();
		$headerCode=regimeFiscale_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: regimeFiscale_footer
	$footerCode='';
	if(function_exists('regimeFiscale_footer')){
		$args=array();
		$footerCode=regimeFiscale_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>