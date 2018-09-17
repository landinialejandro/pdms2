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
			companies: <?php echo json_encode(array('id' => $rdata['companies'], 'value' => $rdata['companies'], 'text' => $jdata['companies'])); ?>,
			products: <?php echo json_encode(array('id' => $rdata['products'], 'value' => $rdata['products'], 'text' => $jdata['products'])); ?>
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

		/* saved value for companies */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'companies' && d.id == data.companies.id)
				return { results: [ data.companies ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for products */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'products' && d.id == data.products.id)
				return { results: [ data.products ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

