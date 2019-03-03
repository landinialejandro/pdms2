<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/companies.php");
	include("$currDir/companies_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('companies');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "companies";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`companies`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo */" => "kind",
		"if(CHAR_LENGTH(`companies`.`companyCode`)>100, concat(left(`companies`.`companyCode`,100),' ...'), `companies`.`companyCode`)" => "companyCode",
		"if(CHAR_LENGTH(`companies`.`companyName`)>100, concat(left(`companies`.`companyName`,100),' ...'), `companies`.`companyName`)" => "companyName",
		"`companies`.`personaFisica`" => "personaFisica",
		"if(CHAR_LENGTH(`companies`.`fiscalCode`)>100, concat(left(`companies`.`fiscalCode`,100),' ...'), `companies`.`fiscalCode`)" => "fiscalCode",
		"if(CHAR_LENGTH(`companies`.`vat`)>100, concat(left(`companies`.`vat`,100),' ...'), `companies`.`vat`)" => "vat",
		"`companies`.`notes`" => "notes",
		"`companies`.`codiceDestinatario`" => "codiceDestinatario",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Regime Fiscale */" => "regimeFiscale",
		"IF(    CHAR_LENGTH(`kinds3`.`code`) || CHAR_LENGTH(`kinds3`.`name`), CONCAT_WS('',   `kinds3`.`code`, ' - ', `kinds3`.`name`), '') /* Tipo Cassa */" => "tipoCassa",
		"IF(    CHAR_LENGTH(`kinds4`.`code`) || CHAR_LENGTH(`kinds4`.`name`), CONCAT_WS('',   `kinds4`.`code`, ' - ', `kinds4`.`name`), '') /* Modalita Pagamento */" => "modalitaPagamento",
		"`companies`.`RiferimentoAmministrazione`" => "RiferimentoAmministrazione",
		"IF(    CHAR_LENGTH(`kinds5`.`name`), CONCAT_WS('',   `kinds5`.`name`), '') /* Destinatario */" => "FormatoTrasmissione",
		"concat('<i class=\"glyphicon glyphicon-', if(`companies`.`RIT_soggettoRitenuta`, 'check', 'unchecked'), '\"></i>')" => "RIT_soggettoRitenuta",
		"`companies`.`RIT_tipoRitenuta`" => "RIT_tipoRitenuta",
		"`companies`.`RIT_AliquotaRitenuta`" => "RIT_AliquotaRitenuta",
		"`companies`.`RIT_CausalePagamento`" => "RIT_CausalePagamento"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`companies`.`id`',
		2 => '`kinds1`.`name`',
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => 12,
		13 => 13,
		14 => '`kinds5`.`name`',
		15 => 15,
		16 => 16,
		17 => '`companies`.`RIT_AliquotaRitenuta`',
		18 => 18
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`companies`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo */" => "kind",
		"`companies`.`companyCode`" => "companyCode",
		"`companies`.`companyName`" => "companyName",
		"`companies`.`personaFisica`" => "personaFisica",
		"`companies`.`fiscalCode`" => "fiscalCode",
		"`companies`.`vat`" => "vat",
		"`companies`.`notes`" => "notes",
		"`companies`.`codiceDestinatario`" => "codiceDestinatario",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Regime Fiscale */" => "regimeFiscale",
		"IF(    CHAR_LENGTH(`kinds3`.`code`) || CHAR_LENGTH(`kinds3`.`name`), CONCAT_WS('',   `kinds3`.`code`, ' - ', `kinds3`.`name`), '') /* Tipo Cassa */" => "tipoCassa",
		"IF(    CHAR_LENGTH(`kinds4`.`code`) || CHAR_LENGTH(`kinds4`.`name`), CONCAT_WS('',   `kinds4`.`code`, ' - ', `kinds4`.`name`), '') /* Modalita Pagamento */" => "modalitaPagamento",
		"`companies`.`RiferimentoAmministrazione`" => "RiferimentoAmministrazione",
		"IF(    CHAR_LENGTH(`kinds5`.`name`), CONCAT_WS('',   `kinds5`.`name`), '') /* Destinatario */" => "FormatoTrasmissione",
		"`companies`.`RIT_soggettoRitenuta`" => "RIT_soggettoRitenuta",
		"`companies`.`RIT_tipoRitenuta`" => "RIT_tipoRitenuta",
		"`companies`.`RIT_AliquotaRitenuta`" => "RIT_AliquotaRitenuta",
		"`companies`.`RIT_CausalePagamento`" => "RIT_CausalePagamento"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`companies`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo */" => "Tipo",
		"`companies`.`companyCode`" => "Codice",
		"`companies`.`companyName`" => "Ragione Sociale",
		"`companies`.`personaFisica`" => "Persona Fisica",
		"`companies`.`fiscalCode`" => "Codice Fiscale",
		"`companies`.`vat`" => "Vat",
		"`companies`.`notes`" => "Notes",
		"`companies`.`codiceDestinatario`" => "Codice Destinatario",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Regime Fiscale */" => "Regime Fiscale",
		"IF(    CHAR_LENGTH(`kinds3`.`code`) || CHAR_LENGTH(`kinds3`.`name`), CONCAT_WS('',   `kinds3`.`code`, ' - ', `kinds3`.`name`), '') /* Tipo Cassa */" => "Tipo Cassa",
		"IF(    CHAR_LENGTH(`kinds4`.`code`) || CHAR_LENGTH(`kinds4`.`name`), CONCAT_WS('',   `kinds4`.`code`, ' - ', `kinds4`.`name`), '') /* Modalita Pagamento */" => "Modalita Pagamento",
		"`companies`.`RiferimentoAmministrazione`" => "Riferimento Amministrazione",
		"IF(    CHAR_LENGTH(`kinds5`.`name`), CONCAT_WS('',   `kinds5`.`name`), '') /* Destinatario */" => "Destinatario",
		"`companies`.`RIT_soggettoRitenuta`" => "RIT soggetto Ritenuta",
		"`companies`.`RIT_tipoRitenuta`" => "RIT tipo Ritenuta",
		"`companies`.`RIT_AliquotaRitenuta`" => "RIT Aliquota Ritenuta",
		"`companies`.`RIT_CausalePagamento`" => "RIT Causale Pagamento"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`companies`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo */" => "kind",
		"`companies`.`companyCode`" => "Codice",
		"`companies`.`companyName`" => "Ragione Sociale",
		"`companies`.`personaFisica`" => "personaFisica",
		"`companies`.`fiscalCode`" => "Codice Fiscale",
		"`companies`.`vat`" => "Vat",
		"`companies`.`notes`" => "notes",
		"`companies`.`codiceDestinatario`" => "codiceDestinatario",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Regime Fiscale */" => "regimeFiscale",
		"IF(    CHAR_LENGTH(`kinds3`.`code`) || CHAR_LENGTH(`kinds3`.`name`), CONCAT_WS('',   `kinds3`.`code`, ' - ', `kinds3`.`name`), '') /* Tipo Cassa */" => "tipoCassa",
		"IF(    CHAR_LENGTH(`kinds4`.`code`) || CHAR_LENGTH(`kinds4`.`name`), CONCAT_WS('',   `kinds4`.`code`, ' - ', `kinds4`.`name`), '') /* Modalita Pagamento */" => "modalitaPagamento",
		"`companies`.`RiferimentoAmministrazione`" => "RiferimentoAmministrazione",
		"IF(    CHAR_LENGTH(`kinds5`.`name`), CONCAT_WS('',   `kinds5`.`name`), '') /* Destinatario */" => "FormatoTrasmissione",
		"concat('<i class=\"glyphicon glyphicon-', if(`companies`.`RIT_soggettoRitenuta`, 'check', 'unchecked'), '\"></i>')" => "RIT_soggettoRitenuta",
		"`companies`.`RIT_tipoRitenuta`" => "RIT_tipoRitenuta",
		"`companies`.`RIT_AliquotaRitenuta`" => "RIT_AliquotaRitenuta",
		"`companies`.`RIT_CausalePagamento`" => "RIT_CausalePagamento"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'kind' => 'Tipo', 'regimeFiscale' => 'Regime Fiscale', 'tipoCassa' => 'Tipo Cassa', 'modalitaPagamento' => 'Modalita Pagamento', 'FormatoTrasmissione' => 'Destinatario');

	$x->QueryFrom = "`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`companies`.`regimeFiscale` LEFT JOIN `kinds` as kinds3 ON `kinds3`.`code`=`companies`.`tipoCassa` LEFT JOIN `kinds` as kinds4 ON `kinds4`.`code`=`companies`.`modalitaPagamento` LEFT JOIN `kinds` as kinds5 ON `kinds5`.`code`=`companies`.`FormatoTrasmissione` ";
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
	$x->ScriptFileName = "companies_view.php";
	$x->RedirectAfterInsert = "companies_view.php?SelectedID=#ID#";
	$x->TableTitle = "Aziende";
	$x->TableIcon = "resources/table_icons/factory.png";
	$x->PrimaryKey = "`companies`.`id`";
	$x->DefaultSortField = '4';
	$x->DefaultSortDirection = 'asc';

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Tipo", "Codice", "Ragione Sociale", "Codice Fiscale", "Vat", "Notes", "RIT soggetto Ritenuta", "RIT Aliquota Ritenuta");
	$x->ColFieldName = array('kind', 'companyCode', 'companyName', 'fiscalCode', 'vat', 'notes', 'RIT_soggettoRitenuta', 'RIT_AliquotaRitenuta');
	$x->ColNumber  = array(2, 3, 4, 6, 7, 8, 15, 17);

	// template paths below are based on the app main directory
	$x->Template = 'templates/companies_templateTV.html';
	$x->SelectedTemplate = 'templates/companies_templateTVS.html';
	$x->TemplateDV = 'templates/companies_templateDV.html';
	$x->TemplateDVP = 'templates/companies_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `companies`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='companies' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `companies`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='companies' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`companies`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: companies_init
	$render=TRUE;
	if(function_exists('companies_init')){
		$args=array();
		$render=companies_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: companies_header
	$headerCode='';
	if(function_exists('companies_header')){
		$args=array();
		$headerCode=companies_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: companies_footer
	$footerCode='';
	if(function_exists('companies_footer')){
		$args=array();
		$footerCode=companies_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>