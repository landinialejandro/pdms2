<?php

	#########################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		getTableList() -- returns an associative array (tableName => tableData, tableData is array(tableCaption, tableDescription, tableIcon)) of tables accessible by current user
		get_table_groups() -- returns an associative array (table_group => tables_array)
		logInMember() -- checks POST login. If not valid, redirects to index.php, else returns TRUE
		getTablePermissions($tn) -- returns an array of permissions allowed for logged member to given table (allowAccess, allowInsert, allowView, allowEdit, allowDelete) -- allowAccess is set to true if any access level is allowed
		get_sql_fields($tn) -- returns the SELECT part of the table view query
		get_sql_from($tn[, true]) -- returns the FROM part of the table view query, with full joins, optionally skipping permissions if true passed as 2nd param.
		get_joined_record($table, $id[, true]) -- returns assoc array of record values for given PK value of given table, with full joins, optionally skipping permissions if true passed as 3rd param.
		get_defaults($table) -- returns assoc array of table fields as array keys and default values (or empty), excluding automatic values as array values
		htmlUserBar() -- returns html code for displaying user login status to be used on top of pages.
		showNotifications($msg, $class) -- returns html code for displaying a notification. If no parameters provided, processes the GET request for possible notifications.
		parseMySQLDate(a, b) -- returns a if valid mysql date, or b if valid mysql date, or today if b is true, or empty if b is false.
		parseCode(code) -- calculates and returns special values to be inserted in automatic fields.
		addFilter(i, filterAnd, filterField, filterOperator, filterValue) -- enforce a filter over data
		clearFilters() -- clear all filters
		loadView($view, $data) -- passes $data to templates/{$view}.php and returns the output
		loadTable($table, $data) -- loads table template, passing $data to it
		filterDropdownBy($filterable, $filterers, $parentFilterers, $parentPKField, $parentCaption, $parentTable, &$filterableCombo) -- applies cascading drop-downs for a lookup field, returns js code to be inserted into the page
		br2nl($text) -- replaces all variations of HTML <br> tags with a new line character
		htmlspecialchars_decode($text) -- inverse of htmlspecialchars()
		entitiesToUTF8($text) -- convert unicode entities (e.g. &#1234;) to actual UTF8 characters, requires multibyte string PHP extension
		func_get_args_byref() -- returns an array of arguments passed to a function, by reference
		permissions_sql($table, $level) -- returns an array containing the FROM and WHERE additions for applying permissions to an SQL query
		error_message($msg[, $back_url]) -- returns html code for a styled error message .. pass explicit false in second param to suppress back button
		toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format)
		reIndex(&$arr) -- returns a copy of the given array, with keys replaced by 1-based numeric indices, and values replaced by original keys
		get_embed($provider, $url[, $width, $height, $retrieve]) -- returns embed code for a given url (supported providers: youtube, googlemap)
		check_record_permission($table, $id, $perm = 'view') -- returns true if current user has the specified permission $perm ('view', 'edit' or 'delete') for the given recors, false otherwise
		NavMenus($options) -- returns the HTML code for the top navigation menus. $options is not implemented currently.
		StyleSheet() -- returns the HTML code for included style sheet files to be placed in the <head> section.
		getUploadDir($dir) -- if dir is empty, returns upload dir configured in defaultLang.php, else returns $dir.
		PrepareUploadedFile($FieldName, $MaxSize, $FileTypes='jpg|jpeg|gif|png', $NoRename=false, $dir="") -- validates and moves uploaded file for given $FieldName into the given $dir (or the default one if empty)
		get_home_links($homeLinks, $default_classes, $tgroup) -- process $homeLinks array and return custom links for homepage. Applies $default_classes to links if links have classes defined, and filters links by $tgroup (using '*' matches all table_group values)
		quick_search_html($search_term, $label, $separate_dv = true) -- returns HTML code for the quick search box.
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/

	#########################################################

	function getTableList($skip_authentication = false){
		$arrAccessTables = array();
		$arrTables = array(
			/* 'table_name' => ['table caption', 'homepage description', 'icon', 'table group name'] */   
			'orders' => array('Ordini', 'Ordini fatti dai clienti, con i nuovi ordini elencati per primi.<br> La cronologia degli ordini puo essere specificata utilizzando <br>un filtro con numerose opzioni di scelta.', 'resources/table_icons/cart_remove.png', 'Documenti'),
			'ordersDetails' => array('Dettaglio Ordini vendita', '', 'resources/table_icons/calendar_view_month.png', 'hiddens'),
			'products' => array('Articoli Magazzino', 'Oltre all\'accesso ai dettagli dei prodotti, &#232; anche possibile accedere alla cronologia degli ordini di ogni<br> singolo prodotto da qui.', 'resources/table_icons/installer_box.png', 'Catalogo'),
			'firstCashNote' => array('Prima Nota', '', 'resources/table_icons/data_sort.png', 'Prima Nota'),
			'vatRegister' => array('Registro Corrispettivi', '', 'resources/table_icons/book_spelling.png', 'Prima Nota'),
			'companies' => array('Companies', '', 'resources/table_icons/factory.png', 'Anagrafiche'),
			'contacts' => array('Contacts', '', 'resources/table_icons/client_account_template.png', 'Anagrafiche'),
			'creditDocument' => array('Nota Credito', '', 'resources/table_icons/card_credit.png', 'Anagrafiche'),
			'electronicInvoice' => array('ElectronicInvoice', '', 'resources/table_icons/document_editing.png', 'Anagrafiche'),
			'countries' => array('Countries', '', 'resources/table_icons/globe_model.png', 'Anagrafiche'),
			'town' => array('Comuni italiani', 'Elenco dei comuni italiani con i relativi codici.', 'resources/table_icons/italy.png', 'Anagrafiche'),
			'GPSTrackingSystem' => array('GPS Tracking System', 'Questa tabella, non disponibile al momento, serve per chi ha necessit&#224; di controllare i propri mezzi con un sistema di tracciamento GPS.<br>Si puo richiedere questa opzione a parte.', 'resources/table_icons/compass.png', 'Altro'),
			'kinds' => array('Entities Kinds', 'Config kind\'s name for Addreses, Phones, Companies, Mails, Orders, Products, Contacts...etc.', 'resources/table_icons/application_view_tile.png', 'Altro'),
			'Logs' => array('Logs', 'Questa tabella serve a tener traccia dei tentativi di accesso che possono risultare dannosi, tracciando l\'IP di provenienza.', 'resources/table_icons/centroid.png', 'Altro'),
			'attributes' => array('Attributes', '', 'resources/table_icons/application_form_add.png', 'hiddens'),
			'addresses' => array('Addresses', '', 'resources/table_icons/mail_box.png', 'hiddens'),
			'phones' => array('Phones', '', 'resources/table_icons/phone.png', 'hiddens'),
			'mails' => array('Mails', '', 'resources/table_icons/email.png', 'hiddens'),
			'contacts_companies' => array('Contacts companies', 'relate contacts with companies', 'resources/table_icons/brick_link.png', 'hiddens'),
			'attachments' => array('Attaches', '', 'resources/table_icons/attach.png', 'hiddens'),
			'_resumeOrders' => array(' resumeOrders', '', 'table.gif', 'Azienda A')
		);
		if($skip_authentication || getLoggedAdmin()) return $arrTables;

		if(is_array($arrTables)){
			foreach($arrTables as $tn => $tc){
				$arrPerm = getTablePermissions($tn);
				if($arrPerm[0]){
					$arrAccessTables[$tn] = $tc;
				}
			}
		}

		return $arrAccessTables;
	}

	#########################################################

	function get_table_groups($skip_authentication = false){
		$tables = getTableList($skip_authentication);
		$all_groups = array('Azienda A', 'Azienda B', 'Documenti', 'Catalogo', 'Prima Nota', 'Anagrafiche', 'Altro', 'hiddens');

		$groups = array();
		foreach($all_groups as $grp){
			foreach($tables as $tn => $td){
				if($td[3] && $td[3] == $grp) $groups[$grp][] = $tn;
				if(!$td[3]) $groups[0][] = $tn;
			}
		}

		return $groups;
	}

	#########################################################

	function getTablePermissions($tn){
		static $table_permissions = array();
		if(isset($table_permissions[$tn])) return $table_permissions[$tn];

		$groupID = getLoggedGroupID();
		$memberID = makeSafe(getLoggedMemberID());
		$res_group = sql("select tableName, allowInsert, allowView, allowEdit, allowDelete from membership_grouppermissions where groupID='{$groupID}'", $eo);
		$res_user = sql("select tableName, allowInsert, allowView, allowEdit, allowDelete from membership_userpermissions where lcase(memberID)='{$memberID}'", $eo);

		while($row = db_fetch_assoc($res_group)){
			$table_permissions[$row['tableName']] = array(
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			);
		}

		// user-specific permissions, if specified, overwrite his group permissions
		while($row = db_fetch_assoc($res_user)){
			$table_permissions[$row['tableName']] = array(
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			);
		}

		// if user has any type of access, set 'access' flag
		foreach($table_permissions as $t => $p){
			$table_permissions[$t]['access'] = $table_permissions[$t][0] = false;

			if($p['insert'] || $p['view'] || $p['edit'] || $p['delete']){
				$table_permissions[$t]['access'] = $table_permissions[$t][0] = true;
			}
		}

		return $table_permissions[$tn];
	}

	#########################################################

	function get_sql_fields($table_name){
		$sql_fields = array(   
			'orders' => "`orders`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `orders`.`progressiveNr` as 'progressiveNr', `orders`.`trasmissionFor` as 'trasmissionFor', `orders`.`consigneeID` as 'consigneeID', IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') as 'typeDoc', `orders`.`multiOrder` as 'multiOrder', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'customer', IF(    CHAR_LENGTH(`contacts1`.`name`), CONCAT_WS('',   `contacts1`.`name`), '') as 'employee', if(`orders`.`date`,date_format(`orders`.`date`,'%d/%m/%Y'),'') as 'date', if(`orders`.`requiredDate`,date_format(`orders`.`requiredDate`,'%d/%m/%Y'),'') as 'requiredDate', if(`orders`.`shippedDate`,date_format(`orders`.`shippedDate`,'%d/%m/%Y'),'') as 'shippedDate', IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') as 'shipVia', `orders`.`Freight` as 'Freight', `orders`.`pallets` as 'pallets', `orders`.`licencePlate` as 'licencePlate', `orders`.`orderTotal` as 'orderTotal', `orders`.`cashCredit` as 'cashCredit', `orders`.`trust` as 'trust', `orders`.`overdraft` as 'overdraft', `orders`.`commisionFee` as 'commisionFee', if(`orders`.`consigneeHour`,date_format(`orders`.`consigneeHour`,'%d/%m/%Y %h:%i %p'),'') as 'consigneeHour', `orders`.`consigneePlace` as 'consigneePlace', `orders`.`related` as 'related'",
			'ordersDetails' => "`ordersDetails`.`id` as 'id', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'order', if(`ordersDetails`.`manufactureDate`,date_format(`ordersDetails`.`manufactureDate`,'%d/%m/%Y'),'') as 'manufactureDate', if(`ordersDetails`.`sellDate`,date_format(`ordersDetails`.`sellDate`,'%d/%m/%Y'),'') as 'sellDate', if(`ordersDetails`.`expiryDate`,date_format(`ordersDetails`.`expiryDate`,'%d/%m/%Y'),'') as 'expiryDate', `ordersDetails`.`daysToExpiry` as 'daysToExpiry', IF(    CHAR_LENGTH(`products1`.`codebar`), CONCAT_WS('',   `products1`.`codebar`), '') as 'codebar', IF(    CHAR_LENGTH(`products1`.`UM`), CONCAT_WS('',   `products1`.`UM`), '') as 'UM', IF(    CHAR_LENGTH(`products1`.`productCode`), CONCAT_WS('',   `products1`.`productCode`), '') as 'productCode', IF(    CHAR_LENGTH(`products1`.`productCode`) || CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`productCode`, '-', `products1`.`id`), '') as 'batch', `ordersDetails`.`packages` as 'packages', `ordersDetails`.`noSell` as 'noSell', `ordersDetails`.`Quantity` as 'Quantity', `ordersDetails`.`QuantityReal` as 'QuantityReal', CONCAT('&euro;', FORMAT(`ordersDetails`.`UnitPrice`, 2)) as 'UnitPrice', CONCAT('&euro;', FORMAT(`ordersDetails`.`Subtotal`, 2)) as 'Subtotal', CONCAT('&euro;', FORMAT(`ordersDetails`.`taxes`, 2)) as 'taxes', `ordersDetails`.`Discount` as 'Discount', CONCAT('&euro;', FORMAT(`ordersDetails`.`LineTotal`, 2)) as 'LineTotal', IF(    CHAR_LENGTH(`kinds1`.`code`), CONCAT_WS('',   `kinds1`.`code`), '') as 'section', `ordersDetails`.`transaction_type` as 'transaction_type', `ordersDetails`.`skBatches` as 'skBatches', `ordersDetails`.`averagePrice` as 'averagePrice', `ordersDetails`.`averageWeight` as 'averageWeight', `ordersDetails`.`commission` as 'commission', `ordersDetails`.`return` as 'return', `ordersDetails`.`supplierCode` as 'supplierCode'",
			'products' => "`products`.`id` as 'id', `products`.`codebar` as 'codebar', `products`.`productCode` as 'productCode', `products`.`productName` as 'productName', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'tax', `products`.`increment` as 'increment', IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') as 'CategoryID', `products`.`UM` as 'UM', `products`.`tare` as 'tare', `products`.`QuantityPerUnit` as 'QuantityPerUnit', CONCAT('&euro;', FORMAT(`products`.`UnitPrice`, 2)) as 'UnitPrice', CONCAT('&euro;', FORMAT(`products`.`sellPrice`, 2)) as 'sellPrice', `products`.`UnitsInStock` as 'UnitsInStock', `products`.`UnitsOnOrder` as 'UnitsOnOrder', `products`.`ReorderLevel` as 'ReorderLevel', `products`.`balance` as 'balance', `products`.`Discontinued` as 'Discontinued', if(`products`.`manufactured_date`,date_format(`products`.`manufactured_date`,'%d/%m/%Y'),'') as 'manufactured_date', if(`products`.`expiry_date`,date_format(`products`.`expiry_date`,'%d/%m/%Y'),'') as 'expiry_date', `products`.`note` as 'note', if(`products`.`update_date`,date_format(`products`.`update_date`,'%d/%m/%Y %h:%i %p'),'') as 'update_date'",
			'firstCashNote' => "`firstCashNote`.`id` as 'id', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'order', if(`firstCashNote`.`operationDate`,date_format(`firstCashNote`.`operationDate`,'%d/%m/%Y'),'') as 'operationDate', `firstCashNote`.`documentNumber` as 'documentNumber', `firstCashNote`.`causal` as 'causal', `firstCashNote`.`revenue` as 'revenue', `firstCashNote`.`outputs` as 'outputs', `firstCashNote`.`balance` as 'balance', `firstCashNote`.`idBank` as 'idBank', `firstCashNote`.`bank` as 'bank', `firstCashNote`.`note` as 'note', if(`firstCashNote`.`paymentDeadLine`,date_format(`firstCashNote`.`paymentDeadLine`,'%d/%m/%Y'),'') as 'paymentDeadLine', `firstCashNote`.`payed` as 'payed'",
			'vatRegister' => "`vatRegister`.`id` as 'id', IF(    CHAR_LENGTH(`companies1`.`companyCode`), CONCAT_WS('',   `companies1`.`companyCode`), '') as 'idCompany', IF(    CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyName`), '') as 'companyName', `vatRegister`.`tax` as 'tax', `vatRegister`.`month` as 'month', `vatRegister`.`year` as 'year', `vatRegister`.`amount` as 'amount'",
			'companies' => "`companies`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `companies`.`companyCode` as 'companyCode', `companies`.`companyName` as 'companyName', `companies`.`fiscalCode` as 'fiscalCode', `companies`.`vat` as 'vat', `companies`.`notes` as 'notes'",
			'contacts' => "`contacts`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `contacts`.`titleCourtesy` as 'titleCourtesy', `contacts`.`name` as 'name', `contacts`.`lastName` as 'lastName', `contacts`.`notes` as 'notes', `contacts`.`title` as 'title', if(`contacts`.`birthDate`,date_format(`contacts`.`birthDate`,'%d/%m/%Y %h:%i %p'),'') as 'birthDate'",
			'creditDocument' => "`creditDocument`.`id` as 'id', `creditDocument`.`incomingTypeDoc` as 'incomingTypeDoc', `creditDocument`.`customerID` as 'customerID', `creditDocument`.`nrDoc` as 'nrDoc', if(`creditDocument`.`dateIncomingNote`,date_format(`creditDocument`.`dateIncomingNote`,'%d/%m/%Y'),'') as 'dateIncomingNote', `creditDocument`.`customerFirm` as 'customerFirm', `creditDocument`.`customerAddress` as 'customerAddress', `creditDocument`.`customerPostCode` as 'customerPostCode', `creditDocument`.`customerTown` as 'customerTown'",
			'electronicInvoice' => "`electronicInvoice`.`id` as 'id', `electronicInvoice`.`topic` as 'topic', `electronicInvoice`.`currency` as 'currency', `electronicInvoice`.`trasmissionFormat` as 'trasmissionFormat', `electronicInvoice`.`country` as 'country'",
			'countries' => "`countries`.`id` as 'id', `countries`.`country` as 'country', `countries`.`code` as 'code'",
			'town' => "`town`.`id` as 'id', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'country', `town`.`idIstat` as 'idIstat', `town`.`town` as 'town', `town`.`district` as 'district', `town`.`region` as 'region', `town`.`prefix` as 'prefix', `town`.`shipCode` as 'shipCode', `town`.`fiscCode` as 'fiscCode', `town`.`inhabitants` as 'inhabitants', `town`.`link` as 'link'",
			'GPSTrackingSystem' => "`GPSTrackingSystem`.`id` as 'id', `GPSTrackingSystem`.`carTracked` as 'carTracked'",
			'kinds' => "`kinds`.`entity` as 'entity', `kinds`.`code` as 'code', `kinds`.`name` as 'name', `kinds`.`value` as 'value', `kinds`.`descriptions` as 'descriptions'",
			'Logs' => "`Logs`.`id` as 'id', `Logs`.`ip` as 'ip', `Logs`.`ts` as 'ts', `Logs`.`details` as 'details'",
			'attributes' => "`attributes`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'attribute', `attributes`.`value` as 'value', IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'companies', IF(    CHAR_LENGTH(`products1`.`id`), CONCAT_WS('',   `products1`.`id`), '') as 'products'",
			'addresses' => "`addresses`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `addresses`.`address` as 'address', `addresses`.`houseNumber` as 'houseNumber', IF(    CHAR_LENGTH(`countries1`.`country`), CONCAT_WS('',   `countries1`.`country`), '') as 'country', IF(    CHAR_LENGTH(`town1`.`town`), CONCAT_WS('',   `town1`.`town`), '') as 'town', IF(    CHAR_LENGTH(`town1`.`shipCode`), CONCAT_WS('',   `town1`.`shipCode`), '') as 'postalCode', IF(    CHAR_LENGTH(`town2`.`district`), CONCAT_WS('',   `town2`.`district`), '') as 'district', IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company', `addresses`.`map` as 'map', `addresses`.`default` as 'default', `addresses`.`ship` as 'ship'",
			'phones' => "`phones`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `phones`.`phoneNumber` as 'phoneNumber', IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company'",
			'mails' => "`mails`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', `mails`.`mail` as 'mail', IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company'",
			'contacts_companies' => "`contacts_companies`.`id` as 'id', IF(    CHAR_LENGTH(`contacts1`.`name`), CONCAT_WS('',   `contacts1`.`name`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyName`), '') as 'company'",
			'attachments' => "`attachments`.`id` as 'id', `attachments`.`name` as 'name', `attachments`.`file` as 'file', IF(    CHAR_LENGTH(`contacts1`.`id`), CONCAT_WS('',   `contacts1`.`id`), '') as 'contact', IF(    CHAR_LENGTH(`companies1`.`id`), CONCAT_WS('',   `companies1`.`id`), '') as 'company', `attachments`.`thumbUse` as 'thumbUse'",
			'_resumeOrders' => "IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') as 'typedoc', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'customer', `_resumeOrders`.`TOT` as 'TOT', `_resumeOrders`.`MONTH` as 'MONTH', `_resumeOrders`.`YEAR` as 'YEAR', `_resumeOrders`.`DOCs` as 'DOCs', IF(    CHAR_LENGTH(`orders1`.`id`), CONCAT_WS('',   `orders1`.`id`), '') as 'realted', `_resumeOrders`.`id` as 'id'"
		);

		if(isset($sql_fields[$table_name])){
			return $sql_fields[$table_name];
		}

		return false;
	}

	#########################################################

	function get_sql_from($table_name, $skip_permissions = false){
		$sql_from = array(   
			'orders' => "`orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`orders`.`employee` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`shipVia` ",
			'ordersDetails' => "`ordersDetails` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`ordersDetails`.`order` LEFT JOIN `products` as products1 ON `products1`.`id`=`ordersDetails`.`productCode` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`ordersDetails`.`section` ",
			'products' => "`products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID` ",
			'firstCashNote' => "`firstCashNote` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`firstCashNote`.`order` ",
			'vatRegister' => "`vatRegister` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`vatRegister`.`idCompany` ",
			'companies' => "`companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind` ",
			'contacts' => "`contacts` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`contacts`.`kind` ",
			'creditDocument' => "`creditDocument` ",
			'electronicInvoice' => "`electronicInvoice` ",
			'countries' => "`countries` ",
			'town' => "`town` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`town`.`country` ",
			'GPSTrackingSystem' => "`GPSTrackingSystem` ",
			'kinds' => "`kinds` ",
			'Logs' => "`Logs` ",
			'attributes' => "`attributes` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`attributes`.`attribute` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`attributes`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`attributes`.`companies` LEFT JOIN `products` as products1 ON `products1`.`id`=`attributes`.`products` ",
			'addresses' => "`addresses` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`addresses`.`kind` LEFT JOIN `countries` as countries1 ON `countries1`.`id`=`addresses`.`country` LEFT JOIN `town` as town1 ON `town1`.`id`=`addresses`.`town` LEFT JOIN `town` as town2 ON `town2`.`id`=`addresses`.`district` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`addresses`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`addresses`.`company` ",
			'phones' => "`phones` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`phones`.`kind` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`phones`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`phones`.`company` ",
			'mails' => "`mails` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`mails`.`kind` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`mails`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`mails`.`company` ",
			'contacts_companies' => "`contacts_companies` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`contacts_companies`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`contacts_companies`.`company` ",
			'attachments' => "`attachments` LEFT JOIN `contacts` as contacts1 ON `contacts1`.`id`=`attachments`.`contact` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`attachments`.`company` ",
			'_resumeOrders' => "`_resumeOrders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`_resumeOrders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`_resumeOrders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`_resumeOrders`.`typedoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`_resumeOrders`.`customer` LEFT JOIN `orders` as orders1 ON `orders1`.`id`=`_resumeOrders`.`realted` "
		);

		$pkey = array(   
			'orders' => 'id',
			'ordersDetails' => 'id',
			'products' => 'id',
			'firstCashNote' => 'id',
			'vatRegister' => 'id',
			'companies' => 'id',
			'contacts' => 'id',
			'creditDocument' => 'id',
			'electronicInvoice' => 'id',
			'countries' => 'id',
			'town' => 'id',
			'GPSTrackingSystem' => 'id',
			'kinds' => 'code',
			'Logs' => 'id',
			'attributes' => 'id',
			'addresses' => 'id',
			'phones' => 'id',
			'mails' => 'id',
			'contacts_companies' => 'id',
			'attachments' => 'id',
			'_resumeOrders' => 'id'
		);

		if(isset($sql_from[$table_name])){
			if($skip_permissions) return $sql_from[$table_name];

			// mm: build the query based on current member's permissions
			$perm = getTablePermissions($table_name);
			if($perm[2] == 1){ // view owner only
				$sql_from[$table_name] .= ", membership_userrecords WHERE `{$table_name}`.`{$pkey[$table_name]}`=membership_userrecords.pkValue and membership_userrecords.tableName='{$table_name}' and lcase(membership_userrecords.memberID)='" . getLoggedMemberID() . "'";
			}elseif($perm[2] == 2){ // view group only
				$sql_from[$table_name] .= ", membership_userrecords WHERE `{$table_name}`.`{$pkey[$table_name]}`=membership_userrecords.pkValue and membership_userrecords.tableName='{$table_name}' and membership_userrecords.groupID='" . getLoggedGroupID() . "'";
			}elseif($perm[2] == 3){ // view all
				$sql_from[$table_name] .= ' WHERE 1=1';
			}else{ // view none
				return false;
			}
			return $sql_from[$table_name];
		}

		return false;
	}

	#########################################################

	function get_joined_record($table, $id, $skip_permissions = false){
		$sql_fields = get_sql_fields($table);
		$sql_from = get_sql_from($table, $skip_permissions);

		if(!$sql_fields || !$sql_from) return false;

		$pk = getPKFieldName($table);
		if(!$pk) return false;

		$safe_id = makeSafe($id, false);
		$sql = "SELECT {$sql_fields} FROM {$sql_from} AND `{$table}`.`{$pk}`='{$safe_id}'";
		$eo['silentErrors'] = true;
		$res = sql($sql, $eo);
		if($row = db_fetch_assoc($res)) return $row;

		return false;
	}

	#########################################################

	function get_defaults($table){
		/* array of tables and their fields, with default values (or empty), excluding automatic values */
		$defaults = array(
			'orders' => array(
				'id' => '',
				'kind' => '',
				'progressiveNr' => '',
				'trasmissionFor' => 'SDI10',
				'consigneeID' => '',
				'company' => '',
				'typeDoc' => '',
				'multiOrder' => '',
				'customer' => '',
				'employee' => '',
				'date' => '1',
				'requiredDate' => '',
				'shippedDate' => '',
				'shipVia' => '',
				'Freight' => '',
				'pallets' => '',
				'licencePlate' => '',
				'orderTotal' => '',
				'cashCredit' => '1',
				'trust' => '',
				'overdraft' => '',
				'commisionFee' => '',
				'consigneeHour' => '',
				'consigneePlace' => '',
				'related' => ''
			),
			'ordersDetails' => array(
				'id' => '',
				'order' => '',
				'manufactureDate' => '',
				'sellDate' => '',
				'expiryDate' => '',
				'daysToExpiry' => '',
				'codebar' => '',
				'UM' => '',
				'productCode' => '',
				'batch' => '',
				'packages' => '',
				'noSell' => '',
				'Quantity' => '1',
				'QuantityReal' => '',
				'UnitPrice' => '',
				'Subtotal' => '',
				'taxes' => '',
				'Discount' => '',
				'LineTotal' => '',
				'section' => 'Magazzino Metaponto',
				'transaction_type' => 'Outgoing',
				'skBatches' => '',
				'averagePrice' => '',
				'averageWeight' => '',
				'commission' => '15.00',
				'return' => '1',
				'supplierCode' => ''
			),
			'products' => array(
				'id' => '',
				'codebar' => '',
				'productCode' => '',
				'productName' => '',
				'tax' => '',
				'increment' => '',
				'CategoryID' => '',
				'UM' => '',
				'tare' => '',
				'QuantityPerUnit' => '',
				'UnitPrice' => '',
				'sellPrice' => '',
				'UnitsInStock' => '',
				'UnitsOnOrder' => '0',
				'ReorderLevel' => '0',
				'balance' => '',
				'Discontinued' => '0',
				'manufactured_date' => '',
				'expiry_date' => '',
				'note' => '',
				'update_date' => ''
			),
			'firstCashNote' => array(
				'id' => '',
				'order' => '',
				'operationDate' => '',
				'documentNumber' => '',
				'causal' => '',
				'revenue' => '',
				'outputs' => '',
				'balance' => '',
				'idBank' => '',
				'bank' => '',
				'note' => '',
				'paymentDeadLine' => '',
				'payed' => '0'
			),
			'vatRegister' => array(
				'id' => '',
				'idCompany' => '',
				'companyName' => '',
				'tax' => '4%',
				'month' => '',
				'year' => '2018',
				'amount' => ''
			),
			'companies' => array(
				'id' => '',
				'kind' => '',
				'companyCode' => '',
				'companyName' => '',
				'fiscalCode' => '',
				'vat' => '',
				'notes' => ''
			),
			'contacts' => array(
				'id' => '',
				'kind' => '',
				'titleCourtesy' => '',
				'name' => '',
				'lastName' => '',
				'notes' => '',
				'title' => '',
				'birthDate' => ''
			),
			'creditDocument' => array(
				'id' => '',
				'incomingTypeDoc' => '',
				'customerID' => '',
				'nrDoc' => '',
				'dateIncomingNote' => '',
				'customerFirm' => '',
				'customerAddress' => '',
				'customerPostCode' => '',
				'customerTown' => ''
			),
			'electronicInvoice' => array(
				'id' => '',
				'topic' => '',
				'currency' => 'IT',
				'trasmissionFormat' => '',
				'country' => 'IT'
			),
			'countries' => array(
				'id' => '',
				'country' => '',
				'code' => ''
			),
			'town' => array(
				'id' => '',
				'country' => '',
				'idIstat' => '',
				'town' => '',
				'district' => '',
				'region' => '',
				'prefix' => '',
				'shipCode' => '',
				'fiscCode' => '',
				'inhabitants' => '',
				'link' => ''
			),
			'GPSTrackingSystem' => array(
				'id' => '',
				'carTracked' => ''
			),
			'kinds' => array(
				'entity' => '',
				'code' => '',
				'name' => '',
				'value' => '',
				'descriptions' => ''
			),
			'Logs' => array(
				'id' => '',
				'ip' => '',
				'ts' => '',
				'details' => ''
			),
			'attributes' => array(
				'id' => '',
				'attribute' => '',
				'value' => '',
				'contact' => '',
				'companies' => '',
				'products' => ''
			),
			'addresses' => array(
				'id' => '',
				'kind' => '',
				'address' => '',
				'houseNumber' => '',
				'country' => 'IT',
				'town' => '',
				'postalCode' => '',
				'district' => '',
				'contact' => '',
				'company' => '',
				'map' => '',
				'default' => '0',
				'ship' => '0'
			),
			'phones' => array(
				'id' => '',
				'kind' => '',
				'phoneNumber' => '',
				'contact' => '',
				'company' => ''
			),
			'mails' => array(
				'id' => '',
				'kind' => '',
				'mail' => '',
				'contact' => '',
				'company' => ''
			),
			'contacts_companies' => array(
				'id' => '',
				'contact' => '',
				'company' => ''
			),
			'attachments' => array(
				'id' => '',
				'name' => '',
				'file' => '',
				'contact' => '',
				'company' => '',
				'thumbUse' => ''
			),
			'_resumeOrders' => array(
				'kind' => '',
				'company' => '',
				'typedoc' => '',
				'customer' => '',
				'TOT' => '',
				'MONTH' => '',
				'YEAR' => '',
				'DOCs' => '',
				'realted' => '',
				'id' => ''
			)
		);

		return isset($defaults[$table]) ? $defaults[$table] : array();
	}

	#########################################################

	function logInMember(){
		$redir = 'index.php';
		if($_POST['signIn'] != ''){
			if($_POST['username'] != '' && $_POST['password'] != ''){
				$username = makeSafe(strtolower($_POST['username']));
				$password = md5($_POST['password']);

				if(sqlValue("select count(1) from membership_users where lcase(memberID)='$username' and passMD5='$password' and isApproved=1 and isBanned=0")==1){
					$_SESSION['memberID']=$username;
					$_SESSION['memberGroupID']=sqlValue("select groupID from membership_users where lcase(memberID)='$username'");
					if($_POST['rememberMe']==1){
						@setcookie('PDMS_rememberMe', md5($username.$password), time()+86400*30);
					}else{
						@setcookie('PDMS_rememberMe', '', time()-86400*30);
					}

					// hook: login_ok
					if(function_exists('login_ok')){
						$args=array();
						if(!$redir=login_ok(getMemberInfo(), $args)){
							$redir='index.php';
						}
					}

					redirect($redir);
					exit;
				}
			}

			// hook: login_failed
			if(function_exists('login_failed')){
				$args=array();
				login_failed(array(
					'username' => $_POST['username'],
					'password' => $_POST['password'],
					'IP' => $_SERVER['REMOTE_ADDR']
					), $args);
			}

			if(!headers_sent()) header('HTTP/1.0 403 Forbidden');
			redirect("index.php?loginFailed=1");
			exit;
		}elseif((!$_SESSION['memberID'] || $_SESSION['memberID']==$adminConfig['anonymousMember']) && $_COOKIE['PDMS_rememberMe']!=''){
			$chk=makeSafe($_COOKIE['PDMS_rememberMe']);
			if($username=sqlValue("select memberID from membership_users where convert(md5(concat(memberID, passMD5)), char)='$chk' and isBanned=0")){
				$_SESSION['memberID']=$username;
				$_SESSION['memberGroupID']=sqlValue("select groupID from membership_users where lcase(memberID)='$username'");
			}
		}
	}

	#########################################################

	function htmlUserBar(){
		global $adminConfig, $Translation;
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');

		ob_start();
		$home_page = (basename($_SERVER['PHP_SELF'])=='index.php' ? true : false);

		?>
		<nav class="navbar navbar-default navbar-fixed-top hidden-print" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- application title is obtained from the name besides the yellow database icon in AppGini, use underscores for spaces -->
				<a class="navbar-brand" href="<?php echo PREPEND_PATH; ?>index.php"><i class="glyphicon glyphicon-home"></i> PDMS</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php if(!$home_page){ ?>
						<?php echo NavMenus(); ?>
					<?php } ?>
				</ul>

				<?php if(getLoggedAdmin()){ ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn hidden-xs" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn visible-xs btn-lg" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
					</ul>
				<?php } ?>

				<?php if(!$_GET['signIn'] && !$_GET['loginFailed']){ ?>
					<?php if(getLoggedMemberID() == $adminConfig['anonymousMember']){ ?>
						<p class="navbar-text navbar-right">&nbsp;</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success navbar-btn navbar-right"><?php echo $Translation['sign in']; ?></a>
						<p class="navbar-text navbar-right">
							<?php echo $Translation['not signed in']; ?>
						</p>
					<?php }else{ ?>
						<ul class="nav navbar-nav navbar-right hidden-xs" style="min-width: 330px;">
							<a class="btn navbar-btn btn-default" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link"><?php echo getLoggedMemberID(); ?></a></strong>
							</p>
						</ul>
						<ul class="nav navbar-nav visible-xs">
							<a class="btn navbar-btn btn-default btn-lg visible-xs" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text text-center">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link"><?php echo getLoggedMemberID(); ?></a></strong>
							</p>
						</ul>
						<script>
							/* periodically check if user is still signed in */
							setInterval(function(){
								$j.ajax({
									url: '<?php echo PREPEND_PATH; ?>ajax_check_login.php',
									success: function(username){
										if(!username.length) window.location = '<?php echo PREPEND_PATH; ?>index.php?signIn=1';
									}
								});
							}, 60000);
						</script>
					<?php } ?>
				<?php } ?>
			</div>
		</nav>
		<?php

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	#########################################################

	function showNotifications($msg = '', $class = '', $fadeout = true){
		global $Translation;

		$notify_template_no_fadeout = '<div id="%%ID%%" class="alert alert-dismissable %%CLASS%%" style="display: none; padding-top: 6px; padding-bottom: 6px;">' .
					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
					'%%MSG%%</div>' .
					'<script> jQuery(function(){ /* */ jQuery("#%%ID%%").show("slow"); }); </script>'."\n";
		$notify_template = '<div id="%%ID%%" class="alert %%CLASS%%" style="display: none; padding-top: 6px; padding-bottom: 6px;">%%MSG%%</div>' .
					'<script>' .
						'jQuery(function(){' .
							'jQuery("#%%ID%%").show("slow", function(){' .
								'setTimeout(function(){ /* */ jQuery("#%%ID%%").hide("slow"); }, 4000);' .
							'});' .
						'});' .
					'</script>'."\n";

		if(!$msg){ // if no msg, use url to detect message to display
			if($_REQUEST['record-added-ok'] != ''){
				$msg = $Translation['new record saved'];
				$class = 'alert-success';
			}elseif($_REQUEST['record-added-error'] != ''){
				$msg = $Translation['Couldn\'t save the new record'];
				$class = 'alert-danger';
				$fadeout = false;
			}elseif($_REQUEST['record-updated-ok'] != ''){
				$msg = $Translation['record updated'];
				$class = 'alert-success';
			}elseif($_REQUEST['record-updated-error'] != ''){
				$msg = $Translation['Couldn\'t save changes to the record'];
				$class = 'alert-danger';
				$fadeout = false;
			}elseif($_REQUEST['record-deleted-ok'] != ''){
				$msg = $Translation['The record has been deleted successfully'];
				$class = 'alert-success';
				$fadeout = false;
			}elseif($_REQUEST['record-deleted-error'] != ''){
				$msg = $Translation['Couldn\'t delete this record'];
				$class = 'alert-danger';
				$fadeout = false;
			}else{
				return '';
			}
		}
		$id = 'notification-' . rand();

		$out = ($fadeout ? $notify_template : $notify_template_no_fadeout);
		$out = str_replace('%%ID%%', $id, $out);
		$out = str_replace('%%MSG%%', $msg, $out);
		$out = str_replace('%%CLASS%%', $class, $out);

		return $out;
	}

	#########################################################

	function parseMySQLDate($date, $altDate){
		// is $date valid?
		if(preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", trim($date))){
			return trim($date);
		}

		if($date != '--' && preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", trim($altDate))){
			return trim($altDate);
		}

		if($date != '--' && $altDate && intval($altDate)==$altDate){
			return @date('Y-m-d', @time() + ($altDate >= 1 ? $altDate - 1 : $altDate) * 86400);
		}

		return '';
	}

	#########################################################

	function parseCode($code, $isInsert=true, $rawData=false){
		if($isInsert){
			$arrCodes=array(
				'<%%creatorusername%%>' => $_SESSION['memberID'],
				'<%%creatorgroupid%%>' => $_SESSION['memberGroupID'],
				'<%%creatorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%creatorgroup%%>' => sqlValue("select name from membership_groups where groupID='{$_SESSION['memberGroupID']}'"),

				'<%%creationdate%%>' => ($rawData ? @date('Y-m-d') : @date('j/n/Y')),
				'<%%creationtime%%>' => ($rawData ? @date('H:i:s') : @date('h:i:s a')),
				'<%%creationdatetime%%>' => ($rawData ? @date('Y-m-d H:i:s') : @date('j/n/Y h:i:s a')),
				'<%%creationtimestamp%%>' => ($rawData ? @date('Y-m-d H:i:s') : @time())
			);
		}else{
			$arrCodes=array(
				'<%%editorusername%%>' => $_SESSION['memberID'],
				'<%%editorgroupid%%>' => $_SESSION['memberGroupID'],
				'<%%editorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%editorgroup%%>' => sqlValue("select name from membership_groups where groupID='{$_SESSION['memberGroupID']}'"),

				'<%%editingdate%%>' => ($rawData ? @date('Y-m-d') : @date('j/n/Y')),
				'<%%editingtime%%>' => ($rawData ? @date('H:i:s') : @date('h:i:s a')),
				'<%%editingdatetime%%>' => ($rawData ? @date('Y-m-d H:i:s') : @date('j/n/Y h:i:s a')),
				'<%%editingtimestamp%%>' => ($rawData ? @date('Y-m-d H:i:s') : @time())
			);
		}

		$pc=str_ireplace(array_keys($arrCodes), array_values($arrCodes), $code);

		return $pc;
	}

	#########################################################

	function addFilter($index, $filterAnd, $filterField, $filterOperator, $filterValue){
		// validate input
		if($index < 1 || $index > 80 || !is_int($index)) return false;
		if($filterAnd != 'or')   $filterAnd = 'and';
		$filterField = intval($filterField);

		/* backward compatibility */
		if(in_array($filterOperator, $GLOBALS['filter_operators'])){
			$filterOperator = array_search($filterOperator, $GLOBALS['filter_operators']);
		}

		if(!in_array($filterOperator, array_keys($GLOBALS['filter_operators']))){
			$filterOperator = 'like';
		}

		if(!$filterField){
			$filterOperator = '';
			$filterValue = '';
		}

		$_REQUEST['FilterAnd'][$index] = $filterAnd;
		$_REQUEST['FilterField'][$index] = $filterField;
		$_REQUEST['FilterOperator'][$index] = $filterOperator;
		$_REQUEST['FilterValue'][$index] = $filterValue;

		return true;
	}

	#########################################################

	function clearFilters(){
		for($i=1; $i<=80; $i++){
			addFilter($i, '', 0, '', '');
		}
	}

	#########################################################

	if(!function_exists('str_ireplace')){
		function str_ireplace($search, $replace, $subject){
			$ret=$subject;
			if(is_array($search)){
				for($i=0; $i<count($search); $i++){
					$ret=str_ireplace($search[$i], $replace[$i], $ret);
				}
			}else{
				$ret=preg_replace('/'.preg_quote($search, '/').'/i', $replace, $ret);
			}

			return $ret;
		} 
	} 

	#########################################################

	/**
	* Loads a given view from the templates folder, passing the given data to it
	* @param $view the name of a php file (without extension) to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_view (optional) associative array containing the data to pass to the view
	* @return the output of the parsed view as a string
	*/
	function loadView($view, $the_data_to_pass_to_the_view=false){
		global $Translation;

		$view = dirname(__FILE__)."/templates/$view.php";
		if(!is_file($view)) return false;

		if(is_array($the_data_to_pass_to_the_view)){
			foreach($the_data_to_pass_to_the_view as $k => $v)
				$$k = $v;
		}
		unset($the_data_to_pass_to_the_view, $k, $v);

		ob_start();
		@include($view);
		$out=ob_get_contents();
		ob_end_clean();

		return $out;
	}

	#########################################################

	/**
	* Loads a table template from the templates folder, passing the given data to it
	* @param $table_name the name of the table whose template is to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_table associative array containing the data to pass to the table template
	* @return the output of the parsed table template as a string
	*/
	function loadTable($table_name, $the_data_to_pass_to_the_table = array()){
		$dont_load_header = $the_data_to_pass_to_the_table['dont_load_header'];
		$dont_load_footer = $the_data_to_pass_to_the_table['dont_load_footer'];

		$header = $table = $footer = '';

		if(!$dont_load_header){
			// try to load tablename-header
			if(!($header = loadView("{$table_name}-header", $the_data_to_pass_to_the_table))){
				$header = loadView('table-common-header', $the_data_to_pass_to_the_table);
			}
		}

		$table = loadView($table_name, $the_data_to_pass_to_the_table);

		if(!$dont_load_footer){
			// try to load tablename-footer
			if(!($footer = loadView("{$table_name}-footer", $the_data_to_pass_to_the_table))){
				$footer = loadView('table-common-footer', $the_data_to_pass_to_the_table);
			}
		}

		return "{$header}{$table}{$footer}";
	}

	#########################################################

	function filterDropdownBy($filterable, $filterers, $parentFilterers, $parentPKField, $parentCaption, $parentTable, &$filterableCombo){
		$filterersArray = explode(',', $filterers);
		$parentFilterersArray = explode(',', $parentFilterers);
		$parentFiltererList = '`' . implode('`, `', $parentFilterersArray) . '`';
		$res=sql("SELECT `$parentPKField`, $parentCaption, $parentFiltererList FROM `$parentTable` ORDER BY 2", $eo);
		$filterableData = array();
		while($row=db_fetch_row($res)){
			$filterableData[$row[0]] = $row[1];
			$filtererIndex = 0;
			foreach($filterersArray as $filterer){
				$filterableDataByFilterer[$filterer][$row[$filtererIndex + 2]][$row[0]] = $row[1];
				$filtererIndex++;
			}
			$row[0] = addslashes($row[0]);
			$row[1] = addslashes($row[1]);
			$jsonFilterableData .= "\"{$row[0]}\":\"{$row[1]}\",";
		}
		$jsonFilterableData .= '}';
		$jsonFilterableData = '{'.str_replace(',}', '}', $jsonFilterableData);     
		$filterJS = "\nvar {$filterable}_data = $jsonFilterableData;";

		foreach($filterersArray as $filterer){
			if(is_array($filterableDataByFilterer[$filterer])) foreach($filterableDataByFilterer[$filterer] as $filtererItem => $filterableItem){
				$jsonFilterableDataByFilterer[$filterer] .= '"'.addslashes($filtererItem).'":{';
				foreach($filterableItem as $filterableItemID => $filterableItemData){
					$jsonFilterableDataByFilterer[$filterer] .= '"'.addslashes($filterableItemID).'":"'.addslashes($filterableItemData).'",';
				}
				$jsonFilterableDataByFilterer[$filterer] .= '},';
			}
			$jsonFilterableDataByFilterer[$filterer] .= '}';
			$jsonFilterableDataByFilterer[$filterer] = '{'.str_replace(',}', '}', $jsonFilterableDataByFilterer[$filterer]);

			$filterJS.="\n\n// code for filtering {$filterable} by {$filterer}\n";
			$filterJS.="\nvar {$filterable}_data_by_{$filterer} = {$jsonFilterableDataByFilterer[$filterer]}; ";
			$filterJS.="\nvar selected_{$filterable} = \$j('#{$filterable}').val();";
			$filterJS.="\nvar {$filterable}_change_by_{$filterer} = function(){";
			$filterJS.="\n\t$('{$filterable}').options.length=0;";
			$filterJS.="\n\t$('{$filterable}').options[0] = new Option();";
			$filterJS.="\n\tif(\$j('#{$filterer}').val()){";
			$filterJS.="\n\t\tfor({$filterable}_item in {$filterable}_data_by_{$filterer}[\$j('#{$filterer}').val()]){";
			$filterJS.="\n\t\t\t$('{$filterable}').options[$('{$filterable}').options.length] = new Option(";
			$filterJS.="\n\t\t\t\t{$filterable}_data_by_{$filterer}[\$j('#{$filterer}').val()][{$filterable}_item],";
			$filterJS.="\n\t\t\t\t{$filterable}_item,";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false),";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false)";
			$filterJS.="\n\t\t\t);";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t}else{";
			$filterJS.="\n\t\tfor({$filterable}_item in {$filterable}_data){";
			$filterJS.="\n\t\t\t$('{$filterable}').options[$('{$filterable}').options.length] = new Option(";
			$filterJS.="\n\t\t\t\t{$filterable}_data[{$filterable}_item],";
			$filterJS.="\n\t\t\t\t{$filterable}_item,";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false),";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false)";
			$filterJS.="\n\t\t\t);";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t\tif(selected_{$filterable} && selected_{$filterable} == \$j('#{$filterable}').val()){";
			$filterJS.="\n\t\t\tfor({$filterer}_item in {$filterable}_data_by_{$filterer}){";
			$filterJS.="\n\t\t\t\tfor({$filterable}_item in {$filterable}_data_by_{$filterer}[{$filterer}_item]){";
			$filterJS.="\n\t\t\t\t\tif({$filterable}_item == selected_{$filterable}){";
			$filterJS.="\n\t\t\t\t\t\t$('{$filterer}').value = {$filterer}_item;";
			$filterJS.="\n\t\t\t\t\t\tbreak;";
			$filterJS.="\n\t\t\t\t\t}";
			$filterJS.="\n\t\t\t\t}";
			$filterJS.="\n\t\t\t\tif({$filterable}_item == selected_{$filterable}) break;";
			$filterJS.="\n\t\t\t}";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t}";
			$filterJS.="\n\t$('{$filterable}').highlight();";
			$filterJS.="\n};";
			$filterJS.="\n$('{$filterer}').observe('change', function(){ /* */ window.setTimeout({$filterable}_change_by_{$filterer}, 25); });";
			$filterJS.="\n";
		}

		$filterableCombo = new Combo;
		$filterableCombo->ListType = 0;
		$filterableCombo->ListItem = array_slice(array_values($filterableData), 0, 10);
		$filterableCombo->ListData = array_slice(array_keys($filterableData), 0, 10);
		$filterableCombo->SelectName = $filterable;
		$filterableCombo->AllowNull = true;

		return $filterJS;
	}

	#########################################################
	function br2nl($text){
		return  preg_replace('/\<br(\s*)?\/?\>/i', "\n", $text);
	}

	#########################################################

	if(!function_exists('htmlspecialchars_decode')){
		function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT){
			return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
		}
	}

	#########################################################

	function entitiesToUTF8($input){
		return preg_replace_callback('/(&#[0-9]+;)/', '_toUTF8', $input);
	}

	function _toUTF8($m){
		if(function_exists('mb_convert_encoding')){
			return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
		}else{
			return $m[1];
		}
	}

	#########################################################

	function func_get_args_byref() {
		if(!function_exists('debug_backtrace')) return false;

		$trace = debug_backtrace();
		return $trace[1]['args'];
	}

	#########################################################

	function permissions_sql($table, $level = 'all'){
		if(!in_array($level, array('user', 'group'))){ $level = 'all'; }
		$perm = getTablePermissions($table);
		$from = '';
		$where = '';
		$pk = getPKFieldName($table);

		if($perm[2] == 1 || ($perm[2] > 1 && $level == 'user')){ // view owner only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."')";
		}elseif($perm[2] == 2 || ($perm[2] > 2 && $level == 'group')){ // view group only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and membership_userrecords.groupID='".getLoggedGroupID()."')";
		}elseif($perm[2] == 3){ // view all
			// no further action
		}elseif($perm[2] == 0){ // view none
			return false;
		}

		return array('where' => $where, 'from' => $from, 0 => $where, 1 => $from);
	}

	#########################################################

	function error_message($msg, $back_url = '', $full_page = true){
		$curr_dir = dirname(__FILE__);
		global $Translation;

		ob_start();

		if($full_page) include_once($curr_dir . '/header.php');

		echo '<div class="panel panel-danger">';
			echo '<div class="panel-heading"><h3 class="panel-title">' . $Translation['error:'] . '</h3></div>';
			echo '<div class="panel-body"><p class="text-danger">' . $msg . '</p>';
			if($back_url !== false){ // explicitly passing false suppresses the back link completely
				echo '<div class="text-center">';
				if($back_url){
					echo '<a href="' . $back_url . '" class="btn btn-danger btn-lg vspacer-lg"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}else{
					echo '<a href="#" class="btn btn-danger btn-lg vspacer-lg" onclick="history.go(-1); return false;"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}
				echo '</div>';
			}
			echo '</div>';
		echo '</div>';

		if($full_page) include_once($curr_dir . '/footer.php');

		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}

	#########################################################

	function toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format){
		// extract date elements
		$de=explode($sep, $formattedDate);
		$mySQLDate=intval($de[strpos($ord, 'Y')]).'-'.intval($de[strpos($ord, 'm')]).'-'.intval($de[strpos($ord, 'd')]);
		return $mySQLDate;
	}

	#########################################################

	function reIndex(&$arr){
		$i=1;
		foreach($arr as $n=>$v){
			$arr2[$i]=$n;
			$i++;
		}
		return $arr2;
	}

	#########################################################

	function get_embed($provider, $url, $max_width = '', $max_height = '', $retrieve = 'html'){
		global $Translation;
		if(!$url) return '';

		$providers = array(
			'youtube' => array('oembed' => 'http://www.youtube.com/oembed?'),
			'googlemap' => array('oembed' => '', 'regex' => '/^http.*\.google\..*maps/i')
		);

		if(!isset($providers[$provider])){
			return '<div class="text-danger">' . $Translation['invalid provider'] . '</div>';
		}

		if(isset($providers[$provider]['regex']) && !preg_match($providers[$provider]['regex'], $url)){
			return '<div class="text-danger">' . $Translation['invalid url'] . '</div>';
		}

		if($providers[$provider]['oembed']){
			$oembed = $providers[$provider]['oembed'] . 'url=' . urlencode($url) . "&maxwidth={$max_width}&maxheight={$max_height}&format=json";
			$data_json = request_cache($oembed);

			$data = json_decode($data_json, true);
			if($data === null){
				/* an error was returned rather than a json string */
				if($retrieve == 'html') return "<div class=\"text-danger\">{$data_json}\n<!-- {$oembed} --></div>";
				return '';
			}

			return (isset($data[$retrieve]) ? $data[$retrieve] : $data['html']);
		}

		/* special cases (where there is no oEmbed provider) */
		if($provider == 'googlemap') return get_embed_googlemap($url, $max_width, $max_height, $retrieve);

		return '<div class="text-danger">Invalid provider!</div>';
	}

	#########################################################

	function get_embed_googlemap($url, $max_width = '', $max_height = '', $retrieve = 'html'){
		global $Translation;
		$url_parts = parse_url($url);
		$coords_regex = '/-?\d+(\.\d+)?[,+]-?\d+(\.\d+)?(,\d{1,2}z)?/'; /* https://stackoverflow.com/questions/2660201 */

		if(preg_match($coords_regex, $url_parts['path'] . '?' . $url_parts['query'], $m)){
			list($lat, $long, $zoom) = explode(',', $m[0]);
			$zoom = intval($zoom);
			if(!$zoom) $zoom = 10; /* default zoom */
			if(!$max_height) $max_height = 360;
			if(!$max_width) $max_width = 480;

			$api_key = '';
			$embed_url = "https://www.google.com/maps/embed/v1/view?key={$api_key}&center={$lat},{$long}&zoom={$zoom}&maptype=roadmap";
			$thumbnail_url = "https://maps.googleapis.com/maps/api/staticmap?key={$api_key}&center={$lat},{$long}&zoom={$zoom}&maptype=roadmap&size={$max_width}x{$max_height}";

			if($retrieve == 'html'){
				return "<iframe width=\"{$max_width}\" height=\"{$max_height}\" frameborder=\"0\" style=\"border:0\" src=\"{$embed_url}\"></iframe>";
			}else{
				return $thumbnail_url;
			}
		}else{
			return '<div class="text-danger">' . $Translation['cant retrieve coordinates from url'] . '</div>';
		}
	}

	#########################################################

	function request_cache($request, $force_fetch = false){
		$max_cache_lifetime = 7 * 86400; /* max cache lifetime in seconds before refreshing from source */

		/* membership_cache table exists? if not, create it */
		static $cache_table_exists = false;
		if(!$cache_table_exists && !$force_fetch){
			$te = sqlValue("show tables like 'membership_cache'");
			if(!$te){
				if(!sql("CREATE TABLE `membership_cache` (`request` VARCHAR(100) NOT NULL, `request_ts` INT, `response` TEXT NOT NULL, PRIMARY KEY (`request`))", $eo)){
					/* table can't be created, so force fetching request */
					return request_cache($request, true);
				}
			}
			$cache_table_exists = true;
		}

		/* retrieve response from cache if exists */
		if(!$force_fetch){
			$res = sql("select response, request_ts from membership_cache where request='" . md5($request) . "'", $eo);
			if(!$row = db_fetch_array($res)) return request_cache($request, true);

			$response = $row[0];
			$response_ts = $row[1];
			if($response_ts < time() - $max_cache_lifetime) return request_cache($request, true);
		}

		/* if no response in cache, issue a request */
		if(!$response || $force_fetch){
			$response = @file_get_contents($request);
			if($response === false){
				$error = error_get_last();
				$error_message = preg_replace('/.*: (.*)/', '$1', $error['message']);
				return $error_message;
			}elseif($cache_table_exists){
				/* store response in cache */
				$ts = time();
				sql("replace into membership_cache set request='" . md5($request) . "', request_ts='{$ts}', response='" . makeSafe($response, false) . "'", $eo);
			}
		}

		return $response;
	}

	#########################################################

	function check_record_permission($table, $id, $perm = 'view'){
		if($perm != 'edit' && $perm != 'delete') $perm = 'view';

		$perms = getTablePermissions($table);
		if(!$perms[$perm]) return false;

		$safe_id = makeSafe($id);
		$safe_table = makeSafe($table);

		if($perms[$perm] == 1){ // own records only
			$username = getLoggedMemberID();
			$owner = sqlValue("select memberID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner == $username) return true;
		}elseif($perms[$perm] == 2){ // group records
			$group_id = getLoggedGroupID();
			$owner_group_id = sqlValue("select groupID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner_group_id == $group_id) return true;
		}elseif($perms[$perm] == 3){ // all records
			return true;
		}

		return false;
	}

	#########################################################

	function NavMenus($options = array()){
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		global $Translation;
		$prepend_path = PREPEND_PATH;

		/* default options */
		if(empty($options)){
			$options = array(
				'tabs' => 7
			);
		}

		$table_group_name = array_keys(get_table_groups()); /* 0 => group1, 1 => group2 .. */
		/* if only one group named 'None', set to translation of 'select a table' */
		if((count($table_group_name) == 1 && $table_group_name[0] == 'None') || count($table_group_name) < 1) $table_group_name[0] = $Translation['select a table'];
		$table_group_index = array_flip($table_group_name); /* group1 => 0, group2 => 1 .. */
		$menu = array_fill(0, count($table_group_name), '');

		$t = time();
		$arrTables = getTableList();
		if(is_array($arrTables)){
			foreach($arrTables as $tn => $tc){
				/* ---- list of tables where hide link in nav menu is set ---- */
				$tChkHL = array_search($tn, array('ordersDetails','creditDocument'));

				/* ---- list of tables where filter first is set ---- */
				$tChkFF = array_search($tn, array());
				if($tChkFF !== false && $tChkFF !== null){
					$searchFirst = '&Filter_x=1';
				}else{
					$searchFirst = '';
				}

				/* when no groups defined, $table_group_index['None'] is NULL, so $menu_index is still set to 0 */
				$menu_index = intval($table_group_index[$tc[3]]);
				if(!$tChkHL && $tChkHL !== 0) $menu[$menu_index] .= "<li><a href=\"{$prepend_path}{$tn}_view.php?t={$t}{$searchFirst}\"><img src=\"{$prepend_path}" . ($tc[2] ? $tc[2] : 'blank.gif') . "\" height=\"32\"> {$tc[0]}</a></li>";
			}
		}

		// custom nav links, as defined in "hooks/links-navmenu.php" 
		global $navLinks;
		if(is_array($navLinks)){
			$memberInfo = getMemberInfo();
			$links_added = array();
			foreach($navLinks as $link){
				if(!isset($link['url']) || !isset($link['title'])) continue;
				if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
					$menu_index = intval($link['table_group']);
					if(!$links_added[$menu_index]) $menu[$menu_index] .= '<li class="divider"></li>';

					/* add prepend_path to custom links if they aren't absolute links */
					if(!preg_match('/^(http|\/\/)/i', $link['url'])) $link['url'] = $prepend_path . $link['url'];
					if(!preg_match('/^(http|\/\/)/i', $link['icon']) && $link['icon']) $link['icon'] = $prepend_path . $link['icon'];

					$menu[$menu_index] .= "<li><a href=\"{$link['url']}\"><img src=\"" . ($link['icon'] ? $link['icon'] : "{$prepend_path}blank.gif") . "\" height=\"32\"> {$link['title']}</a></li>";
					$links_added[$menu_index]++;
				}
			}
		}

		$menu_wrapper = '';
		for($i = 0; $i < count($menu); $i++){
			$menu_wrapper .= <<<EOT
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$table_group_name[$i]} <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">{$menu[$i]}</ul>
				</li>
EOT;
		}

		return $menu_wrapper;
	}

	#########################################################

	function StyleSheet(){
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		$prepend_path = PREPEND_PATH;

		$css_links = <<<EOT

			<link rel="stylesheet" href="{$prepend_path}resources/initializr/css/bootstrap.css">
			<link rel="stylesheet" href="{$prepend_path}resources/lightbox/css/lightbox.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/select2/select2.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/timepicker/bootstrap-timepicker.min.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}dynamic.css.php">
EOT;

		return $css_links;
	}

	#########################################################

	function getUploadDir($dir){
		global $Translation;

		if($dir==""){
			$dir=$Translation['ImageFolder'];
		}

		if(substr($dir, -1)!="/"){
			$dir.="/";
		}

		return $dir;
	}

	#########################################################

	function PrepareUploadedFile($FieldName, $MaxSize, $FileTypes = 'jpg|jpeg|gif|png', $NoRename = false, $dir = ''){
		global $Translation;
		$f = $_FILES[$FieldName];
		if($f['error'] == 4 || !$f['name']) return '';

		$dir = getUploadDir($dir);

		/* get php.ini upload_max_filesize in bytes */
		$php_upload_size_limit = trim(ini_get('upload_max_filesize'));
		$last = strtolower($php_upload_size_limit[strlen($php_upload_size_limit) - 1]);
		switch($last){
			case 'g':
				$php_upload_size_limit *= 1024;
			case 'm':
				$php_upload_size_limit *= 1024;
			case 'k':
				$php_upload_size_limit *= 1024;
		}

		$MaxSize = min($MaxSize, $php_upload_size_limit);

		if($f['size'] > $MaxSize || $f['error']){
			echo error_message(str_replace('<MaxSize>', intval($MaxSize / 1024), $Translation['file too large']));
			exit;
		}
		if(!preg_match('/\.(' . $FileTypes . ')$/i', $f['name'], $ft)){
			echo error_message(str_replace('<FileTypes>', str_replace('|', ', ', $FileTypes), $Translation['invalid file type']));
			exit;
		}

		$name = str_replace(' ', '_', $f['name']);
		if(!$NoRename) $name = substr(md5(microtime() . rand(0, 100000)), -17) . $ft[0];

		if(!file_exists($dir)) @mkdir($dir, 0777);

		if(!@move_uploaded_file($f['tmp_name'], $dir . $name)){
			echo error_message("Couldn't save the uploaded file. Try chmoding the upload folder '{$dir}' to 777.");
			exit;
		}

		@chmod($dir . $name, 0666);
		return $name;
	}

	#########################################################

	function get_home_links($homeLinks, $default_classes, $tgroup = ''){
		if(!is_array($homeLinks) || !count($homeLinks)) return '';

		$memberInfo = getMemberInfo();

		ob_start();
		foreach($homeLinks as $link){
			if(!isset($link['url']) || !isset($link['title'])) continue;
			if($tgroup != $link['table_group'] && $tgroup != '*') continue;

			/* fall-back classes if none defined */
			if(!$link['grid_column_classes']) $link['grid_column_classes'] = $default_classes['grid_column'];
			if(!$link['panel_classes']) $link['panel_classes'] = $default_classes['panel'];
			if(!$link['link_classes']) $link['link_classes'] = $default_classes['link'];

			if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
				?>
				<div class="col-xs-12 <?php echo $link['grid_column_classes']; ?>">
					<div class="panel <?php echo $link['panel_classes']; ?>">
						<div class="panel-body">
							<a class="btn btn-block btn-lg <?php echo $link['link_classes']; ?>" title="<?php echo preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", html_attr(strip_tags($link['description']))); ?>" href="<?php echo $link['url']; ?>"><?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?><strong><?php echo $link['title']; ?></strong></a>
							<div class="panel-body-description"><?php echo $link['description']; ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		}

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	#########################################################

	function quick_search_html($search_term, $label, $separate_dv = true){
		global $Translation;

		$safe_search = html_attr($search_term);
		$safe_label = html_attr($label);
		$safe_clear_label = html_attr($Translation['Reset Filters']);

		if($separate_dv){
			$reset_selection = "document.myform.SelectedID.value = '';";
		}else{
			$reset_selection = "document.myform.writeAttribute('novalidate', 'novalidate');";
		}
		$reset_selection .= ' document.myform.NoDV.value=1; return true;';

		$html = <<<EOT
		<div class="input-group" id="quick-search">
			<input type="text" id="SearchString" name="SearchString" value="{$safe_search}" class="form-control" placeholder="{$safe_label}">
			<span class="input-group-btn">
				<button name="Search_x" value="1" id="Search" type="submit" onClick="{$reset_selection}" class="btn btn-default" title="{$safe_label}"><i class="glyphicon glyphicon-search"></i></button>
				<button name="ClearQuickSearch" value="1" id="ClearQuickSearch" type="submit" onClick="\$j('#SearchString').val(''); {$reset_selection}" class="btn btn-default" title="{$safe_clear_label}"><i class="glyphicon glyphicon-remove-circle"></i></button>
			</span>
		</div>
EOT;
		return $html;
	}

	#########################################################

