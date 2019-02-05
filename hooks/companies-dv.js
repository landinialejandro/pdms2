/* global $j */

$j(function(){
    getContactId( $j('input[name=personaFisica]:checked', 'form').val() );
});

$j('form input[name=personaFisica]').on('change', function() {
    var view = $j('input[name=personaFisica]:checked', 'form').val(); 
    getContactId( view );
});

function getContactId( view = 'No' ){
    if (is_add_new()){
        return;
    }
    console.log(view);
    var id = $j('input[name=SelectedID]').val();
    if (view === "Si"){
        //bucar la persona default, si no abrir una y cargar
        $j.ajax({
            method: 'post',
            dataType: 'json',
            url: 'hooks/contacts_companies_AJAX.php',
            cache: 'false',
            data: {cmd: 'record',id:id}
        }).done(function ( msg ) {
            if ( msg ){
                //get contact data
                var contactId = msg.contact;
                console.log(contactId);
                getContact(contactId);
            }
        });
    }else{
        //ocultar la vista
    }
};

function getContact(id){
    $j.ajax({
        type: "post",
        url: "hooks/contacts_AJAX.php",
        data: {cmd: 'record',id:id},
        dataType: "json",
    }).done(function(msg){
        if (msg){
            console.log(msg);
            var $si = $j('#personaFisica1');
            $si.append('<div id="contatc_data"> hola' + msg + '</div>')
        }
    });

};


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

