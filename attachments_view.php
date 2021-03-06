<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/attachments.php");
	include("$currDir/attachments_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('attachments');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "attachments";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`attachments`.`id`" => "id",
		"if(CHAR_LENGTH(`attachments`.`name`)>100, concat(left(`attachments`.`name`,100),' ...'), `attachments`.`name`)" => "name",
		"if(CHAR_LENGTH(`attachments`.`file`)>100, concat(left(`attachments`.`file`,100),' ...'), `attachments`.`file`)" => "file",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"concat('<i class=\"glyphicon glyphicon-', if(`attachments`.`thumbUse`, 'check', 'unchecked'), '\"></i>')" => "thumbUse"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`attachments`.`id`',
		2 => 2,
		3 => 3,
		4 => '`contacts1`.`id`',
		5 => '`companies1`.`id`',
		6 => '`attachments`.`thumbUse`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`attachments`.`id`" => "id",
		"`attachments`.`name`" => "name",
		"`attachments`.`file`" => "file",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"`attachments`.`thumbUse`" => "thumbUse"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`attachments`.`id`" => "ID",
		"`attachments`.`name`" => "Name",
		"`attachments`.`file`" => "File",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "Contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "Company",
		"`attachments`.`thumbUse`" => "ThumbUse"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`attachments`.`id`" => "id",
		"`attachments`.`name`" => "Name",
		"`attachments`.`file`" => "File",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"concat('<i class=\"glyphicon glyphicon-', if(`attachments`.`thumbUse`, 'check', 'unchecked'), '\"></i>')" => "thumbUse"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'contact' => 'Contact', 'company' => 'Company');

	$x->QueryFrom = "`attachments` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`attachments`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`attachments`.`company` ";
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
	$x->ScriptFileName = "attachments_view.php";
	$x->RedirectAfterInsert = "attachments_view.php?SelectedID=#ID#";
	$x->TableTitle = "Attaches";
	$x->TableIcon = "resources/table_icons/attach.png";
	$x->PrimaryKey = "`attachments`.`id`";

	$x->ColWidth   = array(  150, 150, 150);
	$x->ColCaption = array("Name", "File", "ThumbUse");
	$x->ColFieldName = array('name', 'file', 'thumbUse');
	$x->ColNumber  = array(2, 3, 6);

	// template paths below are based on the app main directory
	$x->Template = 'templates/attachments_templateTV.html';
	$x->SelectedTemplate = 'templates/attachments_templateTVS.html';
	$x->TemplateDV = 'templates/attachments_templateDV.html';
	$x->TemplateDVP = 'templates/attachments_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `attachments`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='attachments' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `attachments`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='attachments' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`attachments`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: attachments_init
	$render=TRUE;
	if(function_exists('attachments_init')){
		$args=array();
		$render=attachments_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: attachments_header
	$headerCode='';
	if(function_exists('attachments_header')){
		$args=array();
		$headerCode=attachments_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: attachments_footer
	$footerCode='';
	if(function_exists('attachments_footer')){
		$args=array();
		$footerCode=attachments_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>