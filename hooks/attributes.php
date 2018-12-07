<?php


	function attributes_init(&$options, $memberInfo, &$args){

		return TRUE;
	}


	function attributes_header($contentType, $memberInfo, &$args){
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


	function attributes_footer($contentType, $memberInfo, &$args){
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


	function attributes_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function attributes_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}


	function attributes_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}


	function attributes_after_update($data, $memberInfo, &$args){

		return TRUE;
	}


	function attributes_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}


	function attributes_after_delete($selectedID, $memberInfo, &$args){

	}


	function attributes_dv($selectedID, $memberInfo, &$html, &$args){
            if (isset($_REQUEST['addNew_x'])){
                if (isset($_REQUEST['ak'])){
                    $_id = makeSafe($_REQUEST['ak']);
                    $_text = sqlValue("select name from kinds where code = '{$_id}'");    
                    ob_start();
                    ?>
                        <!-- insert HTML code-->
                        <script>
                         $j(function(){
                             setTimeout(function(){
                                 $j('#s2id_attribute-container').select2("data", {id: "<?php echo $_id; ?>", text: "<?php echo $_text; ?>"});
                                 $j('#s2id_attribute-container').select2('readonly',true);
                                 $j('#attribute').val("<?php echo $_id; ?>");
                             },500);
                         })  
                        </script>
                    <?php
                    $html_code = ob_get_contents();
                    ob_end_clean();
                    $html= $html . $html_code;
                }
            }
	}


	function attributes_csv($query, $memberInfo, &$args){

		return $query;
	}

	function attributes_batch_actions(&$args){

		return array();
	}
