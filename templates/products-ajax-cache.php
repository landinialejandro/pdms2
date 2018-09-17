<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'products';

		/* data for selected record, or defaults if none is selected */
		var data = {
			tax: <?php echo json_encode(array('id' => $rdata['tax'], 'value' => $rdata['tax'], 'text' => $jdata['tax'])); ?>,
			CategoryID: <?php echo json_encode(array('id' => $rdata['CategoryID'], 'value' => $rdata['CategoryID'], 'text' => $jdata['CategoryID'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for tax */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'tax' && d.id == data.tax.id)
				return { results: [ data.tax ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for CategoryID */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'CategoryID' && d.id == data.CategoryID.id)
				return { results: [ data.CategoryID ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

