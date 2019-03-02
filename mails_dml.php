<?php

// Data functions (insert, update, delete, form) for table mails

// This script and data application were generated by AppGini 5.74
// Download AppGini for free from https://bigprof.com/appgini/download/

function mails_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('mails');
	if(!$arrPerm[1]){
		return false;
	}

	$data['kind'] = makeSafe($_REQUEST['kind']);
		if($data['kind'] == empty_lookup_value){ $data['kind'] = ''; }
	$data['mail'] = makeSafe($_REQUEST['mail']);
		if($data['mail'] == empty_lookup_value){ $data['mail'] = ''; }
	$data['contact'] = makeSafe($_REQUEST['contact']);
		if($data['contact'] == empty_lookup_value){ $data['contact'] = ''; }
	$data['company'] = makeSafe($_REQUEST['company']);
		if($data['company'] == empty_lookup_value){ $data['company'] = ''; }
	$data['default'] = makeSafe($_REQUEST['default']);
		if($data['default'] == empty_lookup_value){ $data['default'] = ''; }

	// hook: mails_before_insert
	if(function_exists('mails_before_insert')){
		$args=array();
		if(!mails_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `mails` set       `kind`=' . (($data['kind'] !== '' && $data['kind'] !== NULL) ? "'{$data['kind']}'" : 'NULL') . ', `mail`=' . (($data['mail'] !== '' && $data['mail'] !== NULL) ? "'{$data['mail']}'" : 'NULL') . ', `default`=' . (($data['default'] !== '' && $data['default'] !== NULL) ? "'{$data['default']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"mails_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// automatic contact
	if($_REQUEST['filterer_contact']){
		sql("update `mails` set `contact`='" . makeSafe($_REQUEST['filterer_contact']) . "' where `id`='" . makeSafe($recID, false) . "'", $eo);
	}

	// automatic company
	if($_REQUEST['filterer_company']){
		sql("update `mails` set `company`='" . makeSafe($_REQUEST['filterer_company']) . "' where `id`='" . makeSafe($recID, false) . "'", $eo);
	}

	// hook: mails_after_insert
	if(function_exists('mails_after_insert')){
		$res = sql("select * from `mails` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!mails_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('mails', $recID, getLoggedMemberID());

	return $recID;
}

function mails_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('mails');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='mails' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='mails' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: mails_before_delete
	if(function_exists('mails_before_delete')){
		$args=array();
		if(!mails_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `mails` where `id`='$selected_id'", $eo);

	// hook: mails_after_delete
	if(function_exists('mails_after_delete')){
		$args=array();
		mails_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='mails' and pkValue='$selected_id'", $eo);
}

function mails_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('mails');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='mails' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='mails' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['kind'] = makeSafe($_REQUEST['kind']);
		if($data['kind'] == empty_lookup_value){ $data['kind'] = ''; }
	$data['mail'] = makeSafe($_REQUEST['mail']);
		if($data['mail'] == empty_lookup_value){ $data['mail'] = ''; }
	$data['contact'] = makeSafe($_REQUEST['contact']);
		if($data['contact'] == empty_lookup_value){ $data['contact'] = ''; }
	$data['company'] = makeSafe($_REQUEST['company']);
		if($data['company'] == empty_lookup_value){ $data['company'] = ''; }
	$data['default'] = makeSafe($_REQUEST['default']);
		if($data['default'] == empty_lookup_value){ $data['default'] = ''; }
	$data['selectedID']=makeSafe($selected_id);

	// hook: mails_before_update
	if(function_exists('mails_before_update')){
		$args=array();
		if(!mails_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `mails` set       `kind`=' . (($data['kind'] !== '' && $data['kind'] !== NULL) ? "'{$data['kind']}'" : 'NULL') . ', `mail`=' . (($data['mail'] !== '' && $data['mail'] !== NULL) ? "'{$data['mail']}'" : 'NULL') . ', `default`=' . (($data['default'] !== '' && $data['default'] !== NULL) ? "'{$data['default']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="mails_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: mails_after_update
	if(function_exists('mails_after_update')){
		$res = sql("SELECT * FROM `mails` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!mails_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='mails' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function mails_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('mails');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_kind = thisOr(undo_magic_quotes($_REQUEST['filterer_kind']), '');
	$filterer_contact = thisOr(undo_magic_quotes($_REQUEST['filterer_contact']), '');
	$filterer_company = thisOr(undo_magic_quotes($_REQUEST['filterer_company']), '');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: kind
	$combo_kind = new DataCombo;
	// combobox: contact
	$combo_contact = new DataCombo;
	// combobox: company
	$combo_company = new DataCombo;

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='mails' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='mails' and pkValue='".makeSafe($selected_id)."'");
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

		$res = sql("select * from `mails` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'mails_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_kind->SelectedData = $row['kind'];
		$combo_contact->SelectedData = $row['contact'];
		$combo_company->SelectedData = $row['company'];
	}else{
		$combo_kind->SelectedData = $filterer_kind;
		$combo_contact->SelectedData = $filterer_contact;
		$combo_company->SelectedData = $filterer_company;
	}
	$combo_kind->HTML = '<span id="kind-container' . $rnd1 . '"></span><input type="hidden" name="kind" id="kind' . $rnd1 . '" value="' . html_attr($combo_kind->SelectedData) . '">';
	$combo_kind->MatchText = '<span id="kind-container-readonly' . $rnd1 . '"></span><input type="hidden" name="kind" id="kind' . $rnd1 . '" value="' . html_attr($combo_kind->SelectedData) . '">';
	$combo_contact->HTML = '<span id="contact-container' . $rnd1 . '"></span><input type="hidden" name="contact" id="contact' . $rnd1 . '" value="' . html_attr($combo_contact->SelectedData) . '">';
	$combo_contact->MatchText = '<span id="contact-container-readonly' . $rnd1 . '"></span><input type="hidden" name="contact" id="contact' . $rnd1 . '" value="' . html_attr($combo_contact->SelectedData) . '">';
	$combo_company->HTML = '<span id="company-container' . $rnd1 . '"></span><input type="hidden" name="company" id="company' . $rnd1 . '" value="' . html_attr($combo_company->SelectedData) . '">';
	$combo_company->MatchText = '<span id="company-container-readonly' . $rnd1 . '"></span><input type="hidden" name="company" id="company' . $rnd1 . '" value="' . html_attr($combo_company->SelectedData) . '">';

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_kind__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['kind'] : $filterer_kind); ?>"};
		AppGini.current_contact__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['contact'] : $filterer_contact); ?>"};
		AppGini.current_company__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['company'] : $filterer_company); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(kind_reload__RAND__) == 'function') kind_reload__RAND__();
				if(typeof(contact_reload__RAND__) == 'function') contact_reload__RAND__();
				if(typeof(company_reload__RAND__) == 'function') company_reload__RAND__();
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function kind_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#kind-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_kind__RAND__.value, t: 'mails', f: 'kind' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="kind"]').val(resp.results[0].id);
							$j('[id=kind-container-readonly__RAND__]').html('<span id="kind-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=kinds_view_parent]').hide(); }else{ $j('.btn[id=kinds_view_parent]').show(); }


							if(typeof(kind_update_autofills__RAND__) == 'function') kind_update_autofills__RAND__();
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
					data: function(term, page){ /* */ return { s: term, p: page, t: 'mails', f: 'kind' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_kind__RAND__.value = e.added.id;
				AppGini.current_kind__RAND__.text = e.added.text;
				$j('[name="kind"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=kinds_view_parent]').hide(); }else{ $j('.btn[id=kinds_view_parent]').show(); }


				if(typeof(kind_update_autofills__RAND__) == 'function') kind_update_autofills__RAND__();
			});

			if(!$j("#kind-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_kind__RAND__.value, t: 'mails', f: 'kind' },
					success: function(resp){
						$j('[name="kind"]').val(resp.results[0].id);
						$j('[id=kind-container-readonly__RAND__]').html('<span id="kind-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=kinds_view_parent]').hide(); }else{ $j('.btn[id=kinds_view_parent]').show(); }

						if(typeof(kind_update_autofills__RAND__) == 'function') kind_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_kind__RAND__.value, t: 'mails', f: 'kind' },
				success: function(resp){
					$j('[id=kind-container__RAND__], [id=kind-container-readonly__RAND__]').html('<span id="kind-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=kinds_view_parent]').hide(); }else{ $j('.btn[id=kinds_view_parent]').show(); }

					if(typeof(kind_update_autofills__RAND__) == 'function') kind_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function contact_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#contact-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_contact__RAND__.value, t: 'mails', f: 'contact' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="contact"]').val(resp.results[0].id);
							$j('[id=contact-container-readonly__RAND__]').html('<span id="contact-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=contacts_view_parent]').hide(); }else{ $j('.btn[id=contacts_view_parent]').show(); }


							if(typeof(contact_update_autofills__RAND__) == 'function') contact_update_autofills__RAND__();
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
					data: function(term, page){ /* */ return { s: term, p: page, t: 'mails', f: 'contact' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_contact__RAND__.value = e.added.id;
				AppGini.current_contact__RAND__.text = e.added.text;
				$j('[name="contact"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=contacts_view_parent]').hide(); }else{ $j('.btn[id=contacts_view_parent]').show(); }


				if(typeof(contact_update_autofills__RAND__) == 'function') contact_update_autofills__RAND__();
			});

			if(!$j("#contact-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_contact__RAND__.value, t: 'mails', f: 'contact' },
					success: function(resp){
						$j('[name="contact"]').val(resp.results[0].id);
						$j('[id=contact-container-readonly__RAND__]').html('<span id="contact-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=contacts_view_parent]').hide(); }else{ $j('.btn[id=contacts_view_parent]').show(); }

						if(typeof(contact_update_autofills__RAND__) == 'function') contact_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_contact__RAND__.value, t: 'mails', f: 'contact' },
				success: function(resp){
					$j('[id=contact-container__RAND__], [id=contact-container-readonly__RAND__]').html('<span id="contact-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=contacts_view_parent]').hide(); }else{ $j('.btn[id=contacts_view_parent]').show(); }

					if(typeof(contact_update_autofills__RAND__) == 'function') contact_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function company_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#company-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_company__RAND__.value, t: 'mails', f: 'company' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="company"]').val(resp.results[0].id);
							$j('[id=company-container-readonly__RAND__]').html('<span id="company-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }


							if(typeof(company_update_autofills__RAND__) == 'function') company_update_autofills__RAND__();
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
					data: function(term, page){ /* */ return { s: term, p: page, t: 'mails', f: 'company' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_company__RAND__.value = e.added.id;
				AppGini.current_company__RAND__.text = e.added.text;
				$j('[name="company"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }


				if(typeof(company_update_autofills__RAND__) == 'function') company_update_autofills__RAND__();
			});

			if(!$j("#company-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_company__RAND__.value, t: 'mails', f: 'company' },
					success: function(resp){
						$j('[name="company"]').val(resp.results[0].id);
						$j('[id=company-container-readonly__RAND__]').html('<span id="company-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }

						if(typeof(company_update_autofills__RAND__) == 'function') company_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_company__RAND__.value, t: 'mails', f: 'company' },
				success: function(resp){
					$j('[id=company-container__RAND__], [id=company-container-readonly__RAND__]').html('<span id="company-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=companies_view_parent]').hide(); }else{ $j('.btn[id=companies_view_parent]').show(); }

					if(typeof(company_update_autofills__RAND__) == 'function') company_update_autofills__RAND__();
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
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/mails_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/mails_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Mail details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return mails_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return mails_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
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
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return mails_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
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
		$jsReadOnly .= "\tjQuery('#kind').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#kind_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#mail').replaceWith('<div class=\"form-control-static\" id=\"mail\">' + (jQuery('#mail').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#default').prop('disabled', true);\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(kind)%%>', $combo_kind->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(kind)%%>', $combo_kind->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(kind)%%>', urlencode($combo_kind->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(contact)%%>', $combo_contact->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(contact)%%>', $combo_contact->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(contact)%%>', urlencode($combo_contact->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(company)%%>', $combo_company->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(company)%%>', $combo_company->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(company)%%>', urlencode($combo_company->MatchText), $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'kind' => array('kinds', 'Kind'), 'contact' => array('contacts', 'Contact'), 'company' => array('companies', 'Company'));
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
	$templateCode = str_replace('<%%UPLOADFILE(kind)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(mail)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(contact)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(company)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(default)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(kind)%%>', safe_html($urow['kind']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(kind)%%>', html_attr($row['kind']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(kind)%%>', urlencode($urow['kind']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(mail)%%>', safe_html($urow['mail']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(mail)%%>', html_attr($row['mail']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(mail)%%>', urlencode($urow['mail']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(contact)%%>', safe_html($urow['contact']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(contact)%%>', html_attr($row['contact']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact)%%>', urlencode($urow['contact']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(company)%%>', safe_html($urow['company']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(company)%%>', html_attr($row['company']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(company)%%>', urlencode($urow['company']), $templateCode);
		$templateCode = str_replace('<%%CHECKED(default)%%>', ($row['default'] ? "checked" : ""), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(kind)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(kind)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(mail)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(mail)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(contact)%%>', ( $_REQUEST['FilterField'][1]=='4' && $_REQUEST['FilterOperator'][1]=='<=>' ? $combo_contact->SelectedData : ''), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact)%%>', urlencode( $_REQUEST['FilterField'][1]=='4' && $_REQUEST['FilterOperator'][1]=='<=>' ? $combo_contact->SelectedData : ''), $templateCode);
		$templateCode = str_replace('<%%VALUE(company)%%>', ( $_REQUEST['FilterField'][1]=='5' && $_REQUEST['FilterOperator'][1]=='<=>' ? $combo_company->SelectedData : ''), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(company)%%>', urlencode( $_REQUEST['FilterField'][1]=='5' && $_REQUEST['FilterOperator'][1]=='<=>' ? $combo_company->SelectedData : ''), $templateCode);
		$templateCode = str_replace('<%%CHECKED(default)%%>', '', $templateCode);
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
	$rdata = $jdata = get_defaults('mails');
	if($selected_id){
		$jdata = get_joined_record('mails', $selected_id);
		if($jdata === false) $jdata = get_defaults('mails');
		$rdata = $row;
	}
	$templateCode .= loadView('mails-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: mails_dv
	if(function_exists('mails_dv')){
		$args=array();
		mails_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>