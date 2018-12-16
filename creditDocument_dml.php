<?php

// Data functions (insert, update, delete, form) for table creditDocument

// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

function creditDocument_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('creditDocument');
	if(!$arrPerm[1]){
		return false;
	}

	$data['incomingTypeDoc'] = makeSafe($_REQUEST['incomingTypeDoc']);
		if($data['incomingTypeDoc'] == empty_lookup_value){ $data['incomingTypeDoc'] = ''; }
	$data['customerID'] = makeSafe($_REQUEST['customerID']);
		if($data['customerID'] == empty_lookup_value){ $data['customerID'] = ''; }
	$data['nrDoc'] = makeSafe($_REQUEST['nrDoc']);
		if($data['nrDoc'] == empty_lookup_value){ $data['nrDoc'] = ''; }
	$data['dateIncomingNote'] = intval($_REQUEST['dateIncomingNoteYear']) . '-' . intval($_REQUEST['dateIncomingNoteMonth']) . '-' . intval($_REQUEST['dateIncomingNoteDay']);
	$data['dateIncomingNote'] = parseMySQLDate($data['dateIncomingNote'], '<%%creationDate%%>');
	$data['customerFirm'] = makeSafe($_REQUEST['customerFirm']);
		if($data['customerFirm'] == empty_lookup_value){ $data['customerFirm'] = ''; }
	$data['customerAddress'] = makeSafe($_REQUEST['customerAddress']);
		if($data['customerAddress'] == empty_lookup_value){ $data['customerAddress'] = ''; }
	$data['customerPostCode'] = makeSafe($_REQUEST['customerPostCode']);
		if($data['customerPostCode'] == empty_lookup_value){ $data['customerPostCode'] = ''; }
	$data['customerTown'] = makeSafe($_REQUEST['customerTown']);
		if($data['customerTown'] == empty_lookup_value){ $data['customerTown'] = ''; }

	// hook: creditDocument_before_insert
	if(function_exists('creditDocument_before_insert')){
		$args=array();
		if(!creditDocument_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `creditDocument` set       `incomingTypeDoc`=' . (($data['incomingTypeDoc'] !== '' && $data['incomingTypeDoc'] !== NULL) ? "'{$data['incomingTypeDoc']}'" : 'NULL') . ', `customerID`=' . (($data['customerID'] !== '' && $data['customerID'] !== NULL) ? "'{$data['customerID']}'" : 'NULL') . ', `nrDoc`=' . (($data['nrDoc'] !== '' && $data['nrDoc'] !== NULL) ? "'{$data['nrDoc']}'" : 'NULL') . ', `dateIncomingNote`=' . (($data['dateIncomingNote'] !== '' && $data['dateIncomingNote'] !== NULL) ? "'{$data['dateIncomingNote']}'" : 'NULL') . ', `customerFirm`=' . (($data['customerFirm'] !== '' && $data['customerFirm'] !== NULL) ? "'{$data['customerFirm']}'" : 'NULL') . ', `customerAddress`=' . (($data['customerAddress'] !== '' && $data['customerAddress'] !== NULL) ? "'{$data['customerAddress']}'" : 'NULL') . ', `customerPostCode`=' . (($data['customerPostCode'] !== '' && $data['customerPostCode'] !== NULL) ? "'{$data['customerPostCode']}'" : 'NULL') . ', `customerTown`=' . (($data['customerTown'] !== '' && $data['customerTown'] !== NULL) ? "'{$data['customerTown']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"creditDocument_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: creditDocument_after_insert
	if(function_exists('creditDocument_after_insert')){
		$res = sql("select * from `creditDocument` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!creditDocument_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('creditDocument', $recID, getLoggedMemberID());

	return $recID;
}

function creditDocument_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('creditDocument');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='creditDocument' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='creditDocument' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: creditDocument_before_delete
	if(function_exists('creditDocument_before_delete')){
		$args=array();
		if(!creditDocument_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `creditDocument` where `id`='$selected_id'", $eo);

	// hook: creditDocument_after_delete
	if(function_exists('creditDocument_after_delete')){
		$args=array();
		creditDocument_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='creditDocument' and pkValue='$selected_id'", $eo);
}

function creditDocument_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('creditDocument');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='creditDocument' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='creditDocument' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['incomingTypeDoc'] = makeSafe($_REQUEST['incomingTypeDoc']);
		if($data['incomingTypeDoc'] == empty_lookup_value){ $data['incomingTypeDoc'] = ''; }
	$data['customerID'] = makeSafe($_REQUEST['customerID']);
		if($data['customerID'] == empty_lookup_value){ $data['customerID'] = ''; }
	$data['nrDoc'] = makeSafe($_REQUEST['nrDoc']);
		if($data['nrDoc'] == empty_lookup_value){ $data['nrDoc'] = ''; }
	$data['dateIncomingNote'] = intval($_REQUEST['dateIncomingNoteYear']) . '-' . intval($_REQUEST['dateIncomingNoteMonth']) . '-' . intval($_REQUEST['dateIncomingNoteDay']);
	$data['dateIncomingNote'] = parseMySQLDate($data['dateIncomingNote'], '<%%creationDate%%>');
	$data['customerFirm'] = makeSafe($_REQUEST['customerFirm']);
		if($data['customerFirm'] == empty_lookup_value){ $data['customerFirm'] = ''; }
	$data['customerAddress'] = makeSafe($_REQUEST['customerAddress']);
		if($data['customerAddress'] == empty_lookup_value){ $data['customerAddress'] = ''; }
	$data['customerPostCode'] = makeSafe($_REQUEST['customerPostCode']);
		if($data['customerPostCode'] == empty_lookup_value){ $data['customerPostCode'] = ''; }
	$data['customerTown'] = makeSafe($_REQUEST['customerTown']);
		if($data['customerTown'] == empty_lookup_value){ $data['customerTown'] = ''; }
	$data['selectedID']=makeSafe($selected_id);

	// hook: creditDocument_before_update
	if(function_exists('creditDocument_before_update')){
		$args=array();
		if(!creditDocument_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `creditDocument` set       `incomingTypeDoc`=' . (($data['incomingTypeDoc'] !== '' && $data['incomingTypeDoc'] !== NULL) ? "'{$data['incomingTypeDoc']}'" : 'NULL') . ', `customerID`=' . (($data['customerID'] !== '' && $data['customerID'] !== NULL) ? "'{$data['customerID']}'" : 'NULL') . ', `nrDoc`=' . (($data['nrDoc'] !== '' && $data['nrDoc'] !== NULL) ? "'{$data['nrDoc']}'" : 'NULL') . ', `dateIncomingNote`=' . (($data['dateIncomingNote'] !== '' && $data['dateIncomingNote'] !== NULL) ? "'{$data['dateIncomingNote']}'" : 'NULL') . ', `customerFirm`=' . (($data['customerFirm'] !== '' && $data['customerFirm'] !== NULL) ? "'{$data['customerFirm']}'" : 'NULL') . ', `customerAddress`=' . (($data['customerAddress'] !== '' && $data['customerAddress'] !== NULL) ? "'{$data['customerAddress']}'" : 'NULL') . ', `customerPostCode`=' . (($data['customerPostCode'] !== '' && $data['customerPostCode'] !== NULL) ? "'{$data['customerPostCode']}'" : 'NULL') . ', `customerTown`=' . (($data['customerTown'] !== '' && $data['customerTown'] !== NULL) ? "'{$data['customerTown']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="creditDocument_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: creditDocument_after_update
	if(function_exists('creditDocument_after_update')){
		$res = sql("SELECT * FROM `creditDocument` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!creditDocument_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='creditDocument' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function creditDocument_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('creditDocument');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}


	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: dateIncomingNote
	$combo_dateIncomingNote = new DateCombo;
	$combo_dateIncomingNote->DateFormat = "dmy";
	$combo_dateIncomingNote->MinYear = 1900;
	$combo_dateIncomingNote->MaxYear = 2100;
	$combo_dateIncomingNote->DefaultDate = parseMySQLDate('<%%creationDate%%>', '<%%creationDate%%>');
	$combo_dateIncomingNote->MonthNames = $Translation['month names'];
	$combo_dateIncomingNote->NamePrefix = 'dateIncomingNote';

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='creditDocument' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='creditDocument' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `creditDocument` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'creditDocument_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_dateIncomingNote->DefaultDate = $row['dateIncomingNote'];
	}else{
	}

	ob_start();
	?>

	<script>
		// initial lookup values

		jQuery(function() {
			setTimeout(function(){
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/creditDocument_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/creditDocument_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'CreditDocument details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return creditDocument_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return creditDocument_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'AppGini.closeParentModal(); return false;';
	}else{
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return creditDocument_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate && !$AllowInsert) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#incomingTypeDoc').replaceWith('<div class=\"form-control-static\" id=\"incomingTypeDoc\">' + (jQuery('#incomingTypeDoc').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#customerID').replaceWith('<div class=\"form-control-static\" id=\"customerID\">' + (jQuery('#customerID').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#nrDoc').replaceWith('<div class=\"form-control-static\" id=\"nrDoc\">' + (jQuery('#nrDoc').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#dateIncomingNote').prop('readonly', true);\n";
		$jsReadOnly .= "\tjQuery('#dateIncomingNoteDay, #dateIncomingNoteMonth, #dateIncomingNoteYear').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#customerFirm').replaceWith('<div class=\"form-control-static\" id=\"customerFirm\">' + (jQuery('#customerFirm').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#customerAddress').replaceWith('<div class=\"form-control-static\" id=\"customerAddress\">' + (jQuery('#customerAddress').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#customerPostCode').replaceWith('<div class=\"form-control-static\" id=\"customerPostCode\">' + (jQuery('#customerPostCode').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#customerTown').replaceWith('<div class=\"form-control-static\" id=\"customerTown\">' + (jQuery('#customerTown').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(dateIncomingNote)%%>', ($selected_id && !$arrPerm[3] ? '<div class="form-control-static">' . $combo_dateIncomingNote->GetHTML(true) . '</div>' : $combo_dateIncomingNote->GetHTML()), $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(dateIncomingNote)%%>', $combo_dateIncomingNote->GetHTML(true), $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array();
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(incomingTypeDoc)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(customerID)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(nrDoc)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(dateIncomingNote)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(customerFirm)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(customerAddress)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(customerPostCode)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(customerTown)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(incomingTypeDoc)%%>', safe_html($urow['incomingTypeDoc']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(incomingTypeDoc)%%>', html_attr($row['incomingTypeDoc']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(incomingTypeDoc)%%>', urlencode($urow['incomingTypeDoc']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(customerID)%%>', safe_html($urow['customerID']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(customerID)%%>', html_attr($row['customerID']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerID)%%>', urlencode($urow['customerID']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(nrDoc)%%>', safe_html($urow['nrDoc']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(nrDoc)%%>', html_attr($row['nrDoc']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(nrDoc)%%>', urlencode($urow['nrDoc']), $templateCode);
		$templateCode = str_replace('<%%VALUE(dateIncomingNote)%%>', @date('d/m/Y', @strtotime(html_attr($row['dateIncomingNote']))), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(dateIncomingNote)%%>', urlencode(@date('d/m/Y', @strtotime(html_attr($urow['dateIncomingNote'])))), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(customerFirm)%%>', safe_html($urow['customerFirm']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(customerFirm)%%>', html_attr($row['customerFirm']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerFirm)%%>', urlencode($urow['customerFirm']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(customerAddress)%%>', safe_html($urow['customerAddress']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(customerAddress)%%>', html_attr($row['customerAddress']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerAddress)%%>', urlencode($urow['customerAddress']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(customerPostCode)%%>', safe_html($urow['customerPostCode']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(customerPostCode)%%>', html_attr($row['customerPostCode']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerPostCode)%%>', urlencode($urow['customerPostCode']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(customerTown)%%>', safe_html($urow['customerTown']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(customerTown)%%>', html_attr($row['customerTown']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerTown)%%>', urlencode($urow['customerTown']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(incomingTypeDoc)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(incomingTypeDoc)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(customerID)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerID)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(nrDoc)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(nrDoc)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(dateIncomingNote)%%>', '<%%creationDate%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(dateIncomingNote)%%>', urlencode('<%%creationDate%%>'), $templateCode);
		$templateCode = str_replace('<%%VALUE(customerFirm)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerFirm)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(customerAddress)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerAddress)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(customerPostCode)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerPostCode)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(customerTown)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(customerTown)%%>', urlencode(''), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('creditDocument');
	if($selected_id){
		$jdata = get_joined_record('creditDocument', $selected_id);
		if($jdata === false) $jdata = get_defaults('creditDocument');
		$rdata = $row;
	}
	$templateCode .= loadView('creditDocument-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: creditDocument_dv
	if(function_exists('creditDocument_dv')){
		$args=array();
		creditDocument_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>