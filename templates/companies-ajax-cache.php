<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'companies';

		/* data for selected record, or defaults if none is selected */
		var data = {
			kind: <?php echo json_encode(array('id' => $rdata['kind'], 'value' => $rdata['kind'], 'text' => $jdata['kind'])); ?>,
			codiceDestinatario: <?php echo json_encode(array('id' => $rdata['codiceDestinatario'], 'value' => $rdata['codiceDestinatario'], 'text' => $jdata['codiceDestinatario'])); ?>,
			regimeFiscale: <?php echo json_encode(array('id' => $rdata['regimeFiscale'], 'value' => $rdata['regimeFiscale'], 'text' => $jdata['regimeFiscale'])); ?>,
			tipoCassa: <?php echo json_encode(array('id' => $rdata['tipoCassa'], 'value' => $rdata['tipoCassa'], 'text' => $jdata['tipoCassa'])); ?>
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

		/* saved value for codiceDestinatario */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'codiceDestinatario' && d.id == data.codiceDestinatario.id)
				return { results: [ data.codiceDestinatario ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for regimeFiscale */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'regimeFiscale' && d.id == data.regimeFiscale.id)
				return { results: [ data.regimeFiscale ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for tipoCassa */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'tipoCassa' && d.id == data.tipoCassa.id)
				return { results: [ data.tipoCassa ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

