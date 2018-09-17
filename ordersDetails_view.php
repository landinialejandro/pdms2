<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/ordersDetails.php");
	include("$currDir/ordersDetails_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('ordersDetails');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "ordersDetails";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "order",
		"if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%d/%m/%Y'),'')" => "manufactureDate",
		"if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%d/%m/%Y'),'')" => "sellDate",
		"if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%d/%m/%Y'),'')" => "expiryDate",
		"`ordersDetails`.`daysToExpiry`" => "daysToExpiry",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "codebar",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM */" => "UM",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice prodotto */" => "productCode",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "batch",
		"`ordersDetails`.`packages`" => "packages",
		"`ordersDetails`.`noSell`" => "noSell",
		"`ordersDetails`.`Quantity`" => "Quantity",
		"`ordersDetails`.`QuantityReal`" => "QuantityReal",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`UnitPrice`, 2))" => "UnitPrice",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`Subtotal`, 2))" => "Subtotal",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`taxes`, 2))" => "taxes",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`Discount`, 2))" => "Discount",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2))" => "LineTotal",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "section",
		"`ordersDetails`.`transaction_type`" => "transaction_type",
		"`ordersDetails`.`skBatches`" => "skBatches",
		"`ordersDetails`.`averagePrice`" => "averagePrice",
		"`ordersDetails`.`averageWeight`" => "averageWeight",
		"`ordersDetails`.`commission`" => "commission",
		"concat('<i class=\"glyphicon glyphicon-', if(`ordersDetails`.`return`, 'check', 'unchecked'), '\"></i>')" => "return",
		"`ordersDetails`.`supplierCode`" => "supplierCode"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`ordersDetails`.`id`',
		2 => '`orders1`.`id`',
		3 => '`ordersDetails`.`manufactureDate`',
		4 => '`ordersDetails`.`sellDate`',
		5 => '`ordersDetails`.`expiryDate`',
		6 => '`ordersDetails`.`daysToExpiry`',
		7 => '`products1`.`codebar`',
		8 => '`products1`.`UM`',
		9 => '`products1`.`productCode`',
		10 => 10,
		11 => '`ordersDetails`.`packages`',
		12 => '`ordersDetails`.`noSell`',
		13 => '`ordersDetails`.`Quantity`',
		14 => '`ordersDetails`.`QuantityReal`',
		15 => '`ordersDetails`.`UnitPrice`',
		16 => '`ordersDetails`.`Subtotal`',
		17 => '`ordersDetails`.`taxes`',
		18 => '`ordersDetails`.`Discount`',
		19 => '`ordersDetails`.`LineTotal`',
		20 => '`kinds1`.`code`',
		21 => 21,
		22 => '`ordersDetails`.`skBatches`',
		23 => '`ordersDetails`.`averagePrice`',
		24 => '`ordersDetails`.`averageWeight`',
		25 => '`ordersDetails`.`commission`',
		26 => 26,
		27 => 27
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "order",
		"if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%d/%m/%Y'),'')" => "manufactureDate",
		"if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%d/%m/%Y'),'')" => "sellDate",
		"if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%d/%m/%Y'),'')" => "expiryDate",
		"`ordersDetails`.`daysToExpiry`" => "daysToExpiry",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "codebar",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM */" => "UM",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice prodotto */" => "productCode",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "batch",
		"`ordersDetails`.`packages`" => "packages",
		"`ordersDetails`.`noSell`" => "noSell",
		"`ordersDetails`.`Quantity`" => "Quantity",
		"`ordersDetails`.`QuantityReal`" => "QuantityReal",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`UnitPrice`, 2))" => "UnitPrice",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`Subtotal`, 2))" => "Subtotal",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`taxes`, 2))" => "taxes",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`Discount`, 2))" => "Discount",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2))" => "LineTotal",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "section",
		"`ordersDetails`.`transaction_type`" => "transaction_type",
		"`ordersDetails`.`skBatches`" => "skBatches",
		"`ordersDetails`.`averagePrice`" => "averagePrice",
		"`ordersDetails`.`averageWeight`" => "averageWeight",
		"`ordersDetails`.`commission`" => "commission",
		"`ordersDetails`.`return`" => "return",
		"`ordersDetails`.`supplierCode`" => "supplierCode"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "Id Azienda",
		"`ordersDetails`.`manufactureDate`" => "Data produzione",
		"`ordersDetails`.`sellDate`" => "Data vendita",
		"`ordersDetails`.`expiryDate`" => "Data di scadenza",
		"`ordersDetails`.`daysToExpiry`" => "Giorni alla scadenza",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "Codebar",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM */" => "UM",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice prodotto */" => "Codice prodotto",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "Lotto",
		"`ordersDetails`.`packages`" => "Colli",
		"`ordersDetails`.`noSell`" => "Es. Colli",
		"`ordersDetails`.`Quantity`" => "Peso partenza",
		"`ordersDetails`.`QuantityReal`" => "Peso riscontrato",
		"`ordersDetails`.`UnitPrice`" => "Prezzo unitario",
		"`ordersDetails`.`Subtotal`" => "Imponibile",
		"`ordersDetails`.`taxes`" => "Imposta",
		"`ordersDetails`.`Discount`" => "Sconto",
		"`ordersDetails`.`LineTotal`" => "SubTotale",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "Reparto",
		"`ordersDetails`.`transaction_type`" => "Tipo transazione",
		"`ordersDetails`.`skBatches`" => "Giacenza",
		"`ordersDetails`.`averagePrice`" => "Prezzo medio giorno",
		"`ordersDetails`.`averageWeight`" => "Peso medio giorno",
		"`ordersDetails`.`commission`" => "Provvigione",
		"`ordersDetails`.`return`" => "Includi commissione",
		"`ordersDetails`.`supplierCode`" => "SupplierCode"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`ordersDetails`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Id Azienda */" => "order",
		"if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%d/%m/%Y'),'')" => "manufactureDate",
		"if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%d/%m/%Y'),'')" => "sellDate",
		"if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%d/%m/%Y'),'')" => "expiryDate",
		"`ordersDetails`.`daysToExpiry`" => "daysToExpiry",
		"IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') /* Codebar */" => "codebar",
		"IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') /* UM */" => "UM",
		"IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') /* Codice prodotto */" => "productCode",
		"IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') /* Lotto */" => "batch",
		"`ordersDetails`.`packages`" => "packages",
		"`ordersDetails`.`noSell`" => "noSell",
		"`ordersDetails`.`Quantity`" => "Quantity",
		"`ordersDetails`.`QuantityReal`" => "QuantityReal",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`UnitPrice`, 2))" => "UnitPrice",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`Subtotal`, 2))" => "Subtotal",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`taxes`, 2))" => "taxes",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`Discount`, 2))" => "Discount",
		"CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2))" => "LineTotal",
		"IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') /* Reparto */" => "section",
		"`ordersDetails`.`transaction_type`" => "transaction_type",
		"`ordersDetails`.`skBatches`" => "skBatches",
		"`ordersDetails`.`averagePrice`" => "averagePrice",
		"`ordersDetails`.`averageWeight`" => "averageWeight",
		"`ordersDetails`.`commission`" => "commission",
		"concat('<i class=\"glyphicon glyphicon-', if(`ordersDetails`.`return`, 'check', 'unchecked'), '\"></i>')" => "return",
		"`ordersDetails`.`supplierCode`" => "supplierCode"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'order' => 'Id Azienda', 'productCode' => 'Codice prodotto', 'section' => 'Reparto');

	$x->QueryFrom = "`ordersDetails` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`ordersDetails`.`order` LEFT JOIN `products` as products1 ON `products1`.`id`=`ordersDetails`.`productCode` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`ordersDetails`.`section` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 0;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 0;
	$x->RecordsPerPage = 50;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "ordersDetails_view.php";
	$x->RedirectAfterInsert = "ordersDetails_view.php?SelectedID=#ID#";
	$x->TableTitle = "Dettaglio Ordini vendita";
	$x->TableIcon = "resources/table_icons/calendar_view_month.png";
	$x->PrimaryKey = "`ordersDetails`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 75, 150, 75, 150, 150, 75, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Data produzione", "Data vendita", "UM", "Codice prodotto", "Colli", "Es. Colli", "Peso partenza", "Peso riscontrato", "Prezzo unitario", "Imponibile", "Imposta", "Sconto", "SubTotale", "Tipo transazione", "Prezzo medio giorno", "Peso medio giorno", "Provvigione", "Includi commissione", "SupplierCode");
	$x->ColFieldName = array('manufactureDate', 'sellDate', 'UM', 'productCode', 'packages', 'noSell', 'Quantity', 'QuantityReal', 'UnitPrice', 'Subtotal', 'taxes', 'Discount', 'LineTotal', 'transaction_type', 'averagePrice', 'averageWeight', 'commission', 'return', 'supplierCode');
	$x->ColNumber  = array(3, 4, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 23, 24, 25, 26, 27);

	// template paths below are based on the app main directory
	$x->Template = 'templates/ordersDetails_templateTV.html';
	$x->SelectedTemplate = 'templates/ordersDetails_templateTVS.html';
	$x->TemplateDV = 'templates/ordersDetails_templateDV.html';
	$x->TemplateDVP = 'templates/ordersDetails_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `ordersDetails`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='ordersDetails' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `ordersDetails`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='ordersDetails' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`ordersDetails`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: ordersDetails_init
	$render=TRUE;
	if(function_exists('ordersDetails_init')){
		$args=array();
		$render=ordersDetails_init($x, getMemberInfo(), $args);
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
				$QueryWhere = 'where `ordersDetails`.`id` in ('.substr($QueryWhere, 0, -1).')';
			}else{ // if no selected records, write the where clause to return an empty result
				$QueryWhere = 'where 1=0';
			}
		}else{
			$QueryWhere = $x->QueryWhere;
		}

		$sumQuery = "select sum(`ordersDetails`.`noSell`), sum(`ordersDetails`.`Quantity`), sum(`ordersDetails`.`QuantityReal`), CONCAT('&euro;', FORMAT(sum(`ordersDetails`.`Subtotal`), 2)), CONCAT('&euro;', FORMAT(sum(`ordersDetails`.`taxes`), 2)), CONCAT('&euro;', FORMAT(sum(`ordersDetails`.`Discount`), 2)), CONCAT('&euro;', FORMAT(sum(`ordersDetails`.`LineTotal`), 2)) from {$x->QueryFrom} {$QueryWhere}";
		$res = sql($sumQuery, $eo);
		if($row = db_fetch_row($res)){
			$sumRow = '<tr class="success">';
			if(!isset($_REQUEST['Print_x'])) $sumRow .= '<td class="text-center"><strong>&sum;</strong></td>';
			$sumRow .= '<td class="ordersDetails-manufactureDate"></td>';
			$sumRow .= '<td class="ordersDetails-sellDate"></td>';
			$sumRow .= '<td class="ordersDetails-UM"></td>';
			$sumRow .= '<td class="ordersDetails-productCode"></td>';
			$sumRow .= '<td class="ordersDetails-packages"></td>';
			$sumRow .= "<td class=\"ordersDetails-noSell text-right\">{$row[0]}</td>";
			$sumRow .= "<td class=\"ordersDetails-Quantity text-right\">{$row[1]}</td>";
			$sumRow .= "<td class=\"ordersDetails-QuantityReal text-right\">{$row[2]}</td>";
			$sumRow .= '<td class="ordersDetails-UnitPrice"></td>';
			$sumRow .= "<td class=\"ordersDetails-Subtotal text-right\">{$row[3]}</td>";
			$sumRow .= "<td class=\"ordersDetails-taxes text-right\">{$row[4]}</td>";
			$sumRow .= "<td class=\"ordersDetails-Discount text-right\">{$row[5]}</td>";
			$sumRow .= "<td class=\"ordersDetails-LineTotal text-right\">{$row[6]}</td>";
			$sumRow .= '<td class="ordersDetails-transaction_type"></td>';
			$sumRow .= '<td class="ordersDetails-averagePrice"></td>';
			$sumRow .= '<td class="ordersDetails-averageWeight"></td>';
			$sumRow .= '<td class="ordersDetails-commission"></td>';
			$sumRow .= '<td class="ordersDetails-return"></td>';
			$sumRow .= '<td class="ordersDetails-supplierCode"></td>';
			$sumRow .= '</tr>';

			$x->HTML = str_replace('<!-- tv data below -->', '', $x->HTML);
			$x->HTML = str_replace('<!-- tv data above -->', $sumRow, $x->HTML);
		}
	}

	// hook: ordersDetails_header
	$headerCode='';
	if(function_exists('ordersDetails_header')){
		$args=array();
		$headerCode=ordersDetails_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: ordersDetails_footer
	$footerCode='';
	if(function_exists('ordersDetails_footer')){
		$args=array();
		$footerCode=ordersDetails_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>