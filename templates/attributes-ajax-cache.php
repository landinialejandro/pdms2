<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'attributes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			attribute: <?php echo json_encode(array('id' => $rdata['attribute'], 'value' => $rdata['attribute'], 'text' => $jdata['attribute'])); ?>,
			contact: <?php echo json_encode(array('id' => $rdata['contact'], 'value' => $rdata['contact'], 'text' => $jdata['contact'])); ?>,
			company: <?php echo json_encode(array('id' => $rdata['company'], 'value' => $rdata['company'], 'text' => $jdata['company'])); ?>,
			product: <?php echo json_encode(array('id' => $rdata['product'], 'value' => $rdata['product'], 'text' => $jdata['product'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for attribute */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'attribute' && d.id == data.attribute.id)
				return { results: [ data.attribute ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for contact */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'contact' && d.id == data.contact.id)
				return { results: [ data.contact ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for company */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'company' && d.id == data.company.id)
				return { results: [ data.company ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for product */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'product' && d.id == data.product.id)
				return { results: [ data.product ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

