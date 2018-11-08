<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function _resumeOrders_init(&$options, $memberInfo, &$args){
                $options->Template = 'hooks/_resumeOrders_templateTV.html';
		return TRUE;
	}

	function _resumeOrders_header($contentType, $memberInfo, &$args){
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

	function _resumeOrders_footer($contentType, $memberInfo, &$args){
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

	function _resumeOrders_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function _resumeOrders_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}

	function _resumeOrders_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function _resumeOrders_after_update($data, $memberInfo, &$args){

		return TRUE;
	}

	function _resumeOrders_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}

	function _resumeOrders_after_delete($selectedID, $memberInfo, &$args){

	}

	function _resumeOrders_dv($selectedID, $memberInfo, &$html, &$args){

	}

	/**
	 * Called when a user requests to download table data as a CSV file (by clicking on the SAVE CSV button)
	 * 
	 * @param $query
	 * Contains the query that will be executed to return the data in the CSV file.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * A string containing the query to use for fetching the CSV data. If FALSE or empty is returned, the default query is used.
	*/

	function _resumeOrders_csv($query, $memberInfo, &$args){

		return $query;
	}
	function _resumeOrders_batch_actions(&$args){

		return array();
	}
