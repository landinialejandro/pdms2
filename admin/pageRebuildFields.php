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
			'progressiveNr' => array('appgini' => 'CHAR(40) '),
			'trasmissionFor' => array('appgini' => 'CHAR(10) default \'SDI10\' '),
			'consigneeID' => array('appgini' => 'CHAR(10) '),
			'company' => array('appgini' => 'INT unsigned not null '),
			'typeDoc' => array('appgini' => 'VARCHAR(40) not null '),
			'multiOrder' => array('appgini' => 'INT not null '),
			'customer' => array('appgini' => 'INT unsigned '),
			'supplier' => array('appgini' => 'INT unsigned '),
			'employee' => array('appgini' => 'INT unsigned '),
			'date' => array('appgini' => 'DATE '),
			'requiredDate' => array('appgini' => 'DATE '),
			'shippedDate' => array('appgini' => 'DATE '),
			'shipVia' => array('appgini' => 'INT unsigned '),
			'Freight' => array('appgini' => 'DECIMAL(10,2) '),
			'pallets' => array('appgini' => 'INT '),
			'licencePlate' => array('appgini' => 'VARCHAR(255) '),
			'orderTotal' => array('appgini' => 'DECIMAL(10,2) '),
			'cashCredit' => array('appgini' => 'VARCHAR(255) default \'1\' '),
			'trust' => array('appgini' => 'INT unsigned '),
			'overdraft' => array('appgini' => 'INT '),
			'commisionFee' => array('appgini' => 'DECIMAL(10,2) '),
			'commisionRate' => array('appgini' => 'DECIMAL(10,2) '),
			'consigneeHour' => array('appgini' => 'DATETIME '),
			'consigneePlace' => array('appgini' => 'VARCHAR(255) '),
			'related' => array('appgini' => 'INT '),
			'document' => array('appgini' => 'VARCHAR(255) ')
		),
		'ordersDetails' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'order' => array('appgini' => 'INT unsigned '),
			'manufactureDate' => array('appgini' => 'DATE '),
			'sellDate' => array('appgini' => 'DATE '),
			'expiryDate' => array('appgini' => 'DATE '),
			'daysToExpiry' => array('appgini' => 'INT '),
			'codebar' => array('appgini' => 'INT '),
			'UM' => array('appgini' => 'INT '),
			'productCode' => array('appgini' => 'INT '),
			'batch' => array('appgini' => 'INT '),
			'packages' => array('appgini' => 'DECIMAL(10,2) '),
			'noSell' => array('appgini' => 'INT '),
			'Quantity' => array('appgini' => 'DECIMAL(10,2) default \'1\' '),
			'QuantityReal' => array('appgini' => 'DECIMAL(10,2) '),
			'UnitPrice' => array('appgini' => 'DECIMAL(10,2) '),
			'Subtotal' => array('appgini' => 'DECIMAL(10,2) unsigned '),
			'taxes' => array('appgini' => 'DECIMAL(10,2) '),
			'Discount' => array('appgini' => 'DECIMAL(10,2) '),
			'LineTotal' => array('appgini' => 'DECIMAL(10,2) '),
			'section' => array('appgini' => 'VARCHAR(40) default \'Magazzino Metaponto\' '),
			'transaction_type' => array('appgini' => 'INT unsigned '),
			'skBatches' => array('appgini' => 'INT unsigned '),
			'averagePrice' => array('appgini' => 'DECIMAL(10,2) '),
			'averageWeight' => array('appgini' => 'DECIMAL(10,2) '),
			'commission' => array('appgini' => 'DECIMAL(10,2) default \'15.00\' '),
			'return' => array('appgini' => 'VARCHAR(255) default \'1\' '),
			'supplierCode' => array('appgini' => 'VARCHAR(100) ')
		),
		'_resumeOrders' => array(   
			'kind' => array('appgini' => 'VARCHAR(40) '),
			'company' => array('appgini' => 'INT unsigned '),
			'typedoc' => array('appgini' => 'VARCHAR(40) '),
			'customer' => array('appgini' => 'INT unsigned '),
			'TOT' => array('appgini' => 'VARCHAR(40) '),
			'MONTH' => array('appgini' => 'VARCHAR(40) '),
			'YEAR' => array('appgini' => 'VARCHAR(40) '),
			'DOCs' => array('appgini' => 'VARCHAR(40) '),
			'related' => array('appgini' => 'INT unsigned '),
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment ')
		),
		'products' => array(   
			'id' => array('appgini' => 'INT not null primary key auto_increment '),
			'codebar' => array('appgini' => 'VARCHAR(16) '),
			'productCode' => array('appgini' => 'VARCHAR(255) '),
			'productName' => array('appgini' => 'VARCHAR(255) '),
			'tax' => array('appgini' => 'VARCHAR(40) '),
			'increment' => array('appgini' => 'DECIMAL(10,2) '),
			'CategoryID' => array('appgini' => 'VARCHAR(40) '),
			'UM' => array('appgini' => 'VARCHAR(40) '),
			'tare' => array('appgini' => 'DECIMAL(10,2) '),
			'QuantityPerUnit' => array('appgini' => 'VARCHAR(50) '),
			'UnitPrice' => array('appgini' => 'DECIMAL(10,2) '),
			'sellPrice' => array('appgini' => 'DECIMAL(10,2) '),
			'UnitsInStock' => array('appgini' => 'DECIMAL(10,2) '),
			'UnitsOnOrder' => array('appgini' => 'DECIMAL(10,2) default \'0\' '),
			'ReorderLevel' => array('appgini' => 'DECIMAL(10,2) default \'0\' '),
			'balance' => array('appgini' => 'DECIMAL(10,2) '),
			'Discontinued' => array('appgini' => 'INT default \'0\' '),
			'manufactured_date' => array('appgini' => 'DATE '),
			'expiry_date' => array('appgini' => 'DATE '),
			'note' => array('appgini' => 'TEXT '),
			'update_date' => array('appgini' => 'DATETIME ')
		),
		'firstCashNote' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'order' => array('appgini' => 'INT unsigned '),
			'operationDate' => array('appgini' => 'DATE '),
			'company' => array('appgini' => 'INT unsigned '),
			'customer' => array('appgini' => 'INT unsigned '),
			'documentNumber' => array('appgini' => 'INT '),
			'causal' => array('appgini' => 'VARCHAR(255) '),
			'revenue' => array('appgini' => 'DECIMAL(10,2) '),
			'outputs' => array('appgini' => 'DECIMAL(10,2) '),
			'balance' => array('appgini' => 'DECIMAL(10,2) '),
			'idBank' => array('appgini' => 'INT unsigned '),
			'bank' => array('appgini' => 'INT unsigned '),
			'note' => array('appgini' => 'VARCHAR(255) '),
			'paymentDeadLine' => array('appgini' => 'DATE '),
			'payed' => array('appgini' => 'VARCHAR(255) default \'0\' ')
		),
		'vatRegister' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'idCompany' => array('appgini' => 'INT unsigned '),
			'companyName' => array('appgini' => 'INT unsigned '),
			'tax' => array('appgini' => 'VARCHAR(40) default \'4%\' '),
			'month' => array('appgini' => 'VARCHAR(40) '),
			'year' => array('appgini' => 'VARCHAR(40) default \'2018\' '),
			'amount' => array('appgini' => 'DECIMAL(10,2) ')
		),
		'companies' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) not null '),
			'companyCode' => array('appgini' => 'VARCHAR(255) '),
			'companyName' => array('appgini' => 'VARCHAR(255) '),
			'fiscalCode' => array('appgini' => 'VARCHAR(255) '),
			'vat' => array('appgini' => 'VARCHAR(255) not null '),
			'notes' => array('appgini' => 'TEXT '),
			'codiceDestinatario' => array('appgini' => 'INT unsigned ')
		),
		'contacts' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) '),
			'titleCourtesy' => array('appgini' => 'VARCHAR(40) '),
			'name' => array('appgini' => 'VARCHAR(255) '),
			'lastName' => array('appgini' => 'VARCHAR(255) '),
			'notes' => array('appgini' => 'TEXT '),
			'title' => array('appgini' => 'VARCHAR(255) '),
			'birthDate' => array('appgini' => 'DATE '),
			'CodEORI' => array('appgini' => 'VARCHAR(40) ')
		),
		'creditDocument' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'incomingTypeDoc' => array('appgini' => 'VARCHAR(255) '),
			'customerID' => array('appgini' => 'VARCHAR(255) '),
			'nrDoc' => array('appgini' => 'VARCHAR(255) '),
			'dateIncomingNote' => array('appgini' => 'DATE '),
			'customerFirm' => array('appgini' => 'VARCHAR(255) '),
			'customerAddress' => array('appgini' => 'VARCHAR(255) '),
			'customerPostCode' => array('appgini' => 'VARCHAR(255) '),
			'customerTown' => array('appgini' => 'VARCHAR(255) ')
		),
		'electronicInvoice' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'topic' => array('appgini' => 'VARCHAR(255) '),
			'currency' => array('appgini' => 'VARCHAR(255) default \'IT\' '),
			'trasmissionFormat' => array('appgini' => 'VARCHAR(255) '),
			'country' => array('appgini' => 'VARCHAR(255) default \'IT\' ')
		),
		'countries' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'country' => array('appgini' => 'VARCHAR(255) '),
			'code' => array('appgini' => 'VARCHAR(100) '),
			'ISOcode' => array('appgini' => 'VARCHAR(40) ')
		),
		'town' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'country' => array('appgini' => 'INT unsigned '),
			'idIstat' => array('appgini' => 'VARCHAR(255) '),
			'town' => array('appgini' => 'VARCHAR(255) '),
			'district' => array('appgini' => 'VARCHAR(255) '),
			'region' => array('appgini' => 'VARCHAR(255) '),
			'prefix' => array('appgini' => 'VARCHAR(255) '),
			'shipCode' => array('appgini' => 'VARCHAR(255) '),
			'fiscCode' => array('appgini' => 'VARCHAR(255) '),
			'inhabitants' => array('appgini' => 'VARCHAR(255) '),
			'link' => array('appgini' => 'VARCHAR(255) ')
		),
		'GPSTrackingSystem' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'carTracked' => array('appgini' => 'VARCHAR(40) ')
		),
		'kinds' => array(   
			'entity' => array('appgini' => 'BLOB not null '),
			'code' => array('appgini' => 'VARCHAR(40) not null primary key '),
			'name' => array('appgini' => 'VARCHAR(255) not null '),
			'value' => array('appgini' => 'TEXT '),
			'descriptions' => array('appgini' => 'TEXT ')
		),
		'Logs' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'ip' => array('appgini' => 'VARCHAR(16) '),
			'ts' => array('appgini' => 'BIGINT '),
			'details' => array('appgini' => 'TEXT ')
		),
		'attributes' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'attribute' => array('appgini' => 'VARCHAR(40) '),
			'value' => array('appgini' => 'TEXT '),
			'contact' => array('appgini' => 'INT unsigned '),
			'companies' => array('appgini' => 'INT unsigned '),
			'products' => array('appgini' => 'INT ')
		),
		'addresses' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) '),
			'address' => array('appgini' => 'VARCHAR(255) '),
			'houseNumber' => array('appgini' => 'VARCHAR(255) '),
			'country' => array('appgini' => 'INT unsigned '),
			'town' => array('appgini' => 'INT unsigned '),
			'postalCode' => array('appgini' => 'INT unsigned '),
			'district' => array('appgini' => 'INT unsigned '),
			'contact' => array('appgini' => 'INT unsigned '),
			'company' => array('appgini' => 'INT unsigned '),
			'map' => array('appgini' => 'VARCHAR(40) '),
			'default' => array('appgini' => 'INT default \'0\' '),
			'ship' => array('appgini' => 'INT default \'0\' ')
		),
		'phones' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) '),
			'phoneNumber' => array('appgini' => 'VARCHAR(255) '),
			'contact' => array('appgini' => 'INT unsigned '),
			'company' => array('appgini' => 'INT unsigned ')
		),
		'mails' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'kind' => array('appgini' => 'VARCHAR(40) '),
			'mail' => array('appgini' => 'VARCHAR(255) '),
			'contact' => array('appgini' => 'INT unsigned '),
			'company' => array('appgini' => 'INT unsigned ')
		),
		'contacts_companies' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'contact' => array('appgini' => 'INT unsigned '),
			'company' => array('appgini' => 'INT unsigned '),
			'default' => array('appgini' => 'VARCHAR(40) default \'0\' ')
		),
		'attachments' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'name' => array('appgini' => 'VARCHAR(255) '),
			'file' => array('appgini' => 'VARCHAR(255) '),
			'contact' => array('appgini' => 'INT unsigned '),
			'company' => array('appgini' => 'INT unsigned '),
			'thumbUse' => array('appgini' => 'INT default \'0\' ')
		),
		'codiceDestinatario' => array(   
			'id' => array('appgini' => 'INT unsigned not null primary key auto_increment '),
			'code' => array('appgini' => 'VARCHAR(40) '),
			'list' => array('appgini' => 'VARCHAR(40) ')
		)
	);

	$table_captions = getTableList();

	/* function for preparing field definition for comparison */
	function prepare_def($def){
		$def = trim($def);
		$def = strtolower($def);

		/* ignore length for int data types */
		$def = preg_replace('/int\w*\([0-9]+\)/', 'int', $def);

		/* make sure there is always a space before mysql words */
		$def = preg_replace('/(\S)(unsigned|not null|binary|zerofill|auto_increment|default)/', '$1 $2', $def);

		/* treat 0.000.. same as 0 */
		$def = preg_replace('/([0-9])*\.0+/', '$1', $def);

		/* treat unsigned zerofill same as zerofill */
		$def = str_ireplace('unsigned zerofill', 'zerofill', $def);

		/* ignore zero-padding for date data types */
		$def = preg_replace("/date\s*default\s*'([0-9]{4})-0?([1-9])-0?([1-9])'/i", "date default '$1-$2-$3'", $def);

		return $def;
	}

	/**
	 *  @brief creates/fixes given field according to given schema
	 *  @return integer: 0 = error, 1 = field updated, 2 = field created
	 */
	function fix_field($fix_table, $fix_field, $schema, &$qry){
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
