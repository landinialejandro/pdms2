
/* global $j */

//
// 
// Author: Alejandro Landini <landinialejandro@gmail.com>
// _resumerOrders-tv 23 sep. 2018
// toDo: 
//          *
// revision:
//          *
//

$j(document).ready(function(){
	$j('td._resumeOrders-customer').each(function(){
	  if($j(this).children().text() === ""){
		$j(this).css('background','#eca1a6');
		$j(this).parent().addClass('danger');
	  }
        });
        $j('th').each(function(){
            $j(this).css('background','#b1cbbb');
        });
        $j("a[href='SQL_resumeOrders_view.php']").attr('href', '_resumeOrders_view.php');
});

$j(function(){
    $j('.btn-print-and-close').click(function(){
        var id = this.attributes.myid.value;
        window.open('REP_printResumeDocument.php?OrderID=' + id);
    });
});

