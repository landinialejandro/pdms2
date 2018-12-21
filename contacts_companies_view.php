<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/contacts_companies.php");
	include("$currDir/contacts_companies_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('contacts_companies');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "contacts_companies";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`contacts_companies`.`id`" => "id",
		"IF(    CHAR_LENGTH(`contacts1`.`name`) || CHAR_LENGTH(`contacts1`.`lastName`), CONCAT_WS('',   `contacts1`.`name`, ' ', `contacts1`.`lastName`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`companyName`) || CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyName`, ' - ', `companies1`.`companyCode`), '') /* Company */" => "company",
		"concat('<i class=\"glyphicon glyphicon-', if(`contacts_companies`.`default`, 'check', 'unchecked'), '\"></i>')" => "default"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`contacts_companies`.`id`',
		2 => 2,
		3 => 3,
		4 => 4
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`contacts_companies`.`id`" => "id",
		"IF(    CHAR_LENGTH(`contacts1`.`name`) || CHAR_LENGTH(`contacts1`.`lastName`), CONCAT_WS('',   `contacts1`.`name`, ' ', `contacts1`.`lastName`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`companyName`) || CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyName`, ' - ', `companies1`.`companyCode`), '') /* Company */" => "company",
		"`contacts_companies`.`default`" => "default"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`contacts_companies`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`contacts1`.`name`) || CHAR_LENGTH(`contacts1`.`lastName`), CONCAT_WS('',   `contacts1`.`name`, ' ', `contacts1`.`lastName`), '') /* Contact */" => "Contact",
		"IF(    CHAR_LENGTH(`companies1`.`companyName`) || CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyName`, ' - ', `companies1`.`companyCode`), '') /* Company */" => "Company",
		"`contacts_companies`.`default`" => "Default"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`contacts_companies`.`id`" => "id",
		"IF(    CHAR_LENGTH(`contacts1`.`name`) || CHAR_LENGTH(`contacts1`.`lastName`), CONCAT_WS('',   `contacts1`.`name`, ' ', `contacts1`.`lastName`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`companyName`) || CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyName`, ' - ', `companies1`.`companyCode`), '') /* Company */" => "company",
		"concat('<i class=\"glyphicon glyphicon-', if(`contacts_companies`.`default`, 'check', 'unchecked'), '\"></i>')" => "default"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'contact' => 'Contact', 'company' => 'Company');

	$x->QueryFrom = "`contacts_companies` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`contacts_companies`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`contacts_companies`.`company` ";
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
	$x->ScriptFileName = "contacts_companies_view.php";
	$x->RedirectAfterInsert = "contacts_companies_view.php?SelectedID=#ID#";
	$x->TableTitle = "Contacts companies";
	$x->TableIcon = "resources/table_icons/brick_link.png";
	$x->PrimaryKey = "`contacts_companies`.`id`";

	$x->ColWidth   = array(  150, 150, 150);
	$x->ColCaption = array("Contact", "Company", "Default");
	$x->ColFieldName = array('contact', 'company', 'default');
	$x->ColNumber  = array(2, 3, 4);

	// template paths below are based on the app main directory
	$x->Template = 'templates/contacts_companies_templateTV.html';
	$x->SelectedTemplate = 'templates/contacts_companies_templateTVS.html';
	$x->TemplateDV = 'templates/contacts_companies_templateDV.html';
	$x->TemplateDVP = 'templates/contacts_companies_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `contacts_companies`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='contacts_companies' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `contacts_companies`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='contacts_companies' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`contacts_companies`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: contacts_companies_init
	$render=TRUE;
	if(function_exists('contacts_companies_init')){
		$args=array();
		$render=contacts_companies_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: contacts_companies_header
	$headerCode='';
	if(function_exists('contacts_companies_header')){
		$args=array();
		$headerCode=contacts_companies_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: contacts_companies_footer
	$footerCode='';
	if(function_exists('contacts_companies_footer')){
		$args=array();
		$footerCode=contacts_companies_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>