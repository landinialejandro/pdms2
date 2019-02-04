/* global $j */

$j(function(){
    setTimeout(function(){
        if (typeof PARENTDV !== 'undefined'){
            $j('.hide-'+PARENTDV).hide();
        }
    },100);
});
