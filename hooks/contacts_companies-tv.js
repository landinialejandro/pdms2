$j(document).ready(function(){
    setTimeout(function(){
        refreshCards();
    },1000);
});
function refreshCards(){
    $j('.contacts_companies-company').each(function(index){
        var elementId = this.id;
        if (elementId){
            showCardsTV('company','companyCard-'+elementId,'companyCard');
        }
    });
}