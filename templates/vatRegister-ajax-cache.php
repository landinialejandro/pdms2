<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'vatRegister';

		/* data for selected record, or defaults if none is selected */
		var data = {
			idCompany: <?php echo json_encode(array('id' => $rdata['idCompany'], 'value' => $rdata['idCompany'], 'text' => $jdata['idCompany'])); ?>,
			companyName: <?php echo json_encode($jdata['companyName']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for idCompany */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'idCompany' && d.id == data.idCompany.id)
				return { results: [ data.idCompany ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for idCompany autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'idCompany' && d.id == data.idCompany.id){
				$j('#companyName' + d[rnd]).html(data.companyName);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

