<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'town';

		/* data for selected record, or defaults if none is selected */
		var data = {
			country: <?php echo json_encode(array('id' => $rdata['country'], 'value' => $rdata['country'], 'text' => $jdata['country'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for country */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'country' && d.id == data.country.id)
				return { results: [ data.country ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

