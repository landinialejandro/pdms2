<?php


	function orders_init(&$options, $memberInfo, &$args){
		/* Inserted by Search Page Maker for AppGini on 2018-09-26 02:07:33 */
		$options->FilterPage = 'hooks/orders_filter.php';
		/* End of Search Page Maker for AppGini code */

                 $options->TemplateDV = 'hooks/orders_templateDV.html';
//                 $options->TemplateDVP = 'hooks/orders_templateDVP.html';
                 
		return TRUE;
	}


	function orders_header($contentType, $memberInfo, &$args){
		$header='';

		switch($contentType){
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}


	function orders_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}


	function orders_before_insert(&$data, $memberInfo, &$args){
                //check if the oreder number is the last bofore insert
                if(!function_exists('getNextValue')){
                    include'orders_AJX.php';
                }
            
                $numOrder = getNextValue($data['typeDoc'],$data['company']);
                if (intval($numOrder) !== intval($data['multiOrder'])){
                    $data['multiOrder']=$numOrder;
                }
		return TRUE;
	}


	function orders_after_insert($data, $memberInfo, &$args){
                //chack if save in prima nota
//                if(!function_exists('addPrimaNota')){
//                    include'orders_AJX.php';
//                }
////                sql('UPDATE orders SET OrderTotal = "' . floatval(getTotdetails($data)) . '"',$eo);
//                if (isset($_POST['save'])){
//                    $save = $_POST['save'];
//                    if ($save === 'true'){
//                        //save in prima nota
//                        addPrimaNota($data,'open');
//                    }
//                }
		return TRUE;
	}


	function orders_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function orders_after_update($data, $memberInfo, &$args){
//                if(!function_exists('updatePrimaNota')){
//                    include'orders_AJX.php';
//                }
////                sql('UPDATE orders SET OrderTotal = "'.floatval(getTotdetails($data)).'" where OrderID = "'. $data['OrderID'] .'"',$eo);
//                // check if exist prima nota and update it.
//                $pn = sqlValue("select id from firstCashNote where OrderId = '{$data['OrderID']}'");
//                if($pn){
//                    updatePrimaNota($data, $pn);
//                }
		return TRUE;
	}


	function orders_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function orders_after_delete($selectedID, $memberInfo, &$args){

	}


	function orders_dv($selectedID, $memberInfo, &$html, &$args){
            //$("#e8").select2("data", {id: "CA", text: "California"});
            if (isset($_REQUEST['addNew_x']) && isset($_REQUEST['mc']) && isset($_REQUEST['ok']) && isset($_REQUEST['dk'])){
                   $mc_id = intval(makeSafe($_REQUEST['mc']));
                   $mc_name = sqlValue("select companyName from companies where id = {$mc_id}");
                   $mc_code = sqlValue("select companyCode from companies where id = {$mc_id}");
                   $mc_text = $mc_code . " - " . $mc_name;
                   $ok_id = makeSafe($_REQUEST['ok']);
                   $ok_name = sqlValue("select name from kinds where code = '{$ok_id}'");
                   $ok_text = $ok_name;
                   $dk_id = makeSafe($_REQUEST['dk']);
                   $dk_name = sqlValue("select name from kinds where code = '{$dk_id}'");
                   $dk_text = $dk_id . " - " . $dk_name;
                
                ob_start();
                ?>
                    <!-- insert HTML code-->
                    <script>
                     function autoSet(){
                         setTimeout(function(){
                             $j('#s2id_company-container').select2("data", {id: "<?php echo $mc_id; ?>", text: "<?php echo $mc_text; ?>"});
                             $j('#company').val("<?php echo $mc_id; ?>");
                             $j('#s2id_kind-container').select2("data", {id: "<?php echo $ok_id; ?>", text: "<?php echo $ok_text; ?>"});
                             $j('#kind').val("<?php echo $ok_id; ?>");
                             $j('#s2id_typeDoc-container').select2("data", {id: "<?php echo $dk_id; ?>", text: "<?php echo $dk_text; ?>"});
                             $j('#typeDoc').val("<?php echo $dk_id; ?>");
                             orderNumber();
                         },1000);
                     }  
                    </script>
                <?php
                $html_code = ob_get_contents();
                ob_end_clean();
                $html= $html . $html_code;
            }
	}


	function orders_csv($query, $memberInfo, &$args){

		return $query;
	}

	function orders_batch_actions(&$args){

		return array();
	}
