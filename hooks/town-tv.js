$j(function(){

    //use def {"field_name_name":"type"}
    //acepted type for now "select" this is for select type, gete de data fromn appgini select
    //                   or "text" this last is default
    //                   or "disabled" if you can not editable field

    var def = {"country":"select","idIstat":"select"}
    tv_editlets('town',["country","idIstat"], def);
});
