/* global $j */


function setLimit(id,button){
    var code = button.id;
    
    $j.ajax({
        method: 'post', //post, get
        dataType: 'text', //json,text,html
        url: 'hooks/companies_AJAX.php',
        cache: 'false',
        data: {cmd: 'limit',id:id, code:code}
    })
            .done(function (msg) {
                var data = $j.parseJSON(msg);
                if (data.attr_id){
                    //children-attributes.php
                    attributesCompanyGetRecords({ Verb: 'open', ChildID: data.attr_id, select: true}); 
                }else{
                    attributesCompanyGetRecords({ Verb: 'new', select: true, code:code }); 
                }
                return false;
            });
}

