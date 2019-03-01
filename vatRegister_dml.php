<?php

// Data functions (insert, update, delete, form) for table vatRegister

// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

function vatRegister_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('vatRegister');
	if(!$arrPerm[1]){
		return false;
	}

	$data['idCompany'] = makeSafe($_REQUEST['idCompany']);
		if($data['idCompany'] == empty_lookup_value){ $data['idCompany'] = ''; }
	$data['companyName'] = makeSafe($_REQUEST['idCompany']);
		if($data['companyName'] == empty_lookup_value){ $data['companyName'] = ''; }
	$data['tax'] = makeSafe($_REQUEST['tax']);
		if($data['tax'] == empty_lookup_value){ $data['tax'] = ''; }
	$data['month'] = makeSafe($_REQUEST['month']);
		if($data['month'] == empty_lookup_value){ $data['month'] = ''; }
	$data['year'] = makeSafe($_REQUEST['year']);
		if($data['year'] == empty_lookup_value){ $data['year'] = ''; }
	$data['amount'] = makeSafe($_REQUEST['amount']);
		if($data['amount'] == empty_lookup_value){ $data['amount'] = ''; }
	if($data['tax'] == '') $data['tax'] = "4%";
	if($data['year'] == '') $data['year'] = "2018";

	// hook: vatRegister_before_insert
	if(function_exists('vatRegister_before_insert')){
		$args=array();
		if(!vatRegister_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `vatRegister` set       `idCompany`=' . (($data['idCompany'] !== '' && $data['idCompany'] !== NULL) ? "'{$data['idCompany']}'" : 'NULL') . ', `companyName`=' . (($data['companyName'] !== '' && $data['companyName'] !== NULL) ? "'{$data['companyName']}'" : 'NULL') . ', `tax`=' . (($data['tax'] !== '' && $data['tax'] !== NULL) ? "'{$data['tax']}'" : 'NULL') . ', `month`=' . (($data['month'] !== '' && $data['month'] !== NULL) ? "'{$data['month']}'" : 'NULL') . ', `year`=' . (($data['year'] !== '' && $data['year'] !== NULL) ? "'{$data['year']}'" : 'NULL') . ', `amount`=' . (($data['amount'] !== '' && $data['amount'] !== NULL) ? "'{$data['amount']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"vatRegister_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: vatRegister_after_insert
	if(function_exists('vatRegister_after_insert')){
		$res = sql("select * from `vatRegister` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!vatRegister_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('vatRegister', $recID, getLoggedMemberID());

	return $recID;
}

function vatRegister_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('vatRegister');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='vatRegister' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='vatRegister' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: vatRegister_before_delete
	if(function_exists('vatRegister_before_delete')){
		$args=array();
		if(!vatRegister_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `vatRegister` where `id`='$selected_id'", $eo);

	// hook: vatRegister_after_delete
	if(function_exists('vatRegister_after_delete')){
		$args=array();
		vatRegister_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='vatRegister' and pkValue='$selected_id'", $eo);
}

function vatRegister_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('vatRegister');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='vatRegister' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='vatRegister' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['idCompany'] = makeSafe($_REQUEST['idCompany']);
		if($data['idCompany'] == empty_lookup_value){ $data['idCompany'] = ''; }
	$data['companyName'] = makeSafe($_REQUEST['idCompany']);
		if($data['companyName'] == empty_lookup_value){ $data['companyName'] = ''; }
	$data['tax'] = makeSafe($_REQUEST['tax']);
		if($data['tax'] == empty_lookup_value){ $data['tax'] = ''; }
	$data['month'] = makeSafe($_REQUEST['month']);
		if($data['month'] == empty_lookup_value){ $data['month'] = ''; }
	$data['year'] = makeSafe($_REQUEST['year']);
		if($data['year'] == empty_lookup_value){ $data['year'] = ''; }
	$data['amount'] = makeSafe($_REQUEST['amount']);
		if($data['amount'] == empty_lookup_value){ $data['amount'] = ''; }
	$data['selectedID']=makeSafe($selected_id);

	// hook: vatRegister_before_update
	if(function_exists('vatRegister_before_update')){
		$args=array();
		if(!vatRegister_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `vatRegister` set       `idCompany`=' . (($data['idCompany'] !== '' && $data['idCompany'] !== NULL) ? "'{$data['idCompany']}'" : 'NULL') . ', `companyName`=' . (($data['companyName'] !== '' && $data['companyName'] !== NULL) ? "'{$data['companyName']}'" : 'NULL') . ', `tax`=' . (($data['tax'] !== '' && $data['tax'] !== NULL) ? "'{$data['tax']}'" : 'NULL') . ', `month`=' . (($data['month'] !== '' && $data['month'] !== NULL) ? "'{$data['month']}'" : 'NULL') . ', `year`=' . (($data['year'] !== '' && $data['year'] !== NULL) ? "'{$data['year']}'" : 'NULL') . ', `amount`=' . (($data['amount'] !== '' && $data['amount'] !== NULL) ? "'{$data['amount']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="vatRegister_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: vatRegister_after_update
	if(function_exists('vatRegister_after_update')){
		$res = sql("SELECT * FROM `vatRegister` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!vatRegister_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='vatRegister' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function vatRegister_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('vatRegister');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_idCompany = thisOr(undo_magic_quotes($_REQUEST['filterer_idCompany']), '');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: idCompany
	$combo_idCompany = new DataCombo;
	// combobox: tax
	$combo_tax = new Combo;
	$combo_tax->ListType = 0;
	$combo_tax->MultipleSeparator = ', ';
	$combo_tax->ListBoxHeight = 10;
	$combo_tax->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/vatRegister.tax.csv')){
		$tax_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/vatRegister.tax.csv')));
		$combo_tax->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($tax_data)));
		$combo_tax->ListData = $combo_tax->ListItem;
	}else{
		$combo_tax->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("4%;;5%;;10%;;22%")));
		$combo_tax->ListData = $combo_tax->ListItem;
	}
	$combo_tax->SelectName = 'tax';
	// combobox: month
	$combo_month = new Combo;
	$combo_month->ListType = 0;
	$combo_month->MultipleSeparator = ', ';
	$combo_month->ListBoxHeight = 10;
	$combo_month->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/vatRegister.month.csv')){
		$month_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/vatRegister.month.csv')));
		$combo_month->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($month_data)));
		$combo_month->ListData = $combo_month->ListItem;
	}else{
		$combo_month->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("Gennaio;;Febbraio;;Marzo;;Aprile;;Maggio;;Giugno;;Luglio;;Agosto;;Settembre;;Ottobre;;Novembre;;Dicembre")));
		$combo_month->ListData = $combo_month->ListItem;
	}
	$combo_month->SelectName = 'month';

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='vatRegister' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='vatRegister' and pkValue='".makeSafe($selected_id)."'");
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

		$res = sql("select * from `vatRegister` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'vatRegister_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_idCompany->SelectedData = $row['idCompany'];
		$combo_tax->SelectedData = $row['tax'];
		$combo_month->SelectedData = $row['month'];
	}else{
		$combo_idCompany->SelectedData = $filterer_idCompany;
		$combo_tax->SelectedText = ( $_REQUEST['FilterField'][1]=='4' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "4%");
		$combo_month->SelectedText = ( $_REQUEST['FilterField'][1]=='5' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
	}
	$combo_idCompany->HTML = '<span id="idCompany-container' . $rnd1 . '"></span><input type="hidden" name="idCompany" id="idCompany' . $rnd1 . '" value="' . html_attr($combo_idCompany->SelectedData) . '">';
	$combo_idCompany->MatchText = '<span id="idCompany-container-readonly' . $rnd1 . '"></span><input type="hidden" name="idCompany" id="idCompany' . $rnd1 . '" value="' . html_attr($combo_idCompany->SelectedData) . '">';
	$combo_tax->Render();
	$combo_month->Render();

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_idCompany__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['idCompany'] : $filterer_idCompany); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(idCompany_reload__RAND__) == 'function') idCompany_reload__RAND__();
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function idCompany_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#idCompany-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_idCompany__RAND__.value, t: 'vatRegister', f: 'idCompany' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="idCompany"]').val(resp.results[0].id);
							$j('[id=idCompany-container-readonly__RAND__]').html('<span id="idCompany-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }


							if(typeof(idCompany_update_autofills__RAND__) == 'function') idCompany_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 5,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ /* */ return { s: term, p: page, t: 'vatRegister', f: 'idCompany' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_idCompany__RAND__.value = e.added.id;
				AppGini.current_idCompany__RAND__.text = e.added.text;
				$j('[name="idCompany"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }


				if(typeof(idCompany_update_autofills__RAND__) == 'function') idCompany_update_autofills__RAND__();
			});

			if(!$j("#idCompany-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_idCompany__RAND__.value, t: 'vatRegister', f: 'idCompany' },
					success: function(resp){
						$j('[name="idCompany"]').val(resp.results[0].id);
						$j('[id=idCompany-container-readonly__RAND__]').html('<span id="idCompany-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }

						if(typeof(idCompany_update_autofills__RAND__) == 'function') idCompany_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_idCompany__RAND__.value, t: 'vatRegister', f: 'idCompany' },
				success: function(resp){
					$j('[id=idCompany-container__RAND__], [id=idCompany-container-readonly__RAND__]').html('<span id="idCompany-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }

					if(typeof(idCompany_update_autofills__RAND__) == 'function') idCompany_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/vatRegister_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/vatRegister_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'VatRegister details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return vatRegister_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return vatRegister_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
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
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$j(\'form\').eq(0).prop(\'novalidate\', true); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return vatRegister_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
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
		$jsReadOnly .= "\tjQuery('#idCompany').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#idCompany_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#tax').replaceWith('<div class=\"form-control-static\" id=\"tax\">' + (jQuery('#tax').val() || '') + '</div>'); jQuery('#tax-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#month').replaceWith('<div class=\"form-control-static\" id=\"month\">' + (jQuery('#month').val() || '') + '</div>'); jQuery('#month-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#year').replaceWith('<div class=\"form-control-static\" id=\"year\">' + (jQuery('#year').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#amount').replaceWith('<div class=\"form-control-static\" id=\"amount\">' + (jQuery('#amount').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(idCompany)%%>', $combo_idCompany->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(idCompany)%%>', $combo_idCompany->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(idCompany)%%>', urlencode($combo_idCompany->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(tax)%%>', $combo_tax->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(tax)%%>', $combo_tax->SelectedData, $templateCode);
	$templateCode = str_replace('<%%COMBO(month)%%>', $combo_month->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(month)%%>', $combo_month->SelectedData, $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'idCompany' => array('companies', 'ID Azienda'));
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
	$templateCode = str_replace('<%%UPLOADFILE(idCompany)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(tax)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(month)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(year)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(amount)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(idCompany)%%>', safe_html($urow['idCompany']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(idCompany)%%>', html_attr($row['idCompany']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(idCompany)%%>', urlencode($urow['idCompany']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(tax)%%>', safe_html($urow['tax']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(tax)%%>', html_attr($row['tax']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(tax)%%>', urlencode($urow['tax']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(month)%%>', safe_html($urow['month']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(month)%%>', html_attr($row['month']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(month)%%>', urlencode($urow['month']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(year)%%>', safe_html($urow['year']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(year)%%>', html_attr($row['year']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(year)%%>', urlencode($urow['year']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(amount)%%>', safe_html($urow['amount']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(amount)%%>', html_attr($row['amount']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(amount)%%>', urlencode($urow['amount']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(idCompany)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(idCompany)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(tax)%%>', '4%', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(tax)%%>', urlencode('4%'), $templateCode);
		$templateCode = str_replace('<%%VALUE(month)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(month)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(year)%%>', '2018', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(year)%%>', urlencode('2018'), $templateCode);
		$templateCode = str_replace('<%%VALUE(amount)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(amount)%%>', urlencode(''), $templateCode);
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

	$templateCode .= "\tidCompany_update_autofills$rnd1 = function(){\n";
	$templateCode .= "\t\t\$j.ajax({\n";
	if($dvprint){
		$templateCode .= "\t\t\turl: 'vatRegister_autofill.php?rnd1=$rnd1&mfk=idCompany&id=' + encodeURIComponent('".addslashes($row['idCompany'])."'),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "', type: 'GET'\n";
	}else{
		$templateCode .= "\t\t\turl: 'vatRegister_autofill.php?rnd1=$rnd1&mfk=idCompany&id=' + encodeURIComponent(AppGini.current_idCompany{$rnd1}.value),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "', type: 'GET', beforeSend: function(){ /* */ \$j('#idCompany$rnd1').prop('disabled', true); \$j('#idCompanyLoading').html('<img src=loading.gif align=top>'); }, complete: function(){".(($arrPerm[1] || (($arrPerm[3] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm[3] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm[3] == 3)) ? "\$j('#idCompany$rnd1').prop('disabled', false); " : "\$j('#idCompany$rnd1').prop('disabled', true); ")."\$j('#idCompanyLoading').html('');}\n";
	}
	$templateCode.="\t\t});\n";
	$templateCode.="\t};\n";
	if(!$dvprint) $templateCode.="\tif(\$j('#idCompany_caption').length) \$j('#idCompany_caption').click(function(){ /* */ idCompany_update_autofills$rnd1(); });\n";


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('vatRegister');
	if($selected_id){
		$jdata = get_joined_record('vatRegister', $selected_id);
		if($jdata === false) $jdata = get_defaults('vatRegister');
		$rdata = $row;
	}
	$templateCode .= loadView('vatRegister-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: vatRegister_dv
	if(function_exists('vatRegister_dv')){
		$args=array();
		vatRegister_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>