<?php
// This script and data application were generated by AppGini 5.73
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/town.php");
	include("$currDir/town_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('town');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "town";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`town`.`id`" => "id",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Country */" => "country",
		"if(CHAR_LENGTH(`town`.`idIstat`)>100, concat(left(`town`.`idIstat`,100),' ...'), `town`.`idIstat`)" => "idIstat",
		"if(CHAR_LENGTH(`town`.`town`)>100, concat(left(`town`.`town`,100),' ...'), `town`.`town`)" => "town",
		"if(CHAR_LENGTH(`town`.`district`)>100, concat(left(`town`.`district`,100),' ...'), `town`.`district`)" => "district",
		"if(CHAR_LENGTH(`town`.`region`)>100, concat(left(`town`.`region`,100),' ...'), `town`.`region`)" => "region",
		"if(CHAR_LENGTH(`town`.`prefix`)>100, concat(left(`town`.`prefix`,100),' ...'), `town`.`prefix`)" => "prefix",
		"if(CHAR_LENGTH(`town`.`shipCode`)>100, concat(left(`town`.`shipCode`,100),' ...'), `town`.`shipCode`)" => "shipCode",
		"if(CHAR_LENGTH(`town`.`fiscCode`)>100, concat(left(`town`.`fiscCode`,100),' ...'), `town`.`fiscCode`)" => "fiscCode",
		"if(CHAR_LENGTH(`town`.`inhabitants`)>100, concat(left(`town`.`inhabitants`,100),' ...'), `town`.`inhabitants`)" => "inhabitants",
		"if(CHAR_LENGTH(`town`.`link`)>100, concat(left(`town`.`link`,100),' ...'), `town`.`link`)" => "link"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`town`.`id`',
		2 => '`countries1`.`country`',
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`town`.`id`" => "id",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Country */" => "country",
		"`town`.`idIstat`" => "idIstat",
		"`town`.`town`" => "town",
		"`town`.`district`" => "district",
		"`town`.`region`" => "region",
		"`town`.`prefix`" => "prefix",
		"`town`.`shipCode`" => "shipCode",
		"`town`.`fiscCode`" => "fiscCode",
		"`town`.`inhabitants`" => "inhabitants",
		"`town`.`link`" => "link"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`town`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Country */" => "Country",
		"`town`.`idIstat`" => "IdIstat",
		"`town`.`town`" => "Comune",
		"`town`.`district`" => "Provincia",
		"`town`.`region`" => "Regione",
		"`town`.`prefix`" => "Prefisso",
		"`town`.`shipCode`" => "CAP",
		"`town`.`fiscCode`" => "Codice Fisc.",
		"`town`.`inhabitants`" => "Abitanti",
		"`town`.`link`" => "Link"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`town`.`id`" => "id",
		"IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') /* Country */" => "country",
		"`town`.`idIstat`" => "IdIstat",
		"`town`.`town`" => "Comune",
		"`town`.`district`" => "Provincia",
		"`town`.`region`" => "Regione",
		"`town`.`prefix`" => "Prefisso",
		"`town`.`shipCode`" => "CAP",
		"`town`.`fiscCode`" => "Codice Fisc.",
		"`town`.`inhabitants`" => "Abitanti",
		"`town`.`link`" => "Link"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'country' => 'Country');

	$x->QueryFrom = "`town` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`town`.`country` ";
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
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 100;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "town_view.php";
	$x->RedirectAfterInsert = "town_view.php?SelectedID=#ID#";
	$x->TableTitle = "Comuni italiani";
	$x->TableIcon = "resources/table_icons/italy.png";
	$x->PrimaryKey = "`town`.`id`";
	$x->DefaultSortField = '4';
	$x->DefaultSortDirection = 'asc';

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Country", "IdIstat", "Comune", "Provincia", "Regione", "Prefisso", "CAP", "Codice Fisc.", "Abitanti", "Link");
	$x->ColFieldName = array('country', 'idIstat', 'town', 'district', 'region', 'prefix', 'shipCode', 'fiscCode', 'inhabitants', 'link');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11);

	// template paths below are based on the app main directory
	$x->Template = 'templates/town_templateTV.html';
	$x->SelectedTemplate = 'templates/town_templateTVS.html';
	$x->TemplateDV = 'templates/town_templateDV.html';
	$x->TemplateDVP = 'templates/town_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `town`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='town' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `town`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='town' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`town`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: town_init
	$render=TRUE;
	if(function_exists('town_init')){
		$args=array();
		$render=town_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: town_header
	$headerCode='';
	if(function_exists('town_header')){
		$args=array();
		$headerCode=town_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: town_footer
	$footerCode='';
	if(function_exists('town_footer')){
		$args=array();
		$footerCode=town_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>