<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'firstCashNote';

		/* data for selected record, or defaults if none is selected */
		var data = {
			order: <?php echo json_encode(array('id' => $rdata['order'], 'value' => $rdata['order'], 'text' => $jdata['order'])); ?>,
			idBank: <?php echo json_encode(array('id' => $rdata['idBank'], 'value' => $rdata['idBank'], 'text' => $jdata['idBank'])); ?>,
			bank: <?php echo json_encode($jdata['bank']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for order */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'order' && d.id == data.order.id)
				return { results: [ data.order ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idBank */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idBank' && d.id == data.idBank.id)
				return { results: [ data.idBank ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idBank autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'idBank' && d.id == data.idBank.id){
				$j('#bank' + d[rnd]).html(data.bank);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

