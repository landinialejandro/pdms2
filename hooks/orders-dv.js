/* global $j, autoSet */

//
// 
// Author: Alejandro Landini <landinialejandro@gmail.com>
// ordersDetails-dv 12 sep. 2018
// toDo: 
//          *
// revision:
//          *
//

$j(function(){
    hiddeFields()
    $j('#multiOrder').attr('readonly','true');
    if(!is_add_new()){
        setTimeout(function(){
            refreshCards();
            changueTitle();
            commisionRate();
            $j('.print_order').show();
            if ($j('#typeDoc').val() === "TD01"){
                $j('.sdi_group').show();
            }
        },1000);
    }
    if (typeof autoSet !== 'undefined'){
        autoSet();//is a function from server-side
    }
    setTimeout(function(){
        validateKind();
        orderNumber();
    },1100);
    addWarningBtn('commisionRate');
    addWarningBtn('commisionFee');
    $j('#company-container').change(function(){
        showCard('company','myCompanyCard','companyCard');
        orderNumber();
        commisionRate();
    });
    $j('#customer-container').change(function(){
        showCard('customer','customerCompanyCard','companyCard');
    });
    $j('#supplier-container').change(function(){
        showCard('supplier','supplierCompanyCard','companyCard');
    });
    $j('#shipVia-container').change(function(){
        showCard('shipVia','shipCompanyCard','companyCard');
    });
    $j('#typeDoc-container').change(function(){
        orderNumber();
    });
    $j('#commisionRate').change(function(){
        commisionRate();
    });
    $j('#commisionFee').change(function(){
        calcCommision();
    });
    $j('#kind-container').change(function(){
        validateKind();
        orderNumber();
        changueTitle();
    });
    $j( "body" ).on( "click", ".btn-fix",function(){
        var field = this.attributes.myfield.value;
        if (field === 'commisionRate'){
            commisionRate(true);
        };
        if (field === 'commisionFee'){
            calcCommision(true);
        };
        ToggleFix(field);
    });
});

function hiddeFields (){
    $j("#commisionRate").parent().parent().hide()
    $j("#commisionFee").parent().parent().hide()
    $j('.sdi_group').hide();
    $j('.print_order').hide();
}

function commisionRate(fix = false){
    var Data = $j('#company-container').select2("data");
    var id = parseInt(Data.id) || 0;
    $j.ajax({
        method: 'post', //post, get
        dataType: 'json', //json,text,html
        url: 'hooks/companies_AJAX.php',
        cache: 'false',
        data: {cmd: 'commision',id:id}
    })
            .done(function (msg) {
                //function at response
                if (!msg) return;
                var rate=parseFloat(msg.value).toFixed(2) || 0;
                var actualRate = parseFloat($j('#commisionRate').val()).toFixed(2) || 0;
                
                if (actualRate !== rate && actualRate >0 && !fix){
                    ToggleFix('commisionRate','warning');
                    calcCommision();
                    return;
                }
                if (rate >0){
                    $j('#commisionRate').val(rate);
                    calcCommision(true);
                }else{
                    alert('Default rate value is undefined in selected company')
                }
                return rate;
            });
}

function calcCommision(fix = false){
    var rate = parseFloat($j('#commisionRate').val())|| 0;
    var orderTotal = parseFloat($j('#orderTotal').val())|| 0;
    var actualCommision = parseFloat($j('#commisionFee').val()) || 0;
    var commision = parseFloat(orderTotal * (rate /100)) || 0 ;
    if(actualCommision !== commision && actualCommision >0 && !fix){
        ToggleFix('commisionFee','warning');
        return;
    }
    $j('#commisionFee').val(parseFloat(commision).toFixed(2) ||0);
    return ;
}

function changueTitle(){
    var id = getKindID();
    if (typeof id !== 'undefined'){
        var icon = (id === 'IN' ? 'resources/table_icons/cart_put.png' : 'resources/table_icons/cart_remove.png');
        var text = $j('.page-header a').html() +` - ${getKindtext()} `;
        var href = $j('.page-header a').attr("href")+"?ok="+id;
        $j('.page-header a').html(text);
        $j('.page-header a').attr("href",href);
        $j('.page-header a img').attr("src",icon);
    }
}

function getKindID(){
    var kind = $j('#kind-container').select2("data");
    return kind.id;
}
function getKindtext(){
    var kind = $j('#kind-container').select2("data");
    return kind.text;
}

function validateKind(){
    var ret=true;
    var k = getKindID();
    $j('.kind-'+ k).show();
    if (k === 'IN'){
        $j('#multiOrder').removeAttr('readonly');
        $j('#kind-container').select2("readonly",true);
        $j('#supplier-container').select2("readonly",false);
        $j('label[for="customer"]').parent().hide();
    }else if (k === 'OUT') {
        $j('#multiOrder').attr('readonly','true');
        $j('#kind-container').select2("readonly",true);
        $j('label[for="supplier"]').parent().hide();
        ret=false;
    }
    return ret;
}

function refreshCards(){
    $j('#company-container').select2("readonly",true);
    $j('#typeDoc-container').select2("readonly",true);
    $j('#kind-container').select2("readonly",true);
//    $j('#supplier-container').select2("readonly",true);
    showCard('company','myCompanyCard','companyCard');
    showCard('customer','customerCompanyCard','companyCard');
    showCard('shipVia','shipCompanyCard','companyCard');
    showCard('supplier','supplierCompanyCard','companyCard');
}

function orderNumber(){
    if (!is_add_new()) return; //reutrn if in update record
    if (validateKind()) return; //return if kind is IN
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
}

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
