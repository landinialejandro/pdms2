/* global $j, autoSet, AUTOMATICDV */

$j(function(){
    readOnlySlects();

    $auto = $j(".hidden-automatic");
    $manual = $j(".hidden-manual");

    if(!is_add_new()){
        //updating mode
        setTimeout(function(){
            var Data = $j('#order-container').select2("data");
            var id = parseInt(Data.id) || 0;
            if(!id){
                $auto.show();
                $manual.hide();
            }
            refreshCards();
        },800);
    }else{
        //new mode
        if (typeof AUTOMATICDV !== 'undefined' && AUTOMATICDV ){
            $auto.hide();
            $manual.show();
        }else{
            setTimeout(function(){$j('#s2id_order-container').select2('readonly',false);},1000)
            //manual add new
            $auto.show();
            $manual.hide();
        }
    }
    $j('#idBank-container').change(function(){
        showCard('idBank','idBankCompanyCard','companyCard');
    });
    $j('#order-container').change(function(){
        showCard('order','orderCard','ordersCard');
    });
    $j('#customer-container').change(function(){
        showCard('customer','customerCompanyCard','companyCard');
    });
    $j('#company-container').change(function(){
        showCard('company','myCompanyCard','companyCard');
    });
    
});

function readOnlySlects(){
    setTimeout(function(){
            $j('#s2id_order-container').select2('readonly',true);
            if(!is_add_new()){
                $j('#s2id_kind-container').select2('readonly',true);
            }
    },800)
}

function refreshCards(){
    showCard('idBank','idBankCompanyCard','companyCard');
    showCard('order','orderCard','ordersCard');
    showCard('company','myCompanyCard','companyCard');
    showCard('customer','customerCompanyCard','companyCard');
}