<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/attributes.php");
	include("$currDir/attributes_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('attributes');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "attributes";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`attributes`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Attribute */" => "attribute",
		"`attributes`.`value`" => "value",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"IF(    CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`id`), '') /* Product */" => "product"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`attributes`.`id`',
		2 => '`kinds1`.`name`',
		3 => 3,
		4 => '`contacts1`.`id`',
		5 => '`companies1`.`id`',
		6 => '`products1`.`id`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`attributes`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Attribute */" => "attribute",
		"`attributes`.`value`" => "value",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"IF(    CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`id`), '') /* Product */" => "product"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`attributes`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Attribute */" => "Attribute",
		"`attributes`.`value`" => "Value",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "Contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "Company",
		"IF(    CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`id`), '') /* Product */" => "Product"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`attributes`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Attribute */" => "attribute",
		"`attributes`.`value`" => "value",
		"IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') /* Contact */" => "contact",
		"IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') /* Company */" => "company",
		"IF(    CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`id`), '') /* Product */" => "product"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'attribute' => 'Attribute', 'contact' => 'Contact', 'company' => 'Company', 'product' => 'Product');

	$x->QueryFrom = "`attributes` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`attributes`.`attribute` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`attributes`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`attributes`.`company` LEFT JOIN `products` as products1 ON `products1`.`id`=`attributes`.`product` ";
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
	$x->ScriptFileName = "attributes_view.php";
	$x->RedirectAfterInsert = "attributes_view.php?SelectedID=#ID#";
	$x->TableTitle = "Attributes";
	$x->TableIcon = "resources/table_icons/application_form_add.png";
	$x->PrimaryKey = "`attributes`.`id`";

	$x->ColWidth   = array(  150, 150);
	$x->ColCaption = array("Attribute", "Value");
	$x->ColFieldName = array('attribute', 'value');
	$x->ColNumber  = array(2, 3);

	// template paths below are based on the app main directory
	$x->Template = 'templates/attributes_templateTV.html';
	$x->SelectedTemplate = 'templates/attributes_templateTVS.html';
	$x->TemplateDV = 'templates/attributes_templateDV.html';
	$x->TemplateDVP = 'templates/attributes_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `attributes`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='attributes' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `attributes`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='attributes' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`attributes`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: attributes_init
	$render=TRUE;
	if(function_exists('attributes_init')){
		$args=array();
		$render=attributes_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: attributes_header
	$headerCode='';
	if(function_exists('attributes_header')){
		$args=array();
		$headerCode=attributes_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: attributes_footer
	$footerCode='';
	if(function_exists('attributes_footer')){
		$args=array();
		$footerCode=attributes_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>