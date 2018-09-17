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
    if(!is_add_new()){
        setTimeout(function(){
            refreshCards();
        },1000);
    }
});

$j(function(){
    $j('#company-container').change(function(){
        showCard('company','myCompanyCard','companyCard');
    });
    $j('#customer-container').change(function(){
        showCard('customer','customerCompanyCard','companyCard');
    });
    $j('#shipVia-container').change(function(){
        showCard('shipVia','shipCompanyCard','companyCard');
    });
});

function refreshCards(){
    showCard('company','myCompanyCard','companyCard');
    showCard('customer','customerCompanyCard','companyCard');
    showCard('shipVia','shipCompanyCard','companyCard');
}
