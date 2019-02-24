/* global $j */

$j(function(){
    setTimeout(function(){
        refreshCards();
    },1000);
});

function refreshCards(){
    $j('.contacts_companies-company').each(function(){
        var elementId = this.id;
        if (elementId){
            showCardsTV('company','companyCard-'+elementId,'companyCard');
        }
    });
    $j('.contacts_companies-contact').each(function(){
        var elementId = this.id;
        if (elementId){
            showCardsTV('contact','contactCard-'+elementId,'contactCard');
        }
    });
}