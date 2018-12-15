<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir = dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('firstCashNote');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk = $_GET['mfk'];
	$id = makeSafe($_GET['id']);
	$rnd1 = intval($_GET['rnd1']); if(!$rnd1) $rnd1 = '';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'idBank':
			if(!$id){
				?>
				$j('#company<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#customer<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#bank<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `companies`.`id` as 'id', IF(    CHAR_LENGTH(`kinds1`.`name`), CONCAT_WS('',   `kinds1`.`name`), '') as 'kind', if(CHAR_LENGTH(`companies`.`companyCode`)>100, concat(left(`companies`.`companyCode`,100),' ...'), `companies`.`companyCode`) as 'companyCode', if(CHAR_LENGTH(`companies`.`companyName`)>100, concat(left(`companies`.`companyName`,100),' ...'), `companies`.`companyName`) as 'companyName', if(CHAR_LENGTH(`companies`.`fiscalCode`)>100, concat(left(`companies`.`fiscalCode`,100),' ...'), `companies`.`fiscalCode`) as 'fiscalCode', if(CHAR_LENGTH(`companies`.`vat`)>100, concat(left(`companies`.`vat`,100),' ...'), `companies`.`vat`) as 'vat', `companies`.`notes` as 'notes' FROM `companies` LEFT JOIN `kinds` as kinds1 ON `kinds1`.`code`=`companies`.`kind`  WHERE `companies`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#company<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['companyCode'].' - '.$row['companyName']))); ?>&nbsp;');
			$j('#customer<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['companyName']))); ?>&nbsp;');
			$j('#bank<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['companyName']))); ?>&nbsp;');
			<?php
			break;


	}

?>
