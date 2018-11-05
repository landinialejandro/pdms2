

$j(document).ready(function(){
    
    
})

function setCredit(id){
    
    $j.ajax({
        method: 'post', //post, get
        dataType: 'text', //json,text,html
        url: 'hooks/companies_AJAX.php',
        cache: 'false',
        data: {cmd: 'limit',id:id}
    })
            .done(function (msg) {
                var data = $j.parseJSON(msg);
                if (data.attr_id){
                    attributesCompaniesGetRecords({ Verb: 'open', ChildID: data.attr_id, select: true}); 
                }else{
                    attributesCompaniesGetRecords({ Verb: 'new', select: true }); 
                }
                return false;
            });
}
