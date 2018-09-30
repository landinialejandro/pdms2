<?php

$currDir = dirname(__FILE__);
if(!function_exists('sqlValue')){
    include("$currDir/../lib.php");
}

if (isset($_POST['cmd'])){
    $cmd = makeSafe($_POST['cmd']);
    switch ($cmd) {
        case 'nextOrder':
            $idDoc= makeSafe($_POST['d']);
            $idComp= makeSafe($_POST['c']);
            echo getNextValue($idDoc,$idComp);
            break;
    }
}

function getNextValue($idDoc,$idComp){
    $a = sqlValue("SELECT MAX(`multiOrder`) FROM orders WHERE `kind` ='OUT' and`typeDoc` ='". $idDoc ."' and `company` ='". $idComp ."'") + 1;
    return intval($a);
}
