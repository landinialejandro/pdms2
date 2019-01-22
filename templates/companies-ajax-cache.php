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
			kind_code: <?php echo json_encode($jdata['kind_code']); ?>,
			codiceDestinatario: <?php echo json_encode(array('id' => $rdata['codiceDestinatario'], 'value' => $rdata['codiceDestinatario'], 'text' => $jdata['codiceDestinatario'])); ?>,
			regimeFiscale: <?php echo json_encode(array('id' => $rdata['regimeFiscale'], 'value' => $rdata['regimeFiscale'], 'text' => $jdata['regimeFiscale'])); ?>,
			tipoCassa: <?php echo json_encode(array('id' => $rdata['tipoCassa'], 'value' => $rdata['tipoCassa'], 'text' => $jdata['tipoCassa'])); ?>,
			modalitaPagamento: <?php echo json_encode(array('id' => $rdata['modalitaPagamento'], 'value' => $rdata['modalitaPagamento'], 'text' => $jdata['modalitaPagamento'])); ?>
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

		/* saved value for kind autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'kind' && d.id == data.kind.id){
				$j('#kind_code' + d[rnd]).html(data.kind_code);
				return true;
			}

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

		/* saved value for modalitaPagamento */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'modalitaPagamento' && d.id == data.modalitaPagamento.id)
				return { results: [ data.modalitaPagamento ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

