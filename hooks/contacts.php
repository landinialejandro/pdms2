<?php


	function contacts_init(&$options, $memberInfo, &$args){
		/* Inserted by Search Page Maker for AppGini on 2018-09-26 02:07:33 */
		$options->FilterPage = 'hooks/contacts_filter.php';
		/* End of Search Page Maker for AppGini code */

		return TRUE;
	}


	function contacts_header($contentType, $memberInfo, &$args){
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


	function contacts_footer($contentType, $memberInfo, &$args){
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


	function contacts_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_after_insert($data, $memberInfo, &$args){
            if (isset($_REQUEST['c']) && $_REQUEST['c']){
                //ver si llego con el request....vincular el contacto con la compañìa
                $insert = sql("INSERT INTO `contacts_companies`( `contact`, `company`, `default`) VALUES ('{$data['id']}','{$_REQUEST['c']}','1')",$e);
                header("Location:companies_view.php?SelectedID={$_REQUEST['c']}");
                
            }
            
		return TRUE;
	}


	function contacts_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_after_update($data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_after_delete($selectedID, $memberInfo, &$args){

	}


	function contacts_dv($selectedID, $memberInfo, &$html, &$args){
            if (isset($_REQUEST['addNew_x']) && isset($_REQUEST['c'] )){
                if ($_REQUEST['c']){
                    $html  .=  '<input type="text" hidden ="" name="c" value="' . $_REQUEST['c'] . '" /> ';
                        // add actions buttons
                    if(!function_exists('mkbuttons')){
                            include'_mkbuttons.php';
                        }
                    $buttons = [];

                    $buttons['back']['company']['name'] = 'Back to company';
                    $buttons['back']['company']['insert'] = false;
                    $buttons['back']['company']['update'] = true;
                    $buttons['back']['company']['style'] = 'info';
                    $buttons['back']['company']['icon'] = 'fa fa-arrows-h';
                    $buttons['back']['company']['onclick'] = 'script|location.href = "companies_view.php?SelectedID={' . $_REQUEST['c'] . '";';
                    $buttons['back']['company']['confirm'] = '';
                    
                    $html .= mkbuttons('companies', $selectedID, $buttons);
                }
            }
	}


	function contacts_csv($query, $memberInfo, &$args){

		return $query;
	}

	function contacts_batch_actions(&$args){

		return array();
	}
