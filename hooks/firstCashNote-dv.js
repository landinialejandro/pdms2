/* global $j, autoSet */


$j(document).ready(function(){
    if(!is_add_new()){
        setTimeout(function(){
            refreshCards();
        },1000);
    }
});

$j(function(){
    $j('#idBank-container').change(function(){
        showCard('idBank','idBankCompanyCard','companyCard');
    });
    $j('#order-container').change(function(){
        showCard('order','orderCard','ordersCard');
    });
    
});

function refreshCards(){
    showCard('idBank','idBankCompanyCard','companyCard');
    showCard('order','orderCard','ordersCard');
}