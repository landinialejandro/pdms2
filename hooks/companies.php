<?php


	function companies_init(&$options, $memberInfo, &$args){
		/* Inserted by Search Page Maker for AppGini on 2018-09-26 02:07:33 */
		$options->FilterPage = 'hooks/companies_filter.php';
		/* End of Search Page Maker for AppGini code */
                if (isset($_REQUEST['ck'])){
                            $ck = makeSafe($_REQUEST['ck']);
                            addFilter(1, 'and', 2, 'Equal to', $ck);
                }

		return TRUE;
	}


	function companies_header($contentType, $memberInfo, &$args){
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


	function companies_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
                            
                            if (isset($_REQUEST['ck'])){
                                $title=makeSafe($_REQUEST['ck']);
                                echo title_tv($title,"?ck=".$title);
                            }
                            
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


	function companies_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function companies_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}


	function companies_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function companies_after_update($data, $memberInfo, &$args){

		return TRUE;
	}


	function companies_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function companies_after_delete($selectedID, $memberInfo, &$args){

	}


	function companies_dv($selectedID, $memberInfo, &$html, &$args){
            if (isset($_REQUEST['addNew_x'])){
                if (isset($_REQUEST['ck']) || (isset($_REQUEST['FilterValue']) && isset($_REQUEST['FilterField']))){
                    if (isset($_REQUEST['ok'])){
                       $ck_id = makeSafe($_REQUEST['ck']);
                       $ck_text = sqlValue("select name from kinds where code = '{$ck_id}'");
                    }
                    if (isset($_REQUEST['FilterValue'])){
                        $ck_text = makeSafe($_REQUEST['FilterValue'][1]);
                        $ck_id = sqlValue("select code from kinds where name = '{$ck_text}'");
                    }
                }
                ob_start();
                ?>
                    <!-- insert HTML code-->
                    <?php echo title_tv($ck_text,"?ck=$ck_text");?>
                    <script>
                     $j(function(){
                         setTimeout(function(){
                             $j('#s2id_kind-container').select2("data", {id: "<?php echo $ck_id; ?>", text: "<?php echo $ck_text; ?>"});
                             $j('#kind').val("<?php echo $ck_id; ?>");
                             orderNumber();
                         },1000);
                     })  
                    </script>
                <?php
                $html_code = ob_get_contents();
                ob_end_clean();
                $html= $html . $html_code;
            }

	}


	function companies_csv($query, $memberInfo, &$args){

		return $query;
	}

	function companies_batch_actions(&$args){

		return array();
	}
