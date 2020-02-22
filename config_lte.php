<?php
//change to FALSE if you want back to appgini default
$LTE_globals =[
    "app-title-prefix" => "Ale | ", //window bar prfix title or browser tab
    "logo-mini" => "glyphicon glyphicon-home", //mini logo for sidebar mini 50x50 pixels
    "logo-mini-text" => "ALE", // text for side bar
    "navbar-text" => "Alejandro Landini template",
    "footer-left-text" => "<strong>ALE © ". date("Y") ." <a href=\"#\">Alejandro Landini adminLte template for appGini</a>.</strong>",
    "footer-right-text" => "Anything you want"
];

 //changue this for tablename icon
 $ico_menu = '{
    "Documenti":"fa fa-table",
    "Catalogo":"fa fa-gift",
    "Prima Nota":"fa fa-pencil-square-o",
    "Anagrafiche":"fa fa-cog",
    "Altro":"fa fa-plus",
    "hiddens":"fa fa-eye-slash"
}';

function getLteStatus($LTE_enable = true){
    if(!function_exists('getMemberInfo')){
        $LTE_enable = false;
    } 
    return $LTE_enable ;
}
