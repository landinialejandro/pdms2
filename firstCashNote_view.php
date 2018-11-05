<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/firstCashNote.php");
	include("$currDir/firstCashNote_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('firstCashNote');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "firstCashNote";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`firstCashNote`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Order */" => "order",
		"if(`firstCashNote`.`operationDate`,date_format(`firstCashNote`.`operationDate`,'%d/%m/%Y'),'')" => "operationDate",
		"`firstCashNote`.`documentNumber`" => "documentNumber",
		"`firstCashNote`.`causal`" => "causal",
		"`firstCashNote`.`revenue`" => "revenue",
		"`firstCashNote`.`outputs`" => "outputs",
		"`firstCashNote`.`balance`" => "balance",
		"`firstCashNote`.`idBank`" => "idBank",
		"`firstCashNote`.`bank`" => "bank",
		"`firstCashNote`.`note`" => "note",
		"if(`firstCashNote`.`paymentDeadLine`,date_format(`firstCashNote`.`paymentDeadLine`,'%d/%m/%Y'),'')" => "paymentDeadLine",
		"if(CHAR_LENGTH(`firstCashNote`.`payed`)>100, concat(left(`firstCashNote`.`payed`,100),' ...'), `firstCashNote`.`payed`)" => "payed"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`firstCashNote`.`id`',
		2 => '`orders1`.`id`',
		3 => '`firstCashNote`.`operationDate`',
		4 => '`firstCashNote`.`documentNumber`',
		5 => 5,
		6 => '`firstCashNote`.`revenue`',
		7 => '`firstCashNote`.`outputs`',
		8 => '`firstCashNote`.`balance`',
		9 => '`firstCashNote`.`idBank`',
		10 => '`firstCashNote`.`bank`',
		11 => 11,
		12 => '`firstCashNote`.`paymentDeadLine`',
		13 => 13
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`firstCashNote`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Order */" => "order",
		"if(`firstCashNote`.`operationDate`,date_format(`firstCashNote`.`operationDate`,'%d/%m/%Y'),'')" => "operationDate",
		"`firstCashNote`.`documentNumber`" => "documentNumber",
		"`firstCashNote`.`causal`" => "causal",
		"`firstCashNote`.`revenue`" => "revenue",
		"`firstCashNote`.`outputs`" => "outputs",
		"`firstCashNote`.`balance`" => "balance",
		"`firstCashNote`.`idBank`" => "idBank",
		"`firstCashNote`.`bank`" => "bank",
		"`firstCashNote`.`note`" => "note",
		"if(`firstCashNote`.`paymentDeadLine`,date_format(`firstCashNote`.`paymentDeadLine`,'%d/%m/%Y'),'')" => "paymentDeadLine",
		"`firstCashNote`.`payed`" => "payed"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`firstCashNote`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Order */" => "Order",
		"`firstCashNote`.`operationDate`" => "Data operazione",
		"`firstCashNote`.`documentNumber`" => "Numero ordine",
		"`firstCashNote`.`causal`" => "Causale",
		"`firstCashNote`.`revenue`" => "Entrate",
		"`firstCashNote`.`outputs`" => "Uscite",
		"`firstCashNote`.`balance`" => "Bilancio",
		"`firstCashNote`.`idBank`" => "IdBank",
		"`firstCashNote`.`bank`" => "Banca",
		"`firstCashNote`.`note`" => "Note pagamento",
		"`firstCashNote`.`paymentDeadLine`" => "Pagamento in data",
		"`firstCashNote`.`payed`" => "Pagato SI/NO"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`firstCashNote`.`id`" => "id",
		"IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') /* Order */" => "order",
		"if(`firstCashNote`.`operationDate`,date_format(`firstCashNote`.`operationDate`,'%d/%m/%Y'),'')" => "operationDate",
		"`firstCashNote`.`documentNumber`" => "documentNumber",
		"`firstCashNote`.`causal`" => "causal",
		"`firstCashNote`.`revenue`" => "revenue",
		"`firstCashNote`.`outputs`" => "outputs",
		"`firstCashNote`.`balance`" => "balance",
		"`firstCashNote`.`idBank`" => "idBank",
		"`firstCashNote`.`bank`" => "bank",
		"`firstCashNote`.`note`" => "note",
		"if(`firstCashNote`.`paymentDeadLine`,date_format(`firstCashNote`.`paymentDeadLine`,'%d/%m/%Y'),'')" => "paymentDeadLine",
		"`firstCashNote`.`payed`" => "Pagato SI/NO"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'order' => 'Order');

	$x->QueryFrom = "`firstCashNote` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`firstCashNote`.`order` ";
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
	$x->RecordsPerPage = 100;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "firstCashNote_view.php";
	$x->RedirectAfterInsert = "firstCashNote_view.php?SelectedID=#ID#";
	$x->TableTitle = "Prima Nota";
	$x->TableIcon = "resources/table_icons/data_sort.png";
	$x->PrimaryKey = "`firstCashNote`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Order", "Data operazione", "Numero ordine", "Causale", "Entrate", "Uscite", "Bilancio", "Banca", "Note pagamento", "Pagamento in data", "Pagato SI/NO");
	$x->ColFieldName = array('order', 'operationDate', 'documentNumber', 'causal', 'revenue', 'outputs', 'balance', 'bank', 'note', 'paymentDeadLine', 'payed');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 7, 8, 10, 11, 12, 13);

	// template paths below are based on the app main directory
	$x->Template = 'templates/firstCashNote_templateTV.html';
	$x->SelectedTemplate = 'templates/firstCashNote_templateTVS.html';
	$x->TemplateDV = 'templates/firstCashNote_templateDV.html';
	$x->TemplateDVP = 'templates/firstCashNote_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `firstCashNote`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='firstCashNote' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `firstCashNote`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='firstCashNote' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`firstCashNote`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: firstCashNote_init
	$render=TRUE;
	if(function_exists('firstCashNote_init')){
		$args=array();
		$render=firstCashNote_init($x, getMemberInfo(), $args);
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
				$QueryWhere = 'where `firstCashNote`.`id` in ('.substr($QueryWhere, 0, -1).')';
			}else{ // if no selected records, write the where clause to return an empty result
				$QueryWhere = 'where 1=0';
			}
		}else{
			$QueryWhere = $x->QueryWhere;
		}

		$sumQuery = "select sum(`firstCashNote`.`revenue`), sum(`firstCashNote`.`outputs`), sum(`firstCashNote`.`balance`) from {$x->QueryFrom} {$QueryWhere}";
		$res = sql($sumQuery, $eo);
		if($row = db_fetch_row($res)){
			$sumRow = '<tr class="success">';
			if(!isset($_REQUEST['Print_x'])) $sumRow .= '<td class="text-center"><strong>&sum;</strong></td>';
			$sumRow .= '<td class="firstCashNote-order"></td>';
			$sumRow .= '<td class="firstCashNote-operationDate"></td>';
			$sumRow .= '<td class="firstCashNote-documentNumber"></td>';
			$sumRow .= '<td class="firstCashNote-causal"></td>';
			$sumRow .= "<td class=\"firstCashNote-revenue text-right\">{$row[0]}</td>";
			$sumRow .= "<td class=\"firstCashNote-outputs text-right\">{$row[1]}</td>";
			$sumRow .= "<td class=\"firstCashNote-balance text-right\">{$row[2]}</td>";
			$sumRow .= '<td class="firstCashNote-bank"></td>';
			$sumRow .= '<td class="firstCashNote-note"></td>';
			$sumRow .= '<td class="firstCashNote-paymentDeadLine"></td>';
			$sumRow .= '<td class="firstCashNote-payed"></td>';
			$sumRow .= '</tr>';

			$x->HTML = str_replace('<!-- tv data below -->', '', $x->HTML);
			$x->HTML = str_replace('<!-- tv data above -->', $sumRow, $x->HTML);
		}
	}

	// hook: firstCashNote_header
	$headerCode='';
	if(function_exists('firstCashNote_header')){
		$args=array();
		$headerCode=firstCashNote_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: firstCashNote_footer
	$footerCode='';
	if(function_exists('firstCashNote_footer')){
		$args=array();
		$footerCode=firstCashNote_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>