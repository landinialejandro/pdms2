/* global $j, autoSet, AUTOMATICDV */


$j(document).ready(function(){
    readOnlySlects();
    if(!is_add_new()){
        //updating mode
        setTimeout(function(){
            var Data = $j('#order-container').select2("data");
            var id = parseInt(Data.id) || 0;
            if(!id){
                $j(".hidden-automatic").show();
                $j(".hidden-manual").hide();
            }
            refreshCards();
        },800);
    }else{
        //new mode
        if (typeof AUTOMATICDV !== 'undefined' && AUTOMATICDV ){
            $j(".hidden-automatic").hide();
            $j(".hidden-manual").show();
        }else{
            setTimeout(function(){$j('#s2id_order-container').select2('readonly',false);},1000)
            //manual add new
            $j(".hidden-automatic").show();
            $j(".hidden-manual").hide();
        }
    }
});

function readOnlySlects(){
    setTimeout(function(){
            $j('#s2id_order-container').select2('readonly',true);
            if(!is_add_new()){
                $j('#s2id_kind-container').select2('readonly',true);
            }
    },800)
}


$j(function(){
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

function refreshCards(){
    showCard('idBank','idBankCompanyCard','companyCard');
    showCard('order','orderCard','ordersCard');
    showCard('company','myCompanyCard','companyCard');
    showCard('customer','customerCompanyCard','companyCard');
}