/* global $j */

// 
// Author: Alejandro Landini
// /srv/www/htdocs/pdms/hooks/products-dv.js 10/8/18
//      product dv
// toDo: 
// revision:
// 
var MANUAL_UPDATE = false;
var INCLUDE_TAX = false; // change to TRUE if tax include in sell price
var FIRST_TIME = true;

$j(document).ready(function(){
    $j('#id').parent().parent().hide();
    addWarningBtn('sellPrice');
});

function SaleVal(){
    var cost = parseFloat($j('#UnitPrice').val()).toFixed(2);
    var increment = parseFloat($j('#increment').val()).toFixed(2) || 0;
    var sell = cost / (1-(increment/100));
    
    var tax = 0;
    if (INCLUDE_TAX){
        var code = $j('#tax-container').select2('data');
        code = code.id;
        $j.ajax({
            method: 'post', //post, get
            dataType: 'text', //json,text,html
            url: 'hooks/kinds_AJX.php',
            cache: 'false',
            data: {id: code, cmd: 'getValue'}
        })
                .done(function (msg) {
                    //function at response
                    tax = parseFloat(msg);
                    tax = (sell * tax)/100;
                    sell = sell + tax;
                    return sell.toFixed(2);
                });
                
        tax = parseInt($j('#tax_value').text()).toFixed(2) || 0;
    }
    return sell.toFixed(2);
};

$j(function(){
    $j('#update, #insert').click(function(){
        var sell = parseFloat($j('#sellPrice').val()).toFixed(2) || 0;
        if (sell !== SaleVal() && sell >0){
            if (!MANUAL_UPDATE){
                msg= "c'é un valore diverso al calcolato <br>calcolo = " + SaleVal() +"<br>valore actuale = " + sell + "<br>make click again in Save Changes to acept this value or click in waring button for fix the value" ;
                show_warning('sellPrice', 'Prezzo Vendita', msg);
                ToggleFix ('sellPrice', 'warning');
                MANUAL_UPDATE = true;
                $j('#update, #insert').toggleClass('btn-warning')
                return false;
            }else{
                return true;
            }
        }
        changeSaleValue();
    });
    $j( "body" ).on( "click", ".btn-fix",function(){
        var field = this.attributes.myfield.value;
        if (field === 'sellPrice'){
            var newValue= SaleVal();
        };
        $j('#'+field).val(newValue);
        ToggleFix(field);
    });
    $j('#increment, #UnitPrice').change(function(){
        FIRST_TIME = false;
        changeSaleValue();
    });
    $j('#sellPrice').change(function(){
        var sell = parseFloat($j('#sellPrice').val()).toFixed(2) || 0;
        if (sell !== SaleVal() && sell >0){
                ToggleFix ('sellPrice', 'warning');
            }
    });
    $j("body").on('DOMSubtreeModified', "#tax_value", function() {
        if (!FIRST_TIME){
            changeSaleValue();
        }
        FIRST_TIME = false;
    });
});

function changeSaleValue(){
    $j('#sellPrice').val(SaleVal());
};