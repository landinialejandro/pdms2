<?php
// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir = dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('ordersDetails');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk = $_GET['mfk'];
	$id = makeSafe($_GET['id']);
	$rnd1 = intval($_GET['rnd1']); if(!$rnd1) $rnd1 = '';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'order':
			if(!$id){
				?>
				$j('#transaction_type<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `orders`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', IF(    CHAR_LENGTH(`companies1`.`companyCode`) || CHAR_LENGTH(`companies1`.`companyName`), CONCAT_WS('',   `companies1`.`companyCode`, ' - ', `companies1`.`companyName`), '') as 'company', IF(    CHAR_LENGTH(`kinds2`.`code`) || CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`code`, ' - ', `kinds2`.`name`), '') as 'typeDoc', `orders`.`multiOrder` as 'multiOrder', `orders`.`divisa` as 'divisa', `orders`.`causale` as 'causale', IF(    CHAR_LENGTH(`companies2`.`companyName`), CONCAT_WS('',   `companies2`.`companyName`), '') as 'customer', IF(    CHAR_LENGTH(`companies3`.`companyName`), CONCAT_WS('',   `companies3`.`companyName`), '') as 'supplier', `orders`.`employee` as 'employee', if(`orders`.`date`,date_format(`orders`.`date`,'%d/%m/%Y'),'') as 'date', if(`orders`.`dateRequired`,date_format(`orders`.`dateRequired`,'%d/%m/%Y'),'') as 'dateRequired', if(`orders`.`dateShipped`,date_format(`orders`.`dateShipped`,'%d/%m/%Y'),'') as 'dateShipped', IF(    CHAR_LENGTH(`companies4`.`companyName`), CONCAT_WS('',   `companies4`.`companyName`), '') as 'shipVia', `orders`.`Freight` as 'Freight', `orders`.`pallets` as 'pallets', if(CHAR_LENGTH(`orders`.`licencePlate`)>100, concat(left(`orders`.`licencePlate`,100),' ...'), `orders`.`licencePlate`) as 'licencePlate', `orders`.`importoSconto` as 'importoSconto', `orders`.`orderTotal` as 'orderTotal', `orders`.`RIT_importoRitenuta` as 'RIT_importoRitenuta', concat('<i class=\"glyphicon glyphicon-', if(`orders`.`cashCredit`, 'check', 'unchecked'), '\"></i>') as 'cashCredit', `orders`.`trust` as 'trust', `orders`.`overdraft` as 'overdraft', `orders`.`commisionFee` as 'commisionFee', `orders`.`commisionRate` as 'commisionRate', if(`orders`.`consigneeHour`,date_format(`orders`.`consigneeHour`,'%d/%m/%Y %h:%i %p'),'') as 'consigneeHour', `orders`.`consigneePlace` as 'consigneePlace', `orders`.`related` as 'related', `orders`.`document` as 'document' FROM `orders` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`orders`.`kind` LEFT JOIN `companies` as companies1 ON `companies1`.`id`=`orders`.`company` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`orders`.`typeDoc` LEFT JOIN `companies` as companies2 ON `companies2`.`id`=`orders`.`customer` LEFT JOIN `companies` as companies3 ON `companies3`.`id`=`orders`.`supplier` LEFT JOIN `companies` as companies4 ON `companies4`.`id`=`orders`.`shipVia`  WHERE `orders`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#transaction_type<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['kind']))); ?>&nbsp;');
			<?php
			break;

		case 'productCode':
			if(!$id){
				?>
				$j('#codebar<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#UM<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#batch<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `products`.`id` as 'id', `products`.`codebar` as 'codebar', if(CHAR_LENGTH(`products`.`productCode`)>100, concat(left(`products`.`productCode`,100),' ...'), `products`.`productCode`) as 'productCode', if(CHAR_LENGTH(`products`.`productName`)>100, concat(left(`products`.`productName`,100),' ...'), `products`.`productName`) as 'productName', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'tax', `products`.`increment` as 'increment', IF(    CHAR_LENGTH(`kinds2`.`name`), CONCAT_WS('',   `kinds2`.`name`), '') as 'CategoryID', `products`.`UM` as 'UM', `products`.`tare` as 'tare', `products`.`QuantityPerUnit` as 'QuantityPerUnit', CONCAT('&euro;', FORMAT(`products`.`UnitPrice`, 2)) as 'UnitPrice', CONCAT('&euro;', FORMAT(`products`.`sellPrice`, 2)) as 'sellPrice', `products`.`UnitsInStock` as 'UnitsInStock', `products`.`UnitsOnOrder` as 'UnitsOnOrder', `products`.`ReorderLevel` as 'ReorderLevel', `products`.`balance` as 'balance', concat('<i class=\"glyphicon glyphicon-', if(`products`.`Discontinued`, 'check', 'unchecked'), '\"></i>') as 'Discontinued', if(`products`.`manufactured_date`,date_format(`products`.`manufactured_date`,'%d/%m/%Y'),'') as 'manufactured_date', if(`products`.`expiry_date`,date_format(`products`.`expiry_date`,'%d/%m/%Y'),'') as 'expiry_date', `products`.`note` as 'note', if(`products`.`update_date`,date_format(`products`.`update_date`,'%d/%m/%Y %h:%i %p'),'') as 'update_date' FROM `products` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`products`.`tax` LEFT JOIN `kinds` as kinds2 ON `kinds2`.`code`=`products`.`CategoryID`  WHERE `products`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#codebar<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['codebar']))); ?>&nbsp;');
			$j('#UM<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['UM']))); ?>&nbsp;');
			$j('#batch<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['productCode'].'-'.$row['id']))); ?>&nbsp;');
			<?php
			break;


	}

?>