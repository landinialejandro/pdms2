<?php

$currDir = dirname(__FILE__);
include("$currDir/../lib.php");

if (isset($_POST['cmd'])){
    $cmd = makeSafe($_POST['cmd']);
    switch ($cmd) {
        case 'getValue':
            $id= makeSafe($_POST['id']);
            echo getValue($id);
            break;
        
    }
}

function getValue($id){
    $val = sqlValue("SELECT value FROM kinds WHERE code = '{$id}' ");
    return $val;
}
