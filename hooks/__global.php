<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function login_ok($memberInfo, &$args){
        updateSqlViews();
		return '';
	}

	function login_failed($attempt, &$args){

	}

	function member_activity($memberInfo, $activity, &$args){
		switch($activity){
			case 'pending':
				break;

			case 'automatic':
				break;

			case 'profile':
				break;

			case 'password':
				break;

		}
	}

	function sendmail_handler(&$pm){

	}

        function title_tv($title,$href=""){
            $html_code ="";
            if ($title){
                ob_start();
                ?>
                    <!-- insert HTML code-->
                    <script>
                     $j(function(){
                         setTimeout(function(){
                            var text = $j('.page-header a').html() + " - <?php echo $title;?>";
                            var href = $j('.page-header a').attr("href") + "<?php echo $href;?>";
                            $j('.page-header a').html(text);
                            $j('.page-header a').attr("href",href);
                         },100);
                     })
                    </script>
                <?php
                $html_code = ob_get_contents();
                ob_end_clean();
            }
            return $html_code;
        }
