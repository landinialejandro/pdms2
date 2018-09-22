
/* global $j */

//
// 
// Author: Alejandro Landini <landinialejandro@gmail.com>
// products-tv 21 sep. 2018
// toDo: 
//          *
// revision:
//          *
//
$j(document).ready(function(){
	$j('td.products-Discontinued').each(function(){
	  if($j(this).children().children().hasClass('glyphicon-check')){
		$j(this).parent().addClass('danger');
	  }
        });
        $j('td.products-expiry_date').each(function(){
            var st = $j(this).text();
            if (st.length > 0){
                var pattern = /(\d{2})\/(\d{2})\/(\d{4})/;
                var dt = new Date(st.replace(pattern,'$3-$2-$1'));
                $j(this).text((jQuery.timeago(dt)));
            }
        });
});



