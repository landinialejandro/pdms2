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
var TAXVALUE;
$j(document).ready(function(){
    if(!is_add_new()){
        setTimeout(function(){
            refreshCards();
        },1000);
    }
    addWarningBtn('UnitPrice','The sell price from product is distinct, click me to fix. Or check producto sell Price.');
});

function calc(){
    changeSubtotal();
    changeImposta();
    ChangeLineTotal();
}

$j(function(){
    $j('#productCode-container').change(function(){
        refreshCards();
    });
    $j( "body" ).on( "click", ".btn-fix",function(){
        var field = this.attributes.myfield.value;
        if (field === 'UnitPrice'){
            var newValue= '';
        };
        $j('#'+field).val(newValue);
        ToggleFix(field);
        getSellPrice();
    });
    $j('#UnitPriceUsed, #Quantity, #Discount').change(function(){
        getSellPrice();
    });
    $j('#update, #insert').click(function(){
        calc();
    });
});

function getSellPrice(){
    //from product table
    field='productCode';
    file='productCard';
    cmd ='sellPrice';
    
    var Data = $j('#' + field + '-container').select2("data");
    var id = parseInt(Data.id);
    $j.ajax({
        method: 'post', //post, get
        dataType: 'text', //json,text,html
        url: 'hooks/' + file + '.php',
        cache: 'false',
        data: {id: id, cmd: cmd}
    })
            .done(function (msg) {
                //function at response
                checkUnitPrice(msg);
                calc();
            });
}
function getTaxValue(){
    //from product table
    field='productCode';
    file='productCard';
    cmd ='tax';
    
    var Data = $j('#' + field + '-container').select2("data");
    var id = parseInt(Data.id);
    $j.ajax({
        method: 'post', //post, get
        dataType: 'text', //json,text,html
        url: 'hooks/' + file + '.php',
        cache: 'false',
        data: {id: id, cmd: cmd}
    })
            .done(function (msg) {
                //function at response
                TAXVALUE=msg;
                calc();
            });
}

function checkUnitPrice(up){
    //up from product
    var unitPrice = parseFloat($j('#UnitPrice').val()) || 0;
    up = parseFloat(up) || 0;
    if (unitPrice !== up){
        if (unitPrice === 0){
                $j('#UnitPrice').val(up.toFixed(2));
        }
        else{
            ToggleFix ('UnitPrice', 'warning');
        }
    }
    else{
        if (up === 0){
            ToggleFix ('UnitPrice', 'danger');
        }
    }
}

function refreshCards(){
    showCard('productCode','productCard','productCard');
    getSellPrice();
    getTaxValue();
    
}

function changeSubtotal(){
    var actualPrice = parseFloat($j('#UnitPrice').val()) || 0;
    actualPrice = actualPrice.toFixed(2);
    
    var quantity = parseFloat($j('#Quantity').val()) || 0;
    quantity = quantity.toFixed(2);

    subTotal = actualPrice * quantity;
    $j('#Subtotal').val(subTotal.toFixed(2));

    return subTotal;
}

function taxValue(){
    return TAXVALUE;
}

function changeImposta(){
    var imposta = parseFloat(changeSubtotal() * taxValue()/100) || 0;
    $j('#Subtotal').val(imposta.toFixed(2));
    return imposta;
}

function ChangeLineTotal(){
    var discount = discountValue()/100;
    discount = changeSubtotal() * discount;
    var tot = parseFloat(changeSubtotal()+changeImposta()-discount) || 0;
    $j('#LineTotal').val(tot.toFixed(2));
}

function discountValue(){
    var discount = parseFloat($j('#Discount').val()) || 0;
    return discount;
}
