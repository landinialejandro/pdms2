<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = '_ordersSummary';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			company: <?php echo json_encode(array('id' => $rdata['company'], 'value' => $rdata['company'], 'text' => $jdata['company'])); ?>,
			typedoc: <?php echo json_encode(array('id' => $rdata['typedoc'], 'value' => $rdata['typedoc'], 'text' => $jdata['typedoc'])); ?>,
			customer: <?php echo json_encode(array('id' => $rdata['customer'], 'value' => $rdata['customer'], 'text' => $jdata['customer'])); ?>,
			related: <?php echo json_encode(array('id' => $rdata['related'], 'value' => $rdata['related'], 'text' => $jdata['related'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for kind */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'kind' && d.id == data.kind.id)
				return { results: [ data.kind ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for company */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'company' && d.id == data.company.id)
				return { results: [ data.company ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for typedoc */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'typedoc' && d.id == data.typedoc.id)
				return { results: [ data.typedoc ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for customer */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'customer' && d.id == data.customer.id)
				return { results: [ data.customer ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for related */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'related' && d.id == data.related.id)
				return { results: [ data.related ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

