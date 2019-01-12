<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'addresses';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			country: <?php echo json_encode(array('id' => $rdata['country'], 'value' => $rdata['country'], 'text' => $jdata['country'])); ?>,
			country_name: <?php echo json_encode($jdata['country_name']); ?>,
			town: <?php echo json_encode(array('id' => $rdata['town'], 'value' => $rdata['town'], 'text' => $jdata['town'])); ?>,
			postalCode: <?php echo json_encode($jdata['postalCode']); ?>,
			district: <?php echo json_encode($jdata['district']); ?>,
			contact: <?php echo json_encode(array('id' => $rdata['contact'], 'value' => $rdata['contact'], 'text' => $jdata['contact'])); ?>,
			company: <?php echo json_encode(array('id' => $rdata['company'], 'value' => $rdata['company'], 'text' => $jdata['company'])); ?>
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

		/* saved value for country */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'country' && d.id == data.country.id)
				return { results: [ data.country ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for country autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'country' && d.id == data.country.id){
				$j('#country_name' + d[rnd]).html(data.country_name);
				return true;
			}

			return false;
		});

		/* saved value for town */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'town' && d.id == data.town.id)
				return { results: [ data.town ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for town autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'town' && d.id == data.town.id){
				$j('#postalCode' + d[rnd]).html(data.postalCode);
				$j('#district' + d[rnd]).html(data.district);
				return true;
			}

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

		cache.start();
	});
</script>

