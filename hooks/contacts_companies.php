<?php

	function contacts_companies_init(&$options, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_companies_header($contentType, $memberInfo, &$args){
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


	function contacts_companies_footer($contentType, $memberInfo, &$args){
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

	function contacts_companies_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_companies_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_companies_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_companies_after_update($data, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_companies_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function contacts_companies_after_delete($selectedID, $memberInfo, &$args){

	}


	function contacts_companies_dv($selectedID, $memberInfo, &$html, &$args){
                    if (isset($_REQUEST['Parent'])){
                        echo '<script> var PARENTDV = "'.$_REQUEST['Parent'].'"; </script>';
                    }
	}


	function contacts_companies_csv($query, $memberInfo, &$args){

		return $query;
	}

	function contacts_companies_batch_actions(&$args){

		return array();
	}
