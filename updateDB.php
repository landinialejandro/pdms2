<?php
	// check this file's MD5 to make sure it wasn't called before
	$prevMD5=@implode('', @file(dirname(__FILE__).'/setup.md5'));
	$thisMD5=md5(@implode('', @file("./updateDB.php")));
	if($thisMD5==$prevMD5){
		$setupAlreadyRun=true;
	}else{
		// set up tables
		if(!isset($silent)){
			$silent=true;
		}

		// set up tables
		setupTable('orders', "create table if not exists `orders` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `progressiveNr` CHAR(40) null , `trasmissionFor` CHAR(10) null default 'SDI10' , `consigneeID` CHAR(10) null , `company` INT unsigned not null , `typeDoc` VARCHAR(40) not null , `multiOrder` INT not null , `customer` INT unsigned null , `supplier` INT unsigned null , `employee` INT unsigned null , `date` DATE null , `requiredDate` DATE null , `shippedDate` DATE null , `shipVia` INT unsigned null , `Freight` DECIMAL(10,2) null , `pallets` INT null , `licencePlate` VARCHAR(255) null , `orderTotal` DECIMAL(10,2) null , `cashCredit` VARCHAR(255) null default '1' , `trust` INT unsigned null , `overdraft` INT null , `commisionFee` DECIMAL(10,2) null , `commisionRate` DECIMAL(10,2) null , `consigneeHour` DATETIME null , `consigneePlace` VARCHAR(255) null , `related` INT null , `document` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupIndexes('orders', array('kind','company','typeDoc','customer','supplier','employee','shipVia'));
		setupTable('ordersDetails', "create table if not exists `ordersDetails` (   `id` INT unsigned not null auto_increment , primary key (`id`), `order` INT unsigned null , `manufactureDate` DATE null , `sellDate` DATE null , `expiryDate` DATE null , `daysToExpiry` INT null , `codebar` INT null , `UM` INT null , `productCode` INT null , `batch` INT null , `packages` DECIMAL(10,2) null , `noSell` INT null , `Quantity` DECIMAL(10,2) null default '1' , `QuantityReal` DECIMAL(10,2) null , `UnitPrice` DECIMAL(10,2) null , `Subtotal` DECIMAL(10,2) unsigned null , `taxes` DECIMAL(10,2) null , `Discount` DECIMAL(10,2) null , `LineTotal` DECIMAL(10,2) null , `section` VARCHAR(40) null default 'Magazzino Metaponto' , `transaction_type` INT unsigned null , `skBatches` INT unsigned null , `averagePrice` DECIMAL(10,2) null , `averageWeight` DECIMAL(10,2) null , `commission` DECIMAL(10,2) null default '15.00' , `return` VARCHAR(255) null default '1' , `supplierCode` VARCHAR(100) null ) CHARSET utf8", $silent);
		setupIndexes('ordersDetails', array('order','productCode','section'));
		setupTable('_resumeOrders', "create table if not exists `_resumeOrders` (   `kind` VARCHAR(40) null , `company` INT unsigned null , `typedoc` VARCHAR(40) null , `customer` INT unsigned null , `TOT` VARCHAR(40) null , `MONTH` VARCHAR(40) null , `YEAR` VARCHAR(40) null , `DOCs` VARCHAR(40) null , `related` INT unsigned null , `id` INT unsigned not null auto_increment , primary key (`id`)) CHARSET utf8", $silent);
		setupIndexes('_resumeOrders', array('kind','company','typedoc','customer','related'));
		setupTable('products', "create table if not exists `products` (   `id` INT not null auto_increment , primary key (`id`), `codebar` VARCHAR(16) null , `productCode` VARCHAR(255) null , `productName` VARCHAR(255) null , `tax` VARCHAR(40) null , `increment` DECIMAL(10,2) null , `CategoryID` VARCHAR(40) null , `UM` VARCHAR(40) null , `tare` DECIMAL(10,2) null , `QuantityPerUnit` VARCHAR(50) null , `UnitPrice` DECIMAL(10,2) null , `sellPrice` DECIMAL(10,2) null , `UnitsInStock` DECIMAL(10,2) null , `UnitsOnOrder` DECIMAL(10,2) null default '0' , `ReorderLevel` DECIMAL(10,2) null default '0' , `balance` DECIMAL(10,2) null , `Discontinued` INT null default '0' , `manufactured_date` DATE null , `expiry_date` DATE null , `note` TEXT null , `update_date` DATETIME null ) CHARSET utf8", $silent);
		setupIndexes('products', array('tax','CategoryID'));
		setupTable('firstCashNote', "create table if not exists `firstCashNote` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `order` INT unsigned null , `operationDate` DATE null , `company` INT unsigned null , `customer` INT unsigned null , `documentNumber` INT null , `causal` VARCHAR(255) null , `revenue` DECIMAL(10,2) null , `outputs` DECIMAL(10,2) null , `balance` DECIMAL(10,2) null , `idBank` INT unsigned null , `bank` INT unsigned null , `note` VARCHAR(255) null , `paymentDeadLine` DATE null , `payed` VARCHAR(255) null default '0' ) CHARSET utf8", $silent);
		setupIndexes('firstCashNote', array('kind','order','company','customer','idBank'));
		setupTable('companies', "create table if not exists `companies` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `companyCode` VARCHAR(255) null , unique `companyCode_unique` (`companyCode`), `companyName` VARCHAR(255) null , `personaFisica` VARCHAR(40) not null default 'No' , `fiscalCode` VARCHAR(255) null , `vat` VARCHAR(255) not null , `notes` TEXT null , `codiceDestinatario` VARCHAR(7) null default '0000000' , `regimeFiscale` VARCHAR(40) null , `tipoCassa` VARCHAR(40) null , `modalitaPagamento` VARCHAR(40) null , `RiferimentoAmministrazione` VARCHAR(40) null , `FormatoTrasmissione` VARCHAR(40) not null default 'FPR12' , `RIT_soggettoRitenuta` VARCHAR(40) null default '0' , `RIT_tipoRitenuta` VARCHAR(40) not null default 'RT02' , `RIT_AliquotaRitenuta` DECIMAL(10,2) null , `RIT_CausalePagamento` VARCHAR(40) null ) CHARSET utf8", $silent);
		setupIndexes('companies', array('kind','regimeFiscale','tipoCassa','modalitaPagamento','FormatoTrasmissione'));
		setupTable('vatRegister', "create table if not exists `vatRegister` (   `id` INT unsigned not null auto_increment , primary key (`id`), `company` INT unsigned null , `companyName` INT unsigned null , `tax` VARCHAR(40) null default '4%' , `month` VARCHAR(40) null , `year` VARCHAR(40) null default '2018' , `amount` DECIMAL(10,2) null , `ufficio_Ced_PA` CHAR(2) null , `numeroREA_Ced_PA` CHAR(20) null , `capitaleSociale_Ced_PA` DECIMAL(15,2) null , `socioUnico_Ced_PA` VARCHAR(2) null default 'SM' , `statoLiquidazione_Ced_PA` CHAR(2) null default 'LN' , `default` INT null default '0' ) CHARSET utf8", $silent);
		setupIndexes('vatRegister', array('company'));
		setupTable('contacts', "create table if not exists `contacts` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `titleCourtesy` VARCHAR(40) null , `name` VARCHAR(255) null , `lastName` VARCHAR(255) null , `notes` TEXT null , `title` VARCHAR(255) null , `birthDate` DATE null , `CodEORI` VARCHAR(40) null ) CHARSET utf8", $silent);
		setupIndexes('contacts', array('kind'));
		setupTable('creditDocument', "create table if not exists `creditDocument` (   `id` INT unsigned not null auto_increment , primary key (`id`), `incomingTypeDoc` VARCHAR(255) null , `customerID` VARCHAR(255) null , `nrDoc` VARCHAR(255) null , `dateIncomingNote` DATE null , `customerFirm` VARCHAR(255) null , `customerAddress` VARCHAR(255) null , `customerPostCode` VARCHAR(255) null , `customerTown` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupTable('electronicInvoice', "create table if not exists `electronicInvoice` (   `id` INT unsigned not null auto_increment , primary key (`id`), `topic` VARCHAR(255) null , `currency` VARCHAR(255) null default 'IT' , `trasmissionFormat` VARCHAR(255) null , `country` VARCHAR(255) null default 'IT' ) CHARSET utf8", $silent);
		setupTable('countries', "create table if not exists `countries` (   `id` INT unsigned not null auto_increment , primary key (`id`), `country` VARCHAR(255) null , `code` VARCHAR(100) null , `ISOcode` VARCHAR(40) null ) CHARSET utf8", $silent);
		setupTable('town', "create table if not exists `town` (   `id` INT unsigned not null auto_increment , primary key (`id`), `country` INT unsigned null , `idIstat` VARCHAR(255) null , `town` VARCHAR(255) null , `district` VARCHAR(255) not null , `region` VARCHAR(255) null , `prefix` VARCHAR(255) null , `shipCode` VARCHAR(255) not null , `fiscCode` VARCHAR(255) null , `inhabitants` VARCHAR(255) null , `link` VARCHAR(255) null ) CHARSET utf8", $silent);
		setupIndexes('town', array('country'));
		setupTable('GPSTrackingSystem', "create table if not exists `GPSTrackingSystem` (   `id` INT unsigned not null auto_increment , primary key (`id`), `carTracked` VARCHAR(40) null ) CHARSET utf8", $silent);
		setupTable('kinds', "create table if not exists `kinds` (   `entity` BLOB not null , `code` VARCHAR(40) not null , primary key (`code`), `name` VARCHAR(255) not null , `value` TEXT null , `descriptions` TEXT null ) CHARSET utf8", $silent);
		setupTable('Logs', "create table if not exists `Logs` (   `id` INT unsigned not null auto_increment , primary key (`id`), `ip` VARCHAR(16) null , `ts` BIGINT null , `details` TEXT null ) CHARSET utf8", $silent);
		setupTable('attributes', "create table if not exists `attributes` (   `id` INT unsigned not null auto_increment , primary key (`id`), `attribute` VARCHAR(40) null , `value` TEXT null , `contact` INT unsigned null , `company` INT unsigned null , `product` INT null ) CHARSET utf8", $silent);
		setupIndexes('attributes', array('attribute','contact','company','product'));
		setupTable('addresses', "create table if not exists `addresses` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `address` VARCHAR(255) not null , `houseNumber` VARCHAR(255) not null , `country` INT unsigned not null , `country_name` INT unsigned null , `town` INT unsigned not null , `postalCode` INT unsigned null , `district` INT unsigned null , `contact` INT unsigned null , `company` INT unsigned null , `map` VARCHAR(40) null , `default` INT null default '0' , `ship` INT null default '0' ) CHARSET utf8", $silent);
		setupIndexes('addresses', array('kind','country','town','contact','company'));
		setupTable('phones', "create table if not exists `phones` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `phoneNumber` VARCHAR(255) null , `contact` INT unsigned null , `company` INT unsigned null , `default` TINYINT null default '0' ) CHARSET utf8", $silent);
		setupIndexes('phones', array('kind','contact','company'));
		setupTable('mails', "create table if not exists `mails` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) null , `mail` VARCHAR(255) null , `contact` INT unsigned null , `company` INT unsigned null , `default` TINYINT null default '0' ) CHARSET utf8", $silent);
		setupIndexes('mails', array('kind','contact','company'));
		setupTable('contacts_companies', "create table if not exists `contacts_companies` (   `id` INT unsigned not null auto_increment , primary key (`id`), `contact` INT unsigned null , `company` INT unsigned null , `default` TINYINT null default '0' ) CHARSET utf8", $silent);
		setupIndexes('contacts_companies', array('contact','company'));
		setupTable('attachments', "create table if not exists `attachments` (   `id` INT unsigned not null auto_increment , primary key (`id`), `name` VARCHAR(255) null , `file` VARCHAR(255) null , `contact` INT unsigned null , `company` INT unsigned null , `thumbUse` INT null default '0' ) CHARSET utf8", $silent);
		setupIndexes('attachments', array('contact','company'));
		setupTable('codiceDestinatario', "create table if not exists `codiceDestinatario` (   `code` VARCHAR(40) not null , primary key (`code`), `text` TEXT null ) CHARSET utf8", $silent);
		setupTable('regimeFiscale', "create table if not exists `regimeFiscale` (   `code` VARCHAR(40) not null , primary key (`code`), `text` TEXT null ) CHARSET utf8", $silent);
		setupTable('tipoCassa', "create table if not exists `tipoCassa` (   `code` VARCHAR(40) not null , primary key (`code`), `text` TEXT null ) CHARSET utf8", $silent);
		setupTable('modalitaPagamento', "create table if not exists `modalitaPagamento` (   `code` VARCHAR(40) not null , primary key (`code`), `text` TEXT null ) CHARSET utf8", $silent);


		// save MD5
		if($fp=@fopen(dirname(__FILE__).'/setup.md5', 'w')){
			fwrite($fp, $thisMD5);
			fclose($fp);
		}
	}


	function setupIndexes($tableName, $arrFields){
		if(!is_array($arrFields)){
			return false;
		}

		foreach($arrFields as $fieldName){
			if(!$res=@db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")){
				continue;
			}
			if(!$row=@db_fetch_assoc($res)){
				continue;
			}
			if($row['Key']==''){
				@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
			}
		}
	}


	function setupTable($tableName, $createSQL='', $silent=true, $arrAlter=''){
		global $Translation;
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)){
			$matches=array();
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/", $arrAlter[0], $matches)){
				$oldTableName=$matches[1];
			}
		}

		if($res=@db_query("select count(1) from `$tableName`")){ // table already exists
			if($row = @db_fetch_array($res)){
				echo str_replace("<TableName>", $tableName, str_replace("<NumRecords>", $row[0],$Translation["table exists"]));
				if(is_array($arrAlter)){
					echo '<br>';
					foreach($arrAlter as $alter){
						if($alter!=''){
							echo "$alter ... ";
							if(!@db_query($alter)){
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							}else{
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				}else{
					echo $Translation["table uptodate"];
				}
			}else{
				echo str_replace("<TableName>", $tableName, $Translation["couldnt count"]);
			}
		}else{ // given tableName doesn't exist

			if($oldTableName!=''){ // if we have a table rename query
				if($ro=@db_query("select count(1) from `$oldTableName`")){ // if old table exists, rename it.
					$renameQuery=array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)){
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					}else{
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				}else{ // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			}else{ // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)){
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';
				}else{
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}
		}

		echo "</div>";

		$out=ob_get_contents();
		ob_end_clean();
		if(!$silent){
			echo $out;
		}
	}
?>