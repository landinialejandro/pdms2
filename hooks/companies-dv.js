/* global $j */

$j(function(){
    hideFileds();
    if (!is_add_new()){
        loadDefaults();
    }
});

$j('#phone, #mail, #address').on('click', function () {
    var file = $j('.default-'+ $j(this).attr('id') + ' label').attr('for');
    childsFunctions(file,'Company',this.attributes.thisid.value);
});

$j('form input[name=personaFisica]').on('change', function() {
    getContactId();
});

$j('label').on('click','a[id=add_contact]',function () {
    addContact(this.attributes.selectedid.value);
});

function hideFileds(){
    
    $j("#codiceDestinatario").parent().parent().hide();
}

function getContactId(){
    var view = $j('input[name=personaFisica]:checked', 'form').val();
    var id = $j('input[name=SelectedID]').val();
    
    if (view === "Si"){
        if (is_add_new()){
            changueLabel('Si: After save you can select a defualt contact.');
            return;
        }
        //bucar la persona default, si no abrir una y cargar
        changueLabel('Si: <i class="fa fa-spinner fa-spin"></i>');
        $j.get('hooks/contacts_companies_AJAX.php', {cmd: 'record',id:id})
        .done(function ( msg ) {
            if ( msg ){
                //get contact data
                if (!msg.default){
                    $j('label[for=personaFisica1]').parent().addClass('warning');
                }
                getContact( msg.contact );
            }else{
                //not default contact
                var id = $j('input[name=SelectedID]').val();
                changueLabel('Si: <a href ="#" id="add_contact" selectedid="" class="btn btn-default btn-xs">add a contact</a>' );
            }
        });
    }else{
        //ocultar la vista
        changueLabel( 'Si' );
    }
};

function getDefaultChild(child){
    var id = $j('input[name=SelectedID]').val();
    var $parent = $j('.default-'+child);
    var file = $j('.default-'+child + ' label').attr('for');
    var $btnChild = $j('#'+child);
    var text ="";
    
    $j.get('hooks/' + file + '_AJAX.php', {cmd: 'record',id:id})
    .done(function ( msg ) {
        if ( msg ){
            console.log(msg);
            switch (child) {
            case 'mail':
                text =   child +': ' + msg.mail;
                break;
            case 'phone':
                text = 'telefono: ' + msg.phoneNumber;
                break;
            case 'address':
                text = 'indirizzo: ' + msg.address + ' ' + msg.houseNumber + ', '+ msg.town + ', ' + msg.country + ' (' + msg.kind + ')';
                break;
            default:
                text = "oops";
            }
            
            $btnChild.attr('thisID', msg.id);
            if (!msg.default){
                //not default phone
                $btnChild.addClass('btn-warning');
                $btnChild.text('Ho trovato questo '+ text + ', pero no é il default');
            }else{
                $btnChild.removeClass('btn-warning');
                $btnChild.text( text );
            }
        }else{
            //not phone
            $btnChild.attr('thisID','');
        }
        $parent.show();
    });
}

function getContact( id ){
    $j.get("hooks/contacts_AJAX.php", {cmd: 'record', id: id})
    .done(function( msg ){
        if ( msg ){
            changueLabel('Si: <a href="#" id="add_contact" selectedid="' + msg.id + '">' + msg.lastName + ', ' + msg.name + '</a>' );
            if ($j('label[for=personaFisica1]').parent().hasClass('warning')){
                $j('#add_contact').parent().after('<div class="callout callout-warning"><i class="icon fa fa-warning"></i>You don\'t have a contact setting as default, but this is the first. Go down to <strong>Company=>Contacts</strong>  contacts and set one like default.</div>');
            }
        }
    });
};

function changueLabel( text ){
    var $si = $j('label[for=personaFisica1]');
    $si.html( text );
};

function setLimit( id, button ){
    var code = button.id;
    $j.get('hooks/companies_AJAX.php', {cmd: 'limit', id: id, code: code})
    .done(function (msg) {
        childsFunctions('attributes','Company',msg.attr_id,code);
        return false;
    });
}

function addContact(id = false){
    if (!id){
        var company =  $j('input[name=SelectedID]').val();
        var pt = 'contacts_view.php?addNew_x=1&Embedded=1&c=' + company;
        var title =  'Add contact';
    }else{
        var pt = 'contacts_view.php?Embedded=1&SelectedID=' + encodeURIComponent(id);
        var title =  'Contact detail';
    }

    modal_window({
        url: pt ,
        close: function(){
            if (id){
                getContact( id );
            }else{
                getContactId();
            }
        },
        size: 'full',
        title: title
    });
}

$j(document).on('hide.bs.modal','.modal',function(){
    
    setTimeout(function(){
        loadDefaults();
    },400);
    
});

function childsFunctions(child, parent, id = false, code = ""){
    var fn = child+parent+"GetRecords";
    var args = "";
    
    if (!id){
        args={ Verb: 'new', select: true, code:code }; 
    }else{
        args={ Verb: 'open', ChildID: id, select: true}; 
    }
    window[fn](args);
}

function loadDefaults(){
    getContactId();
    getDefaultChild('address');
    getDefaultChild('phone');
    getDefaultChild('mail');
}