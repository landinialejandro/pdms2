/* global $j */

//
// 
// Author: Alejandro Landini <landinialejandro@gmail.com>
// ordersDetails-dv 12 sep. 2018
// toDo: 
//          *
// revision:
//          *
//

$j(document).ready(function(){
    $j('#multiOrder').attr('readonly','true');
    if(!is_add_new()){
        setTimeout(function(){
            refreshCards();
            appendPrintOrder();
        },1000);
    }
    if (typeof autoSet !== 'undefined'){
        autoSet();//is a function from server-side
    }
    setTimeout(function(){
        validateKind();
    },1100);
});

$j(function(){
    $j('#company-container').change(function(){
        showCard('company','myCompanyCard','companyCard');
        orderNumber();
    });
    $j('#customer-container').change(function(){
        showCard('customer','customerCompanyCard','companyCard');
    });
    $j('#shipVia-container').change(function(){
        showCard('shipVia','shipCompanyCard','companyCard');
    });
    $j('#typeDoc-container').change(function(){
        orderNumber();
    });
    $j('#kind-container').change(function(){
        validateKind();
    });
});

function validateKind(){
    var k = $j('#kind-container').select2("data");
    if (k.id === 'IN'){
        $j('#multiOrder').removeAttr('readonly');
        $j('#kind-container').select2("readonly",true);
    $j('#kind-container').select2("readonly",true);
    }else if (k.id === 'OUT') {
        $j('#multiOrder').attr('readonly','true');
        $j('#kind-container').select2("readonly",true);
        orderNumber();
    }
}

function refreshCards(){
    $j('#company-container').select2("readonly",true);
    $j('#typeDoc-container').select2("readonly",true);
    $j('#kind-container').select2("readonly",true);
    showCard('company','myCompanyCard','companyCard');
    showCard('customer','customerCompanyCard','companyCard');
    showCard('shipVia','shipCompanyCard','companyCard');
}

function orderNumber(){
    if (!is_add_new()) return;
    var c = $j('#company-container').select2("data");
    var c = parseInt(c.id);
    var d = $j('#typeDoc-container').select2("data");
    if ( c> 0 && d.id.length > 1 ){
        $j.ajax({
            method: 'post', //post, get
            dataType: 'text', //json,text,html
            url: 'hooks/orders_AJX.php',
            cache: 'false',
            data: {cmd: 'nextOrder',c:c,d:d.id}
        })
                .done(function (msg) {
                    //function at response
                    var order = parseInt(msg) || 0;
                    $j('#multiOrder').val(parseInt(order));
                });
    }
//    return on;
}

function appendPrintOrder(){
    $j('#orders_dv_action_buttons .btn-toolbar').append(
            '<p></p><div class="btn-group-vertical" style="width: 100%;">' +
                    '<button type="button" class="btn btn-default" onclick="print_order()">' +
                            '<i class="glyphicon glyphicon-print"></i> Print Order</button>' +
            '</div>'
    );
};

function print_order(){
        var selectedID = parseInt($j('#id').text());
        if (selectedID > 0){
            var windowName = "popUp";//$(this).attr("name");
            window.open('REP_printDocument.php?OrderID=' + selectedID, windowName);
    //				window.location = 'REP_printDocument.php?OrderID=' + selectedID;
        }
        setTimeout(function(){
            location.reload();
        },1000);
}
