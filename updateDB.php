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
		setupTable('orders', "create table if not exists `orders` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) , `progressiveNr` CHAR(40) , `trasmissionFor` CHAR(10) default 'SDI10' , `consigneeID` CHAR(10) , `company` INT unsigned , `typeDoc` VARCHAR(40) , `multiOrder` INT , `customer` INT unsigned , `employee` INT unsigned , `date` DATE , `requiredDate` DATE , `shippedDate` DATE , `shipVia` INT unsigned , `Freight` DECIMAL(10,2) , `pallets` INT , `licencePlate` VARCHAR(40) , `orderTotal` DECIMAL(10,2) , `cashCredit` VARCHAR(255) default '1' , `trust` INT unsigned , `overdraft` INT , `commisionFee` INT , `consigneeHour` DATETIME , `consigneePlace` VARCHAR(255) , `related` INT ) CHARSET utf8", $silent);
		setupIndexes('orders', array('kind','company','typeDoc','customer','employee','shipVia'));
		setupTable('ordersDetails', "create table if not exists `ordersDetails` (   `id` INT unsigned not null auto_increment , primary key (`id`), `order` INT unsigned , `manufactureDate` DATE , `sellDate` DATE , `expiryDate` DATE , `daysToExpiry` INT , `codebar` INT , `UM` INT , `productCode` INT , `batch` INT , `packages` DECIMAL(10,2) , `noSell` INT , `Quantity` DECIMAL(10,2) default '1' , `QuantityReal` DECIMAL(10,2) , `UnitPrice` DECIMAL(10,2) , `Subtotal` DECIMAL(10,2) unsigned , `taxes` DECIMAL(10,2) , `Discount` DECIMAL(10,2) , `LineTotal` DECIMAL(10,2) , `section` VARCHAR(40) default 'Magazzino Metaponto' , `transaction_type` VARCHAR(40) default 'Outgoing' , `skBatches` INT unsigned , `averagePrice` DECIMAL(10,2) , `averageWeight` DECIMAL(10,2) , `commission` DECIMAL(10,2) default '15.00' , `return` VARCHAR(255) default '1' , `supplierCode` VARCHAR(100) ) CHARSET utf8", $silent);
		setupIndexes('ordersDetails', array('order','productCode','section'));
		setupTable('_resumeOrders', "create table if not exists `_resumeOrders` (   `kind` VARCHAR(40) , `company` INT unsigned , `typedoc` VARCHAR(40) , `customer` INT unsigned , `TOT` VARCHAR(40) , `MONTH` VARCHAR(40) , `YEAR` VARCHAR(40) , `DOCs` VARCHAR(40) , `related` INT unsigned , `id` INT unsigned not null auto_increment , primary key (`id`)) CHARSET utf8", $silent, array( "ALTER TABLE `_resumeOrders` CHANGE `realted` `realted` INT unsigned ","ALTER TABLE `_resumeOrders` CHANGE `realted` `related` INT unsigned "));
		setupIndexes('_resumeOrders', array('kind','company','typedoc','customer','related'));
		setupTable('products', "create table if not exists `products` (   `id` INT not null auto_increment , primary key (`id`), `codebar` VARCHAR(16) , `productCode` VARCHAR(40) , `productName` VARCHAR(50) , `tax` VARCHAR(40) , `increment` DECIMAL(10,2) , `CategoryID` VARCHAR(40) , `UM` VARCHAR(40) , `tare` DECIMAL(10,2) , `QuantityPerUnit` VARCHAR(50) , `UnitPrice` DECIMAL(10,2) , `sellPrice` DECIMAL(10,2) , `UnitsInStock` DECIMAL(10,2) , `UnitsOnOrder` DECIMAL(10,2) default '0' , `ReorderLevel` DECIMAL(10,2) default '0' , `balance` DECIMAL(10,2) , `Discontinued` INT default '0' , `manufactured_date` DATE , `expiry_date` DATE , `note` TEXT , `update_date` DATETIME ) CHARSET utf8", $silent);
		setupIndexes('products', array('tax','CategoryID'));
		setupTable('firstCashNote', "create table if not exists `firstCashNote` (   `id` INT unsigned not null auto_increment , primary key (`id`), `order` INT unsigned , `operationDate` DATE , `documentNumber` INT , `causal` VARCHAR(255) , `revenue` DECIMAL(10,2) , `outputs` DECIMAL(10,2) , `balance` DECIMAL(10,2) , `idBank` INT unsigned , `bank` INT unsigned , `note` VARCHAR(255) , `paymentDeadLine` DATE , `payed` VARCHAR(40) default '0' ) CHARSET utf8", $silent);
		setupIndexes('firstCashNote', array('order'));
		setupTable('vatRegister', "create table if not exists `vatRegister` (   `id` INT unsigned not null auto_increment , primary key (`id`), `idCompany` INT unsigned , `companyName` INT unsigned , `tax` VARCHAR(40) default '4%' , `month` VARCHAR(40) , `year` VARCHAR(40) default '2018' , `amount` DECIMAL(10,2) ) CHARSET utf8", $silent);
		setupIndexes('vatRegister', array('idCompany'));
		setupTable('companies', "create table if not exists `companies` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) not null , `companyCode` VARCHAR(40) , `companyName` VARCHAR(40) , `fiscalCode` VARCHAR(40) , `vat` VARCHAR(40) , `notes` TEXT ) CHARSET utf8", $silent);
		setupIndexes('companies', array('kind'));
		setupTable('contacts', "create table if not exists `contacts` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) , `titleCourtesy` VARCHAR(40) , `name` VARCHAR(40) , `lastName` VARCHAR(40) , `notes` TEXT , `title` VARCHAR(40) , `birthDate` DATETIME ) CHARSET utf8", $silent);
		setupIndexes('contacts', array('kind'));
		setupTable('creditDocument', "create table if not exists `creditDocument` (   `id` INT unsigned not null auto_increment , primary key (`id`), `incomingTypeDoc` VARCHAR(40) , `customerID` VARCHAR(40) , `nrDoc` VARCHAR(40) , `dateIncomingNote` DATE , `customerFirm` VARCHAR(40) , `customerAddress` VARCHAR(40) , `customerPostCode` VARCHAR(40) , `customerTown` VARCHAR(40) ) CHARSET utf8", $silent);
		setupTable('electronicInvoice', "create table if not exists `electronicInvoice` (   `id` INT unsigned not null auto_increment , primary key (`id`), `topic` VARCHAR(255) , `currency` VARCHAR(255) default 'IT' , `trasmissionFormat` VARCHAR(255) , `country` VARCHAR(255) default 'IT' ) CHARSET utf8", $silent);
		setupTable('countries', "create table if not exists `countries` (   `id` INT unsigned not null auto_increment , primary key (`id`), `country` VARCHAR(40) , `code` VARCHAR(40) ) CHARSET utf8", $silent);
		setupTable('town', "create table if not exists `town` (   `id` INT unsigned not null auto_increment , primary key (`id`), `country` INT unsigned , `idIstat` VARCHAR(40) , `town` VARCHAR(40) , `district` VARCHAR(40) , `region` VARCHAR(40) , `prefix` VARCHAR(40) , `shipCode` VARCHAR(40) , `fiscCode` VARCHAR(40) , `inhabitants` VARCHAR(40) , `link` VARCHAR(40) ) CHARSET utf8", $silent);
		setupIndexes('town', array('country'));
		setupTable('GPSTrackingSystem', "create table if not exists `GPSTrackingSystem` (   `id` INT unsigned not null auto_increment , primary key (`id`), `carTracked` VARCHAR(40) ) CHARSET utf8", $silent);
		setupTable('kinds', "create table if not exists `kinds` (   `entity` BLOB not null , `code` VARCHAR(40) not null , primary key (`code`), `name` VARCHAR(40) not null , `value` VARCHAR(40) , `descriptions` TEXT ) CHARSET utf8", $silent);
		setupTable('Logs', "create table if not exists `Logs` (   `id` INT unsigned not null auto_increment , primary key (`id`), `ip` VARCHAR(16) , `ts` BIGINT , `details` TEXT ) CHARSET utf8", $silent);
		setupTable('attributes', "create table if not exists `attributes` (   `id` INT unsigned not null auto_increment , primary key (`id`), `attribute` VARCHAR(40) , `value` TEXT , `contact` INT unsigned , `companies` INT unsigned , `products` INT ) CHARSET utf8", $silent);
		setupIndexes('attributes', array('attribute','contact','companies','products'));
		setupTable('addresses', "create table if not exists `addresses` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) , `address` VARCHAR(40) , `houseNumber` VARCHAR(40) , `country` INT unsigned , `town` INT unsigned , `postalCode` INT unsigned , `district` INT unsigned , `contact` INT unsigned , `company` INT unsigned , `map` VARCHAR(40) , `default` VARCHAR(40) default '0' , `ship` VARCHAR(40) default '0' ) CHARSET utf8", $silent);
		setupIndexes('addresses', array('kind','country','town','district','contact','company'));
		setupTable('phones', "create table if not exists `phones` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) , `phoneNumber` VARCHAR(40) , `contact` INT unsigned , `company` INT unsigned ) CHARSET utf8", $silent);
		setupIndexes('phones', array('kind','contact','company'));
		setupTable('mails', "create table if not exists `mails` (   `id` INT unsigned not null auto_increment , primary key (`id`), `kind` VARCHAR(40) , `mail` VARCHAR(40) , `contact` INT unsigned , `company` INT unsigned ) CHARSET utf8", $silent);
		setupIndexes('mails', array('kind','contact','company'));
		setupTable('contacts_companies', "create table if not exists `contacts_companies` (   `id` INT unsigned not null auto_increment , primary key (`id`), `contact` INT unsigned , `company` INT unsigned ) CHARSET utf8", $silent);
		setupIndexes('contacts_companies', array('contact','company'));
		setupTable('attachments', "create table if not exists `attachments` (   `id` INT unsigned not null auto_increment , primary key (`id`), `name` VARCHAR(40) , `file` VARCHAR(40) , `contact` INT unsigned , `company` INT unsigned , `thumbUse` VARCHAR(40) ) CHARSET utf8", $silent);
		setupIndexes('attachments', array('contact','company'));


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