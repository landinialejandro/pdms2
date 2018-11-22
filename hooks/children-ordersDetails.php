<?php // if(!isset($Translation)) die('No direct access allowed.'); ?>
<?php $current_table = 'ordersDetails'; ?>
<?php
	$cleaner = new CI_Input();
	$cleaner->charset = datalist_db_encoding;
        $currDir = dirname(__FILE__);
        include_once 'ordersDetails_AJX.php';
?>
<script>
	<?php echo $current_table; ?>GetChildrenRecordsList = function(command){
		var param = {
			ChildTable: "<?php echo $parameters['ChildTable']; ?>",
			ChildLookupField: "<?php echo $parameters['ChildLookupField']; ?>",
			SelectedID: "<?php echo addslashes($parameters['SelectedID']); ?>",
			Page: <?php echo addslashes($parameters['Page']); ?>,
			SortBy: <?php echo ($parameters['SortBy'] === false ? '""' : $parameters['SortBy']); ?>,
			SortDirection: '<?php echo $parameters['SortDirection']; ?>',
			AutoClose: <?php echo ($config['auto-close'] ? 'true' : 'false'); ?>
		};
		var panelID = "panel_<?php echo "{$parameters['ChildTable']}-{$parameters['ChildLookupField']}"; ?>";
		var mbWidth = window.innerWidth * 0.9;
		var mbHeight = window.innerHeight * 0.8;
		if(mbWidth > 1000){ mbWidth = 1000; }
		if(mbHeight > 800){ mbHeight = 800; }

		switch(command.Verb){
			case 'sort': /* order by given field index in 'SortBy' */
				post("./hooks/myParent-children.php", {
					ChildTable: param.ChildTable,
					ChildLookupField: param.ChildLookupField,
					SelectedID: param.SelectedID,
					Page: param.Page,
					SortBy: command.SortBy,
					SortDirection: command.SortDirection,
					Operation: 'get-records'
				}, panelID, undefined, 'pc-loading');
				break;
			case 'page': /* next or previous page as provided by 'Page' */
				if(command.Page.toLowerCase() == 'next'){ command.Page = param.Page + 1; }
				else if(command.Page.toLowerCase() == 'previous'){ command.Page = param.Page - 1; }

				if(command.Page < 1 || command.Page > <?php echo ceil($totalMatches / $config['records-per-page']); ?>){ return; }
				post("./hooks/myParent-children.php", {
					ChildTable: param.ChildTable,
					ChildLookupField: param.ChildLookupField,
					SelectedID: param.SelectedID,
					Page: command.Page,
					SortBy: param.SortBy,
					SortDirection: param.SortDirection,
					Operation: 'get-records'
				}, panelID, undefined, 'pc-loading');
				break;
			case 'new': /* new record */
				var url = $j('#' + param.ChildTable + '_hclink').val() + '&addNew_x=1&Embedded=1' + (param.AutoClose ? '&AutoClose=1' : '');
				modal_window({
					url: url,
					close: function(){ /* */ <?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); },
					size: 'full',
					title: '<?php echo addslashes("{$config['tab-label']}: {$Translation['Add New']}"); ?>'
				});
				break;
			case 'open': /* opens the detail view for given child record PK provided in 'ChildID' */
				var url = param.ChildTable + '_view.php?Embedded=1&SelectedID=' + escape(command.ChildID) + (param.AutoClose ? '&AutoClose=1' : '');
				modal_window({
					url: url,
					close: function(){ /* */ <?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); },
					size: 'full',
					title: '<?php echo addslashes($config['tab-label']); ?>'
				});
				break;
			case 'reload': /* just a way of refreshing children, retaining sorting and pagination & without reloading the whole page */
				post("./hooks/myParent-children.php", {
					ChildTable: param.ChildTable,
					ChildLookupField: param.ChildLookupField,
					SelectedID: param.SelectedID,
					Page: param.Page,
					SortBy: param.SortBy,
					SortDirection: param.SortDirection,
					Operation: 'get-records'
				}, panelID, undefined, 'pc-loading');
                                ActualizaValorTotal();
//                               console.log('reload');
				break;
		}
	};
        
        var record = "<?php echo $totalMatches;?>";
        var registros = ' (You have ' + record + ' items loaded)';
        if (record === '0'){
            var registros = ' (No item loaded)';
        }
        if (record === '1'){
            var registros = ' (You have a loaded item)';
        }
        
        $j(function(){
            $j('#articulos_listado').select2({
			ajax: {
				url: 'ajax_combo.php',
				dataType: 'json',
				cache: true,
				data: function(term, page){ return { s: term, p: page, t: 'ordersDetails', f: 'IDproduct_lookup' }; },
				results: function(resp, page){ 
                                            return resp; }
			},
			width: 350
		}).on('change', function(e){
			$j('#art').val(e.added.id);
		});
             $j('#tab_ordersDetails-order').html('<img src=\"resources/table_icons/calendar_view_month.png\" border=\"0\">Articoli dell\'ordine' + registros);
        });
        function AddArticulo(){
            
            var cantidad = parseFloat($j('#cant').val()) || 0;
            var idArt = parseFloat($j('#art').val()) || 0;
            
            if (idArt < 1){
                alert('por favor seleccione un artículo');
            }
            if ( cantidad > 0){
                $j.ajax({
                        method: 'post', //post, get
                        dataType: 'html', //json,text,html
                        url:'./hooks/ordersDetails_AJX.php',
                        cache: 'false',
                        data: {  action: 'fastAdd',
                                     id: idArt, //id del articulo seleccionado
                                   cant: cantidad,
                                IDorder:"<?php echo addslashes($parameters['SelectedID']); ?>" //id del formulario
                              }
                    })
                    .done(function(msg){
                        //function at response
                        ActualizaValorTotal();
                    });
            }else{
                alert('the quantity is wrong');
            }
        }
        function deleteRegistro(IdChaild){
            if (!isNaN(IdChaild) || IdChaild > 0){
                
                $j.ajax({
                    method: 'post', //post, get
                    dataType: 'text', //json,text,html
                    url: './hooks/ordersDetails_AJX.php',
                    cache: 'false',
                    data: {action: 'fastDel', id: IdChaild, IDorder:"<?php echo addslashes($parameters['SelectedID']); ?>" }
                })
                        .done(function (msg) {
                            //function at response
                    ActualizaValorTotal();
                    <?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' });
                });
                
            }else{
                alert('Ups!, something is wrong...');
            }
            return;
        }
        function ActualizaValorTotal(){//only view
                    $j.ajax({
                        method: 'post', //post, get
                        dataType: 'html', //json,text,html
                        url:'./hooks/ordersDetails_AJX.php',
                        cache: 'false',
                        data: {  action: 'totOrder',
                            parameters: <?php echo json_encode($parameters); ?>, //parametros de la tabla
                                  id: 'LineTotal'
                              }
                    })
                    .done(function(msg){
                        setTimeout(function(){ 
                            //function at response
    //                        ActualizaValorTotal();
                            var sumRows = msg;
                            sumRows = parseFloat(sumRows).toFixed(2);
                            $j('#orderTotal').val(sumRows);
                            firstCashNoteOrderGetRecords({ Verb: 'reload' });
                        }, 1000);
                    });
                    
                    
            return;
        }
</script>

<div class="row">
	<div class="col-xs-11 col-md-12">
                <!--Code add by ale-->
                <?php if (!$_REQUEST['readonly']){ ?>
                    <div class="row">
                        <div class="col-lg-4">
                    <?php if($config['display-add-new']){ ?>
                            <?php if(stripos($_SERVER['HTTP_USER_AGENT'], 'msie ')){ ?>
                                    <a href="<?php echo $parameters['ChildTable']; ?>_view.php?filterer_<?php echo $parameters['ChildLookupField']; ?>=<?php echo urlencode($parameters['SelectedID']); ?>&addNew_x=1" target="_viewchild" class="btn btn-success hspacer-sm vspacer-md"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo html_attr($Translation['Add New']); ?></a>
                            <?php }else{ ?>
                                    <a href="#" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'new' }); return false;" class="btn btn-success hspacer-sm vspacer-md"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo html_attr($Translation['Add New']); ?></a>
                            <?php } ?>
                    <?php } ?>
                    <?php if($config['display-refresh']){ ?>
                        <a href="#" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); return false;" class="btn btn-default hspacer-sm vspacer-md">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <?php } ?>
                        </div>
                        <div class="col-lg-8">
                            <div class="col-md-8 hspacer-sm vspacer-md">
                                <span id="articulos_listado" ></span>
                                <input type="hidden" name="art" id="art" value="">
                            </div>
                            <div class="input-group col-lg-3 hspacer-sm vspacer-md">
                                <input class="form-control" type="text" name="cant" id="cant" value="1">
                                <span class="input-group-btn">
                                    <button title="Add selected product" onclick="AddArticulo();<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'reload' }); return false;" class="btn btn-info"><i class="glyphicon glyphicon-save"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--End Code add by ale-->
                <?php } ?>
                
		<div class="table-responsive">
			<table class="table table-striped table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<?php if($config['open-detail-view-on-click']){ ?>
							<th>&nbsp;tools</th>
						<?php } ?>
						<?php if(is_array($config['display-fields'])) {
                                                    foreach($config['display-fields'] as $fieldIndex => $fieldLabel){ ?>
							<th 
								<?php if($config['sortable-fields'][$fieldIndex]){ ?>
									onclick="<?php echo $current_table; ?>GetChildrenRecordsList({
										Verb: 'sort', 
										SortBy: <?php echo $fieldIndex; ?>, 
										SortDirection: '<?php echo ($parameters['SortBy'] == $fieldIndex && $parameters['SortDirection'] == 'asc' ? 'desc' : 'asc'); ?>'
									});" 
									style="cursor: pointer;" 
								<?php } ?>
								class="<?php echo "{$current_table}-{$config['display-field-names'][$fieldIndex]}"; ?>">
								<?php echo $fieldLabel; ?>
								<?php if($parameters['SortBy'] == $fieldIndex && $parameters['SortDirection'] == 'desc'){ ?>
									<i class="glyphicon glyphicon-sort-by-attributes-alt text-warning"></i>
								<?php }elseif($parameters['SortBy'] == $fieldIndex && $parameters['SortDirection'] == 'asc'){ ?>
									<i class="glyphicon glyphicon-sort-by-attributes text-warning"></i>
								<?php } ?>
							</th>
                                                <?php } 
                                                } ?>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($records)){ 
                                            foreach($records as $pkValue => $record){ ?>
					<tr>
						<?php if($config['open-detail-view-on-click'] && !$_REQUEST['readonly']){ ?>
							<?php if(stripos($_SERVER['HTTP_USER_AGENT'], 'msie ')){ ?>
								<td class="text-center view-on-click">
                                                                    <a href="<?php echo $parameters['ChildTable']; ?>_view.php?SelectedID=<?php echo urlencode($record[$config['child-primary-key-index']]); ?>" target="_viewchild" class="h6">
                                                                        <i class="fa fa-pencil hspacer-md"></i>
                                                                    </a>
                                                                </td>
							<?php }else{ ?>
								<td class="text-center view-on-click">
                                                                    <div class="row">
                                                                        <a href="#" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'open', ChildID: '<?php echo html_attr($record[$config['child-primary-key-index']]); ?>'}); return false;" class="h6" title="Edit Record">
                                                                            <i class="fa fa-pencil hspacer-md"></i>
                                                                        </a>
                                                                        <a href="#" onclick="deleteRegistro('<?php echo html_attr($record[$config['child-primary-key-index']]); ?>'); return false;" class="h6" title="Delete Record">
                                                                            <i class="fa fa-remove hspacer-md"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
							<?php } ?>
						<?php }else { ?>
                                                                <td class="text-center view-on-click"></td>
                                                    <?php } 
                                                    $stock = sqlvalue("SELECT stock FROM SQL_productsStock where code='{$record[7]}' LIMIT 1;");
                                                    $classes='lightcoral';
                                                    if($stock>0){
                                                        $classes='green';
                                                    }
                                                    elseif($stock==0){
                                                        $classes='gold';
                                                    }

                                                    ?>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][2]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][2]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[2]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][3]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][3]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[3]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][7]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][7]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[7]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][8]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][8]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[8]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][10]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][10]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[10]); ?></td>
						<td style="background-color: <?php echo $classes; ?>" class="text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][11]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($stock); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][13]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][13]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[13]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][14]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][14]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[14]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][15]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][15]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[15]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][16]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][16]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[16]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][17]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][17]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[17]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][18]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][18]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[18]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][19]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][19]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[19]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][20]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][20]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[20]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][22]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][22]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[22]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][23]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][23]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[23]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][24]}"; ?> text-right" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][24]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[24]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][25]}"; ?> text-center" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][25]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[25]); ?></td>
						<td class="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][26]}"; ?>" id="<?php echo "{$parameters['ChildTable']}-{$config['display-field-names'][26]}-" . html_attr($record[$config['child-primary-key-index']]); ?>"><?php echo safe_html($record[26]); ?></td>
					</tr>
					<!-- Code add by Ale -->

					<?php } 
                                        }
                                        
                                            //calcula el total
                                            $fieldToSUM = 'LineTotal';
                                            $tot = number_format(getTotOrder($parameters,$fieldToSUM),2);
                                            $sumRow ="<tr class=\"success\">";
                                            if(!isset($_REQUEST['Print_x'])) $sumRow.="<td class=\"text-center\"><H3><strong>&sum;</strong></H3></td>";
                                            if($config['open-detail-view-on-click']){
                                                $sumRow.="<td></td>";
                                                $sumRow.="<td></td>";
                                            }
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td id=\"sumRows\" class=\"text-right\"><H4><span>&euro;</span>{$tot}</H4></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="<td></td>";
                                            $sumRow.="</tr>";

                                            echo $sumRow;

                                        ?>
                                        <!-- End Code add by Ale -->
				</tbody>
				<tfoot>
					<tr>
						<td colspan="<?php echo (count($config['display-fields']) + ($config['open-detail-view-on-click'] ? 1 : 0)); ?>">
							<?php if($totalMatches){ ?>
								<?php if($config['show-page-progress']){ ?>
									<span style="margin: 10px;">
										<?php $firstRecord = ($parameters['Page'] - 1) * $config['records-per-page'] + 1; ?>
										<?php echo str_replace(array('<FirstRecord>', '<LastRecord>', '<RecordCount>'), array($firstRecord, $firstRecord + count($records) - 1, $totalMatches), $Translation['records x to y of z']); ?>
									</span>
								<?php } ?>
							<?php }else{ ?>
								<span class="text-danger" style="margin: 10px;"><?php echo $Translation['No matches found!']; ?></span>
							<?php } ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php if($totalMatches){ ?>
			<div class="row hidden-print">
				<div class="col-xs-12">
					<button type="button" class="btn btn-default" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'page', Page: 'previous' });"><i class="glyphicon glyphicon-chevron-left"></i></button>
					<button type="button" class="btn btn-default" onclick="<?php echo $current_table; ?>GetChildrenRecordsList({ Verb: 'page', Page: 'next' });"><i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-xs-1 md-hidden lg-hidden"></div>
</div>
<script>$j(function(){ /* */ $j('img[src^="thumbnail.php?i=&"').parent().hide(); });</script>
