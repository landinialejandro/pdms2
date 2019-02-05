<?php
	$currDir = dirname(__FILE__);
	require("{$currDir}/incCommon.php");
	$GLOBALS['page_title'] = $Translation['view or rebuild fields'];
	include("{$currDir}/incHeader.php");

	/*
		$schema: [ tablename => [ fieldname => [ appgini => '...', 'db' => '...'], ... ], ... ]
	*/

	/* application schema as created in AppGini */
	$schema = array(   
		'orders' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'progressiveNr' => array('appgini' => 'CHAR(40) null '),
			'trasmissionFor' => array('appgini' => 'CHAR(10) null default \'SDI10\' '),
			'consigneeID' => array('appgini' => 'CHAR(10) null '),
			'company' => array('appgini' => 'INT unsigned not null '),
			'typeDoc' => array('appgini' => 'VARCHAR(40) not null '),
			'multiOrder' => array('appgini' => 'INT not null '),
			'customer' => array('appgini' => 'INT unsigned null '),
			'supplier' => array('appgini' => 'INT unsigned null '),
			'employee' => array('appgini' => 'INT unsigned null '),
			'date' => array('appgini' => 'DATE null '),
			'requiredDate' => array('appgini' => 'DATE null '),
			'shippedDate' => array('appgini' => 'DATE null '),
			'shipVia' => array('appgini' => 'INT unsigned null '),
			'Freight' => array('appgini' => 'DECIMAL(10,2) null '),
			'pallets' => array('appgini' => 'INT null '),
			'licencePlate' => array('appgini' => 'VARCHAR(255) null '),
			'orderTotal' => array('appgini' => 'DECIMAL(10,2) null '),
			'cashCredit' => array('appgini' => 'VARCHAR(255) null default \'1\' '),
			'trust' => array('appgini' => 'INT unsigned null '),
			'overdraft' => array('appgini' => 'INT null '),
			'commisionFee' => array('appgini' => 'DECIMAL(10,2) null '),
			'commisionRate' => array('appgini' => 'DECIMAL(10,2) null '),
			'consigneeHour' => array('appgini' => 'DATETIME null '),
			'consigneePlace' => array('appgini' => 'VARCHAR(255) null '),
			'related' => array('appgini' => 'INT null '),
			'document' => array('appgini' => 'VARCHAR(255) null ')
		),
		'ordersDetails' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'order' => array('appgini' => 'INT unsigned null '),
			'manufactureDate' => array('appgini' => 'DATE null '),
			'sellDate' => array('appgini' => 'DATE null '),
			'expiryDate' => array('appgini' => 'DATE null '),
			'daysToExpiry' => array('appgini' => 'INT null '),
			'codebar' => array('appgini' => 'INT null '),
			'UM' => array('appgini' => 'INT null '),
			'productCode' => array('appgini' => 'INT null '),
			'batch' => array('appgini' => 'INT null '),
			'packages' => array('appgini' => 'DECIMAL(10,2) null '),
			'noSell' => array('appgini' => 'INT null '),
			'Quantity' => array('appgini' => 'DECIMAL(10,2) null default \'1\' '),
			'QuantityReal' => array('appgini' => 'DECIMAL(10,2) null '),
			'UnitPrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'Subtotal' => array('appgini' => 'DECIMAL(10,2) unsigned null '),
			'taxes' => array('appgini' => 'DECIMAL(10,2) null '),
			'Discount' => array('appgini' => 'DECIMAL(10,2) null '),
			'LineTotal' => array('appgini' => 'DECIMAL(10,2) null '),
			'section' => array('appgini' => 'VARCHAR(40) null default \'Magazzino Metaponto\' '),
			'transaction_type' => array('appgini' => 'INT unsigned null '),
			'skBatches' => array('appgini' => 'INT unsigned null '),
			'averagePrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'averageWeight' => array('appgini' => 'DECIMAL(10,2) null '),
			'commission' => array('appgini' => 'DECIMAL(10,2) null default \'15.00\' '),
			'return' => array('appgini' => 'VARCHAR(255) null default \'1\' '),
			'supplierCode' => array('appgini' => 'VARCHAR(100) null ')
		),
		'_resumeOrders' => array(   
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'typedoc' => array('appgini' => 'VARCHAR(40) null '),
			'customer' => array('appgini' => 'INT unsigned null '),
			'TOT' => array('appgini' => 'VARCHAR(40) null '),
			'MONTH' => array('appgini' => 'VARCHAR(40) null '),
			'YEAR' => array('appgini' => 'VARCHAR(40) null '),
			'DOCs' => array('appgini' => 'VARCHAR(40) null '),
			'related' => array('appgini' => 'INT unsigned null '),
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment ')
		),
		'products' => array(   
			'id' => array('appgini' => 'INT not null primary key auto_increment '),
			'codebar' => array('appgini' => 'VARCHAR(16) null '),
			'productCode' => array('appgini' => 'VARCHAR(255) null '),
			'productName' => array('appgini' => 'VARCHAR(255) null '),
			'tax' => array('appgini' => 'VARCHAR(40) null '),
			'increment' => array('appgini' => 'DECIMAL(10,2) null '),
			'CategoryID' => array('appgini' => 'VARCHAR(40) null '),
			'UM' => array('appgini' => 'VARCHAR(40) null '),
			'tare' => array('appgini' => 'DECIMAL(10,2) null '),
			'QuantityPerUnit' => array('appgini' => 'VARCHAR(50) null '),
			'UnitPrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'sellPrice' => array('appgini' => 'DECIMAL(10,2) null '),
			'UnitsInStock' => array('appgini' => 'DECIMAL(10,2) null '),
			'UnitsOnOrder' => array('appgini' => 'DECIMAL(10,2) null default \'0\' '),
			'ReorderLevel' => array('appgini' => 'DECIMAL(10,2) null default \'0\' '),
			'balance' => array('appgini' => 'DECIMAL(10,2) null '),
			'Discontinued' => array('appgini' => 'INT null default \'0\' '),
			'manufactured_date' => array('appgini' => 'DATE null '),
			'expiry_date' => array('appgini' => 'DATE null '),
			'note' => array('appgini' => 'TEXT null '),
			'update_date' => array('appgini' => 'DATETIME null ')
		),
		'firstCashNote' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'order' => array('appgini' => 'INT unsigned null '),
			'operationDate' => array('appgini' => 'DATE null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'customer' => array('appgini' => 'INT unsigned null '),
			'documentNumber' => array('appgini' => 'INT null '),
			'causal' => array('appgini' => 'VARCHAR(255) null '),
			'revenue' => array('appgini' => 'DECIMAL(10,2) null '),
			'outputs' => array('appgini' => 'DECIMAL(10,2) null '),
			'balance' => array('appgini' => 'DECIMAL(10,2) null '),
			'idBank' => array('appgini' => 'INT unsigned null '),
			'bank' => array('appgini' => 'INT unsigned null '),
			'note' => array('appgini' => 'VARCHAR(255) null '),
			'paymentDeadLine' => array('appgini' => 'DATE null '),
			'payed' => array('appgini' => 'VARCHAR(255) null default \'0\' ')
		),
		'vatRegister' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'idCompany' => array('appgini' => 'INT unsigned null '),
			'companyName' => array('appgini' => 'INT unsigned null '),
			'tax' => array('appgini' => 'VARCHAR(40) null default \'4%\' '),
			'month' => array('appgini' => 'VARCHAR(40) null '),
			'year' => array('appgini' => 'VARCHAR(40) null default \'2018\' '),
			'amount' => array('appgini' => 'DECIMAL(10,2) null ')
		),
		'companies' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'companyCode' => array('appgini' => 'VARCHAR(255) null unique '),
			'companyName' => array('appgini' => 'VARCHAR(255) null '),
			'personaFisica' => array('appgini' => 'VARCHAR(40) not null default \'No\' '),
			'fiscalCode' => array('appgini' => 'VARCHAR(255) null '),
			'vat' => array('appgini' => 'VARCHAR(255) not null '),
			'notes' => array('appgini' => 'TEXT null '),
			'codiceDestinatario' => array('appgini' => 'VARCHAR(7) null '),
			'regimeFiscale' => array('appgini' => 'VARCHAR(40) null '),
			'tipoCassa' => array('appgini' => 'VARCHAR(40) null '),
			'modalitaPagamento' => array('appgini' => 'VARCHAR(40) null '),
			'RiferimentoAmministrazione' => array('appgini' => 'VARCHAR(40) null '),
			'FormatoTrasmissione' => array('appgini' => 'VARCHAR(40) not null default \'FPR12\' '),
			'REA_Ufficio' => array('appgini' => 'VARCHAR(2) null '),
			'REA_NumeroREA' => array('appgini' => 'VARCHAR(20) null '),
			'REA_CapitaleSociale' => array('appgini' => 'VARCHAR(40) null '),
			'REA_SocioUnico' => array('appgini' => 'VARCHAR(2) not null default \'SU\' '),
			'REA_StatoLiquidazione' => array('appgini' => 'VARCHAR(2) not null default \'LN\' '),
			'RIT_soggettoRitenuta' => array('appgini' => 'VARCHAR(40) null default \'0\' '),
			'RIT_tipoRitenuta' => array('appgini' => 'VARCHAR(40) not null default \'RT02\' '),
			'RIT_AliquotaRitenuta' => array('appgini' => 'DECIMAL(10,2) null '),
			'RIT_CausalePagamento' => array('appgini' => 'VARCHAR(40) null ')
		),
		'contacts' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'titleCourtesy' => array('appgini' => 'VARCHAR(40) null '),
			'name' => array('appgini' => 'VARCHAR(255) null '),
			'lastName' => array('appgini' => 'VARCHAR(255) null '),
			'notes' => array('appgini' => 'TEXT null '),
			'title' => array('appgini' => 'VARCHAR(255) null '),
			'birthDate' => array('appgini' => 'DATE null '),
			'CodEORI' => array('appgini' => 'VARCHAR(40) null ')
		),
		'creditDocument' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'incomingTypeDoc' => array('appgini' => 'VARCHAR(255) null '),
			'customerID' => array('appgini' => 'VARCHAR(255) null '),
			'nrDoc' => array('appgini' => 'VARCHAR(255) null '),
			'dateIncomingNote' => array('appgini' => 'DATE null '),
			'customerFirm' => array('appgini' => 'VARCHAR(255) null '),
			'customerAddress' => array('appgini' => 'VARCHAR(255) null '),
			'customerPostCode' => array('appgini' => 'VARCHAR(255) null '),
			'customerTown' => array('appgini' => 'VARCHAR(255) null ')
		),
		'electronicInvoice' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'topic' => array('appgini' => 'VARCHAR(255) null '),
			'currency' => array('appgini' => 'VARCHAR(255) null default \'IT\' '),
			'trasmissionFormat' => array('appgini' => 'VARCHAR(255) null '),
			'country' => array('appgini' => 'VARCHAR(255) null default \'IT\' ')
		),
		'countries' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'country' => array('appgini' => 'VARCHAR(255) null '),
			'code' => array('appgini' => 'VARCHAR(100) null '),
			'ISOcode' => array('appgini' => 'VARCHAR(40) null ')
		),
		'town' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'country' => array('appgini' => 'INT unsigned null '),
			'idIstat' => array('appgini' => 'VARCHAR(255) null '),
			'town' => array('appgini' => 'VARCHAR(255) null '),
			'district' => array('appgini' => 'VARCHAR(255) null '),
			'region' => array('appgini' => 'VARCHAR(255) null '),
			'prefix' => array('appgini' => 'VARCHAR(255) null '),
			'shipCode' => array('appgini' => 'VARCHAR(255) null '),
			'fiscCode' => array('appgini' => 'VARCHAR(255) null '),
			'inhabitants' => array('appgini' => 'VARCHAR(255) null '),
			'link' => array('appgini' => 'VARCHAR(255) null ')
		),
		'GPSTrackingSystem' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'carTracked' => array('appgini' => 'VARCHAR(40) null ')
		),
		'kinds' => array(   
			'entity' => array('appgini' => 'BLOB not null '),
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'name' => array('appgini' => 'VARCHAR(255) not null '),
			'value' => array('appgini' => 'TEXT null '),
			'descriptions' => array('appgini' => 'TEXT null ')
		),
		'Logs' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'ip' => array('appgini' => 'VARCHAR(16) null '),
			'ts' => array('appgini' => 'BIGINT null '),
			'details' => array('appgini' => 'TEXT null ')
		),
		'attributes' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'attribute' => array('appgini' => 'VARCHAR(40) null '),
			'value' => array('appgini' => 'TEXT null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'product' => array('appgini' => 'INT null ')
		),
		'addresses' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'address' => array('appgini' => 'VARCHAR(255) not null '),
			'houseNumber' => array('appgini' => 'VARCHAR(255) not null '),
			'country' => array('appgini' => 'INT unsigned not null '),
			'country_name' => array('appgini' => 'INT unsigned null '),
			'town' => array('appgini' => 'INT unsigned not null '),
			'postalCode' => array('appgini' => 'INT unsigned not null '),
			'district' => array('appgini' => 'INT unsigned not null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'map' => array('appgini' => 'VARCHAR(40) null '),
			'default' => array('appgini' => 'INT null default \'0\' '),
			'ship' => array('appgini' => 'INT null default \'0\' ')
		),
		'phones' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'phoneNumber' => array('appgini' => 'VARCHAR(255) null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null ')
		),
		'mails' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) null '),
			'mail' => array('appgini' => 'VARCHAR(255) null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null ')
		),
		'contacts_companies' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'default' => array('appgini' => 'VARCHAR(40) null default \'0\' ')
		),
		'attachments' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'name' => array('appgini' => 'VARCHAR(255) null '),
			'file' => array('appgini' => 'VARCHAR(255) null '),
			'contact' => array('appgini' => 'INT unsigned null '),
			'company' => array('appgini' => 'INT unsigned null '),
			'thumbUse' => array('appgini' => 'INT null default \'0\' ')
		),
		'codiceDestinatario' => array(   
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'text' => array('appgini' => 'TEXT null ')
		),
		'regimeFiscale' => array(   
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'text' => array('appgini' => 'TEXT null ')
		),
		'tipoCassa' => array(   
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'text' => array('appgini' => 'TEXT null ')
		),
		'modalitaPagamento' => array(   
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'text' => array('appgini' => 'TEXT null ')
		)
	);

	$table_captions = getTableList();

	/* function for preparing field definition for comparison */
	function prepare_def($def) {
		$def = strtolower($def);

		/* ignore 'null' */
		$def = preg_replace('/\s+not\s+null\s*/', '%%NOT_NULL%%', $def);
		$def = preg_replace('/\s+null\s*/', ' ', $def);
		$def = str_replace('%%NOT_NULL%%', ' not null ', $def);

		/* ignore length for int data types */
		$def = preg_replace('/int\s*\([0-9]+\)/', 'int', $def);

		/* make sure there is always a space before mysql words */
		$def = preg_replace('/(\S)(unsigned|not null|binary|zerofill|auto_increment|default)/', '$1 $2', $def);

		/* treat 0.000.. same as 0 */
		$def = preg_replace('/([0-9])*\.0+/', '$1', $def);

		/* treat unsigned zerofill same as zerofill */
		$def = str_ireplace('unsigned zerofill', 'zerofill', $def);

		/* ignore zero-padding for date data types */
		$def = preg_replace("/date\s*default\s*'([0-9]{4})-0?([1-9])-0?([1-9])'/", "date default '$1-$2-$3'", $def);

		return trim($def);
	}

	/**
	 *  @brief creates/fixes given field according to given schema
	 *  @return integer: 0 = error, 1 = field updated, 2 = field created
	 */
	function fix_field($fix_table, $fix_field, $schema, &$qry) {
		if(!isset($schema[$fix_table][$fix_field])) return 0;

		$def = $schema[$fix_table][$fix_field];
		$field_added = $field_updated = false;
		$eo['silentErrors'] = true;

		// field exists?
		$res = sql("show columns from `{$fix_table}` like '{$fix_field}'", $eo);
		if($row = db_fetch_assoc($res)){
			// modify field
			$qry = "alter table `{$fix_table}` modify `{$fix_field}` {$def['appgini']}";
			sql($qry, $eo);

			// remove unique from db if necessary
			if($row['Key'] == 'UNI' && !stripos($def['appgini'], ' unique')){
				// retrieve unique index name
				$res_unique = sql("show index from `{$fix_table}` where Column_name='{$fix_field}' and Non_unique=0", $eo);
				if($row_unique = db_fetch_assoc($res_unique)){
					$qry_unique = "drop index `{$row_unique['Key_name']}` on `{$fix_table}`";
					sql($qry_unique, $eo);
					$qry .= ";\n{$qry_unique}";
				}
			}

			return 1;
		}

		// create field
		$qry = "alter table `{$fix_table}` add column `{$fix_field}` {$schema[$fix_table][$fix_field]['appgini']}";
		sql($qry, $eo);
		return 2;
	}

	/* process requested fixes */
	$fix_table = (isset($_GET['t']) ? $_GET['t'] : false);
	$fix_field = (isset($_GET['f']) ? $_GET['f'] : false);
	$fix_all = (isset($_GET['all']) ? true : false);

	if($fix_field && $fix_table) $fix_status = fix_field($fix_table, $fix_field, $schema, $qry);

	/* retrieve actual db schema */
	foreach($table_captions as $tn => $tc){
		$eo['silentErrors'] = true;
		$res = sql("show columns from `{$tn}`", $eo);
		if($res){
			while($row = db_fetch_assoc($res)){
				if(!isset($schema[$tn][$row['Field']]['appgini'])) continue;
				$field_description = strtoupper(str_replace(' ', '', $row['Type']));
				$field_description = str_ireplace('unsigned', ' unsigned', $field_description);
				$field_description = str_ireplace('zerofill', ' zerofill', $field_description);
				$field_description = str_ireplace('binary', ' binary', $field_description);
				$field_description .= ($row['Null'] == 'NO' ? ' not null' : '');
				$field_description .= ($row['Key'] == 'PRI' ? ' primary key' : '');
				$field_description .= ($row['Key'] == 'UNI' ? ' unique' : '');
				$field_description .= ($row['Default'] != '' ? " default '" . makeSafe($row['Default']) . "'" : '');
				$field_description .= ($row['Extra'] == 'auto_increment' ? ' auto_increment' : '');

				$schema[$tn][$row['Field']]['db'] = '';
				if(isset($schema[$tn][$row['Field']])){
					$schema[$tn][$row['Field']]['db'] = $field_description;
				}
			}
		}
	}

	/* handle fix_all request */
	if($fix_all){
		foreach($schema as $tn => $fields){
			foreach($fields as $fn => $fd){
				if(prepare_def($fd['appgini']) == prepare_def($fd['db'])) continue;
				fix_field($tn, $fn, $schema, $qry);
			}
		}

		redirect('admin/pageRebuildFields.php');
		exit;
	}
?>

<?php if($fix_status == 1 || $fix_status == 2){ ?>
	<div class="alert alert-info alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="glyphicon glyphicon-info-sign"></i>
		<?php 
			$originalValues = array('<ACTION>', '<FIELD>', '<TABLE>', '<QUERY>');
			$action = ($fix_status == 2 ? 'create' : 'update');
			$replaceValues = array($action, $fix_field, $fix_table, $qry);
			echo str_replace($originalValues, $replaceValues, $Translation['create or update table']);
		?>
	</div>
<?php } ?>

<div class="page-header"><h1>
	<?php echo $Translation['view or rebuild fields'] ; ?>
	<button type="button" class="btn btn-default" id="show_deviations_only"><i class="glyphicon glyphicon-eye-close"></i> <?php echo $Translation['show deviations only'] ; ?></button>
	<button type="button" class="btn btn-default hidden" id="show_all_fields"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $Translation['show all fields'] ; ?></button>
</h1></div>

<p class="lead"><?php echo $Translation['compare tables page'] ; ?></p>

<div class="alert summary"></div>
<table class="table table-responsive table-hover table-striped">
	<thead><tr>
		<th></th>
		<th><?php echo $Translation['field'] ; ?></th>
		<th><?php echo $Translation['AppGini definition'] ; ?></th>
		<th><?php echo $Translation['database definition'] ; ?></th>
		<th id="fix_all"></th>
	</tr></thead>

	<tbody>
	<?php foreach($schema as $tn => $fields){ ?>
		<tr class="text-info"><td colspan="5"><h4 data-placement="left" data-toggle="tooltip" title="<?php echo str_replace ( "<TABLENAME>" , $tn , $Translation['table name title']) ; ?>"><i class="glyphicon glyphicon-th-list"></i> <?php echo $table_captions[$tn]; ?></h4></td></tr>
		<?php foreach($fields as $fn => $fd){ ?>
			<?php $diff = ((prepare_def($fd['appgini']) == prepare_def($fd['db'])) ? false : true); ?>
			<?php $no_db = ($fd['db'] ? false : true); ?>
			<tr class="<?php echo ($diff ? 'warning' : 'field_ok'); ?>">
				<td><i class="glyphicon glyphicon-<?php echo ($diff ? 'remove text-danger' : 'ok text-success'); ?>"></i></td>
				<td><?php echo $fn; ?></td>
				<td class="<?php echo ($diff ? 'bold text-success' : ''); ?>"><?php echo $fd['appgini']; ?></td>
				<td class="<?php echo ($diff ? 'bold text-danger' : ''); ?>"><?php echo thisOr($fd['db'], $Translation['does not exist']); ?></td>
				<td>
					<?php if($diff && $no_db){ ?>
						<a href="pageRebuildFields.php?t=<?php echo $tn; ?>&f=<?php echo $fn; ?>" class="btn btn-success btn-xs btn_create" data-toggle="tooltip" data-placement="top" title="<?php echo $Translation['create field'] ; ?>"><i class="glyphicon glyphicon-plus"></i> <?php echo $Translation['create it'] ; ?></a>
					<?php }elseif($diff){ ?>
						<a href="pageRebuildFields.php?t=<?php echo $tn; ?>&f=<?php echo $fn; ?>" class="btn btn-warning btn-xs btn_update" data-toggle="tooltip" title="<?php echo $Translation['fix field'] ; ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['fix it'] ; ?></a>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	<?php } ?>
	</tbody>
</table>
<div class="alert summary"></div>

<style>
	.bold{ font-weight: bold; }
	[data-toggle="tooltip"]{ display: block !important; }
</style>

<script>
	$j(function(){
		$j('[data-toggle="tooltip"]').tooltip();

		$j('#show_deviations_only').click(function(){
			$j(this).addClass('hidden');
			$j('#show_all_fields').removeClass('hidden');
			$j('.field_ok').hide();
		});

		$j('#show_all_fields').click(function(){
			$j(this).addClass('hidden');
			$j('#show_deviations_only').removeClass('hidden');
			$j('.field_ok').show();
		});

		$j('.btn_update, #fix_all').click(function(){
			return confirm("<?php echo $Translation['field update warning'] ; ?>");
		});

		var count_updates = $j('.btn_update').length;
		var count_creates = $j('.btn_create').length;
		if(!count_creates && !count_updates){
			$j('.summary').addClass('alert-success').html("<?php echo $Translation['no deviations found'] ; ?>");
		}else{
			var fieldsCount = "<?php echo $Translation['error fields']; ?>";
			fieldsCount = fieldsCount.replace(/<CREATENUM>/, count_creates ).replace(/<UPDATENUM>/, count_updates);


			$j('.summary')
				.addClass('alert-warning')
				.html(
					fieldsCount + 
					'<br><br>' + 
					'<a href="pageBackupRestore.php" class="alert-link">' +
						'<b><?php echo addslashes($Translation['backup before fix']); ?></b>' +
					'</a>'
				);

			$j('<a href="pageRebuildFields.php?all=1" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-cog"></i> <?php echo addslashes($Translation['fix all']); ?></a>').appendTo('#fix_all');
		}
	});
</script>

<?php
	include("{$currDir}/incFooter.php");
?>
