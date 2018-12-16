/* global $j, autoSet */


$j(document).ready(function(){
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
        },1000);
    }else{
        //new mode
        $j(".hidden-automatic").show();
        $j(".hidden-manual").hide();
    }
});

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