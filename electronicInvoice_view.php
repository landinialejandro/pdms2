<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/electronicInvoice.php");
	include("$currDir/electronicInvoice_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('electronicInvoice');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "electronicInvoice";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`electronicInvoice`.`id`" => "id",
		"`electronicInvoice`.`topic`" => "topic",
		"`electronicInvoice`.`currency`" => "currency",
		"`electronicInvoice`.`trasmissionFormat`" => "trasmissionFormat",
		"`electronicInvoice`.`country`" => "country"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`electronicInvoice`.`id`',
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`electronicInvoice`.`id`" => "id",
		"`electronicInvoice`.`topic`" => "topic",
		"`electronicInvoice`.`currency`" => "currency",
		"`electronicInvoice`.`trasmissionFormat`" => "trasmissionFormat",
		"`electronicInvoice`.`country`" => "country"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`electronicInvoice`.`id`" => "Numero Progressivo invio",
		"`electronicInvoice`.`topic`" => "Topic",
		"`electronicInvoice`.`currency`" => "Currency",
		"`electronicInvoice`.`trasmissionFormat`" => "TrasmissionFormat",
		"`electronicInvoice`.`country`" => "Country"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`electronicInvoice`.`id`" => "id",
		"`electronicInvoice`.`topic`" => "topic",
		"`electronicInvoice`.`currency`" => "currency",
		"`electronicInvoice`.`trasmissionFormat`" => "trasmissionFormat",
		"`electronicInvoice`.`country`" => "country"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`electronicInvoice` ";
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
	$x->ScriptFileName = "electronicInvoice_view.php";
	$x->RedirectAfterInsert = "electronicInvoice_view.php?SelectedID=#ID#";
	$x->TableTitle = "ElectronicInvoice";
	$x->TableIcon = "resources/table_icons/document_editing.png";
	$x->PrimaryKey = "`electronicInvoice`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150);
	$x->ColCaption = array("Topic", "Currency", "TrasmissionFormat", "Country");
	$x->ColFieldName = array('topic', 'currency', 'trasmissionFormat', 'country');
	$x->ColNumber  = array(2, 3, 4, 5);

	// template paths below are based on the app main directory
	$x->Template = 'templates/electronicInvoice_templateTV.html';
	$x->SelectedTemplate = 'templates/electronicInvoice_templateTVS.html';
	$x->TemplateDV = 'templates/electronicInvoice_templateDV.html';
	$x->TemplateDVP = 'templates/electronicInvoice_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `electronicInvoice`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='electronicInvoice' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `electronicInvoice`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='electronicInvoice' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`electronicInvoice`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: electronicInvoice_init
	$render=TRUE;
	if(function_exists('electronicInvoice_init')){
		$args=array();
		$render=electronicInvoice_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: electronicInvoice_header
	$headerCode='';
	if(function_exists('electronicInvoice_header')){
		$args=array();
		$headerCode=electronicInvoice_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: electronicInvoice_footer
	$footerCode='';
	if(function_exists('electronicInvoice_footer')){
		$args=array();
		$footerCode=electronicInvoice_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>