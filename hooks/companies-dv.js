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
        var $si = $j('label[for=personaFisica1]');
        if (view === 'Si'){
            $si.text('Si: After save you can select a defualt contact.' );
        }else{
            $si.text('Si' );
        }
        return;
    }
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
                getContact(contactId);
            }else{
                //not default contact
                var id = $j('input[name=SelectedID]').val();
                var $si = $j('label[for=personaFisica1]');
                $si.append(': <a href="contacts_view.php?addNew_x=1&c=' + id + '" id="add_contact" class="btn btn-default btn-xs">add a contact</a>' );
            }
        });
    }else{
        //ocultar la vista
        
        var $si = $j('label[for=personaFisica1]');
                $si.text( 'Si' );
    }
};

function getContact(id){
    $j.ajax({
        type: "post",
        url: "hooks/contacts_AJAX.php",
        data: {cmd: 'record',id:id},
        dataType: "json"
    }).done(function(msg){
        if (msg){
            console.log(msg);
            var $si = $j('label[for=personaFisica1]');
            $si.append(': ' + msg.lastName + ', ' + msg.name );
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

