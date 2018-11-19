<?php


	function ordersDetails_init(&$options, $memberInfo, &$args){
                $options->TemplateDV = 'hooks/ordersDetails_templateDV.html';

		return TRUE;
	}


	function ordersDetails_header($contentType, $memberInfo, &$args){
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


	function ordersDetails_footer($contentType, $memberInfo, &$args){
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


	function ordersDetails_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function ordersDetails_after_insert($data, $memberInfo, &$args){
                // get tot to order
                if(!function_exists('setTotalOrder')){
                    include'ordersDetails_AJX.php';
                }
                setTotalOrder($data['order']);
            
		return TRUE;
	}


	function ordersDetails_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function ordersDetails_after_update($data, $memberInfo, &$args){
                // set tot to order 
                if(!function_exists('setTotalOrder')){
                    include'ordersDetails_AJX.php';
                }
                setTotalOrder($data['order']);

		return TRUE;
	}


	function ordersDetails_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function ordersDetails_after_delete($selectedID, $memberInfo, &$args){

	}


	function ordersDetails_dv($selectedID, $memberInfo, &$html, &$args){

	}


	function ordersDetails_csv($query, $memberInfo, &$args){

		return $query;
	}

	function ordersDetails_batch_actions(&$args){

		return array();
	}
