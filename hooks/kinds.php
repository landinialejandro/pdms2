<?php

	function kinds_init(&$options, $memberInfo, &$args){
		/* Inserted by Search Page Maker for AppGini on 2018-09-26 02:07:33 */
		$options->FilterPage = 'hooks/kinds_filter.php';
		/* End of Search Page Maker for AppGini code */
		if (isset($_REQUEST['e'])){
			$ok = makeSafe($_REQUEST['e']);
			addFilter(1, 'and', 1, 'like', $ok);
		}

		return TRUE;
	}


	function kinds_header($contentType, $memberInfo, &$args){
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


	function kinds_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
                                $footer = (include 'kinds_filter_tv.php');
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


	function kinds_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function kinds_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}


	function kinds_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function kinds_after_update($data, $memberInfo, &$args){

		return TRUE;
	}


	function kinds_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function kinds_after_delete($selectedID, $memberInfo, &$args){

	}


	function kinds_dv($selectedID, $memberInfo, &$html, &$args){

	}


	function kinds_csv($query, $memberInfo, &$args){

		return $query;
	}

	function kinds_batch_actions(&$args){

		return array();
	}
