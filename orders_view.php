<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/orders.php");
	include("$currDir/orders_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('orders');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "orders";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`orders`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo ordine */" => "kind",
		"`orders`.`progressiveNr`" => "progressiveNr",
		"`orders`.`trasmissionFor`" => "trasmissionFor",
		"`orders`.`consigneeID`" => "consigneeID",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* ID Azienda */" => "company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Documento */" => "typeDoc",
		"`orders`.`multiOrder`" => "multiOrder",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Cliente */" => "customer",
		"IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') /* Supplier */" => "supplier",
		"IF(    CHAR_LENGTH(`contacts1`.`name`), CONCAT_WS('',   `contacts1`.`name`), '') /* Impiegato */" => "employee",
		"if(`orders`.`date`,date_format(`orders`.`date`,'%d/%m/%Y'),'')" => "date",
		"if(`orders`.`requiredDate`,date_format(`orders`.`requiredDate`,'%d/%m/%Y'),'')" => "requiredDate",
		"if(`orders`.`shippedDate`,date_format(`orders`.`shippedDate`,'%d/%m/%Y'),'')" => "shippedDate",
		"IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') /* Spedizione a mezzo */" => "shipVia",
		"`orders`.`Freight`" => "Freight",
		"`orders`.`pallets`" => "pallets",
		"if(CHAR_LENGTH(`orders`.`licencePlate`)>100, concat(left(`orders`.`licencePlate`,100),' ...'), `orders`.`licencePlate`)" => "licencePlate",
		"`orders`.`orderTotal`" => "orderTotal",
		"concat('<i class=\"glyphicon glyphicon-', if(`orders`.`cashCredit`, 'check', 'unchecked'), '\"></i>')" => "cashCredit",
		"`orders`.`trust`" => "trust",
		"`orders`.`overdraft`" => "overdraft",
		"`orders`.`commisionFee`" => "commisionFee",
		"`orders`.`commisionRate`" => "commisionRate",
		"if(`orders`.`consigneeHour`,date_format(`orders`.`consigneeHour`,'%d/%m/%Y %h:%i %p'),'')" => "consigneeHour",
		"`orders`.`consigneePlace`" => "consigneePlace",
		"`orders`.`related`" => "related",
		"`orders`.`document`" => "document"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`orders`.`id`',
		2 => '`kinds1`.`name`',
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => '`orders`.`multiOrder`',
		9 => '`companies2`.`companyName`',
		10 => '`companies3`.`companyName`',
		11 => '`contacts1`.`name`',
		12 => '`orders`.`date`',
		13 => '`orders`.`requiredDate`',
		14 => '`orders`.`shippedDate`',
		15 => '`companies4`.`companyName`',
		16 => '`orders`.`Freight`',
		17 => '`orders`.`pallets`',
		18 => 18,
		19 => '`orders`.`orderTotal`',
		20 => 20,
		21 => '`orders`.`trust`',
		22 => '`orders`.`overdraft`',
		23 => '`orders`.`commisionFee`',
		24 => '`orders`.`commisionRate`',
		25 => '`orders`.`consigneeHour`',
		26 => 26,
		27 => '`orders`.`related`',
		28 => 28
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`orders`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo ordine */" => "kind",
		"`orders`.`progressiveNr`" => "progressiveNr",
		"`orders`.`trasmissionFor`" => "trasmissionFor",
		"`orders`.`consigneeID`" => "consigneeID",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* ID Azienda */" => "company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Documento */" => "typeDoc",
		"`orders`.`multiOrder`" => "multiOrder",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Cliente */" => "customer",
		"IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') /* Supplier */" => "supplier",
		"IF(    CHAR_LENGTH(`contacts1`.`name`), CONCAT_WS('',   `contacts1`.`name`), '') /* Impiegato */" => "employee",
		"if(`orders`.`date`,date_format(`orders`.`date`,'%d/%m/%Y'),'')" => "date",
		"if(`orders`.`requiredDate`,date_format(`orders`.`requiredDate`,'%d/%m/%Y'),'')" => "requiredDate",
		"if(`orders`.`shippedDate`,date_format(`orders`.`shippedDate`,'%d/%m/%Y'),'')" => "shippedDate",
		"IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') /* Spedizione a mezzo */" => "shipVia",
		"`orders`.`Freight`" => "Freight",
		"`orders`.`pallets`" => "pallets",
		"`orders`.`licencePlate`" => "licencePlate",
		"`orders`.`orderTotal`" => "orderTotal",
		"`orders`.`cashCredit`" => "cashCredit",
		"`orders`.`trust`" => "trust",
		"`orders`.`overdraft`" => "overdraft",
		"`orders`.`commisionFee`" => "commisionFee",
		"`orders`.`commisionRate`" => "commisionRate",
		"if(`orders`.`consigneeHour`,date_format(`orders`.`consigneeHour`,'%d/%m/%Y %h:%i %p'),'')" => "consigneeHour",
		"`orders`.`consigneePlace`" => "consigneePlace",
		"`orders`.`related`" => "related",
		"`orders`.`document`" => "document"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`orders`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo ordine */" => "Tipo ordine",
		"`orders`.`progressiveNr`" => "Numero progressivo",
		"`orders`.`trasmissionFor`" => "Formato Trasmissione",
		"`orders`.`consigneeID`" => "Codice Destinatario",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* ID Azienda */" => "ID Azienda",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Documento */" => "Documento",
		"`orders`.`multiOrder`" => "Numero",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Cliente */" => "Cliente",
		"IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') /* Supplier */" => "Supplier",
		"IF(    CHAR_LENGTH(`contacts1`.`name`), CONCAT_WS('',   `contacts1`.`name`), '') /* Impiegato */" => "Impiegato",
		"`orders`.`date`" => "Data Ordine",
		"`orders`.`requiredDate`" => "Data dell\'ordine",
		"`orders`.`shippedDate`" => "Data di spedizione",
		"IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') /* Spedizione a mezzo */" => "Spedizione a mezzo",
		"`orders`.`Freight`" => "Nolo",
		"`orders`.`pallets`" => "Pallets",
		"`orders`.`licencePlate`" => "Targa Automezzo",
		"`orders`.`orderTotal`" => "Totale ordine",
		"`orders`.`cashCredit`" => "Credito o cassa",
		"`orders`.`trust`" => "Fido Cliente",
		"`orders`.`overdraft`" => "Scoperto Cliente",
		"`orders`.`commisionFee`" => "Provvigione su ordine",
		"`orders`.`commisionRate`" => "CommisionRate",
		"`orders`.`consigneeHour`" => "Ora di consegna",
		"`orders`.`consigneePlace`" => "Luogo consegna",
		"`orders`.`related`" => "Related",
		"`orders`.`document`" => "Document"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`orders`.`id`" => "id",
		"IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') /* Tipo ordine */" => "kind",
		"`orders`.`progressiveNr`" => "Numero progressivo",
		"`orders`.`trasmissionFor`" => "Formato Trasmissione",
		"`orders`.`consigneeID`" => "Codice Destinatario",
		"IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') /* ID Azienda */" => "company",
		"IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') /* Documento */" => "typeDoc",
		"`orders`.`multiOrder`" => "multiOrder",
		"IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') /* Cliente */" => "customer",
		"IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') /* Supplier */" => "supplier",
		"IF(    CHAR_LENGTH(`contacts1`.`name`), CONCAT_WS('',   `contacts1`.`name`), '') /* Impiegato */" => "employee",
		"if(`orders`.`date`,date_format(`orders`.`date`,'%d/%m/%Y'),'')" => "date",
		"if(`orders`.`requiredDate`,date_format(`orders`.`requiredDate`,'%d/%m/%Y'),'')" => "requiredDate",
		"if(`orders`.`shippedDate`,date_format(`orders`.`shippedDate`,'%d/%m/%Y'),'')" => "shippedDate",
		"IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') /* Spedizione a mezzo */" => "shipVia",
		"`orders`.`Freight`" => "Freight",
		"`orders`.`pallets`" => "pallets",
		"`orders`.`licencePlate`" => "Targa Automezzo",
		"`orders`.`orderTotal`" => "orderTotal",
		"concat('<i class=\"glyphicon glyphicon-', if(`orders`.`cashCredit`, 'check', 'unchecked'), '\"></i>')" => "cashCredit",
		"`orders`.`trust`" => "trust",
		"`orders`.`overdraft`" => "overdraft",
		"`orders`.`commisionFee`" => "commisionFee",
		"`orders`.`commisionRate`" => "commisionRate",
		"if(`orders`.`consigneeHour`,date_format(`orders`.`consigneeHour`,'%d/%m/%Y %h:%i %p'),'')" => "consigneeHour",
		"`orders`.`consigneePlace`" => "consigneePlace",
		"`orders`.`related`" => "related",
		"`orders`.`document`" => "document"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'kind' => 'Tipo ordine', 'company' => 'ID Azienda', 'typeDoc' => 'Documento', 'customer' => 'Cliente', 'supplier' => 'Supplier', 'employee' => 'Impiegato', 'shipVia' => 'Spedizione a mezzo');

	$x->QueryFrom = "`orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
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
	$x->RecordsPerPage = 50;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "orders_view.php";
	$x->RedirectAfterInsert = "orders_view.php?SelectedID=#ID#";
	$x->TableTitle = "Ordini";
	$x->TableIcon = "resources/table_icons/cart_remove.png";
	$x->PrimaryKey = "`orders`.`id`";
	$x->DefaultSortField = '1';
	$x->DefaultSortDirection = 'desc';

	$x->ColWidth   = array(  150, 150, 150, 150, 200, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Tipo ordine", "ID Azienda", "Documento", "Numero", "Cliente", "Supplier", "Data Ordine", "Data di spedizione", "Spedizione a mezzo", "Pallets", "Targa Automezzo", "Totale ordine", "Credito o cassa", "Provvigione su ordine", "CommisionRate", "Ora di consegna", "Luogo consegna");
	$x->ColFieldName = array('kind', 'company', 'typeDoc', 'multiOrder', 'customer', 'supplier', 'date', 'shippedDate', 'shipVia', 'pallets', 'licencePlate', 'orderTotal', 'cashCredit', 'commisionFee', 'commisionRate', 'consigneeHour', 'consigneePlace');
	$x->ColNumber  = array(2, 6, 7, 8, 9, 10, 12, 14, 15, 17, 18, 19, 20, 23, 24, 25, 26);

	// template paths below are based on the app main directory
	$x->Template = 'templates/orders_templateTV.html';
	$x->SelectedTemplate = 'templates/orders_templateTVS.html';
	$x->TemplateDV = 'templates/orders_templateDV.html';
	$x->TemplateDVP = 'templates/orders_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `orders`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='orders' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `orders`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='orders' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`orders`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: orders_init
	$render=TRUE;
	if(function_exists('orders_init')){
		$args=array();
		$render=orders_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// column sums
	if(strpos($x->HTML, '<!-- tv data below -->')){
		// if printing multi-selection TV, calculate the sum only for the selected records
		if(isset($_REQUEST['Print_x']) && is_array($_REQUEST['record_selector'])){
			$QueryWhere = '';
			foreach($_REQUEST['record_selector'] as $id){   // get selected records
				if($id != '') $QueryWhere .= "'" . makeSafe($id) . "',";
			}
			if($QueryWhere != ''){
				$QueryWhere = 'where `orders`.`id` in ('.substr($QueryWhere, 0, -1).')';
			}else{ // if no selected records, write the where clause to return an empty result
				$QueryWhere = 'where 1=0';
			}
		}else{
			$QueryWhere = $x->QueryWhere;
		}

		$sumQuery = "select sum(`orders`.`pallets`), sum(`orders`.`orderTotal`) from {$x->QueryFrom} {$QueryWhere}";
		$res = sql($sumQuery, $eo);
		if($row = db_fetch_row($res)){
			$sumRow = '<tr class="success">';
			if(!isset($_REQUEST['Print_x'])) $sumRow .= '<td class="text-center"><strong>&sum;</strong></td>';
			$sumRow .= '<td class="orders-kind"></td>';
			$sumRow .= '<td class="orders-company"></td>';
			$sumRow .= '<td class="orders-typeDoc"></td>';
			$sumRow .= '<td class="orders-multiOrder"></td>';
			$sumRow .= '<td class="orders-customer"></td>';
			$sumRow .= '<td class="orders-supplier"></td>';
			$sumRow .= '<td class="orders-date"></td>';
			$sumRow .= '<td class="orders-shippedDate"></td>';
			$sumRow .= '<td class="orders-shipVia"></td>';
			$sumRow .= "<td class=\"orders-pallets text-right\">{$row[0]}</td>";
			$sumRow .= '<td class="orders-licencePlate"></td>';
			$sumRow .= "<td class=\"orders-orderTotal text-right\">{$row[1]}</td>";
			$sumRow .= '<td class="orders-cashCredit"></td>';
			$sumRow .= '<td class="orders-commisionFee"></td>';
			$sumRow .= '<td class="orders-commisionRate"></td>';
			$sumRow .= '<td class="orders-consigneeHour"></td>';
			$sumRow .= '<td class="orders-consigneePlace"></td>';
			$sumRow .= '</tr>';

			$x->HTML = str_replace('<!-- tv data below -->', '', $x->HTML);
			$x->HTML = str_replace('<!-- tv data above -->', $sumRow, $x->HTML);
		}
	}

	// hook: orders_header
	$headerCode='';
	if(function_exists('orders_header')){
		$args=array();
		$headerCode=orders_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: orders_footer
	$footerCode='';
	if(function_exists('orders_footer')){
		$args=array();
		$footerCode=orders_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>