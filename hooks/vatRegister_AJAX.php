<?php

header('Content-type: application/json');
$currDir = dirname(__FILE__);
include("$currDir/../lib.php");

if(isset($_REQUEST['cmd']) && isset($_REQUEST['id'])){
    
    $id=makeSafe($_REQUEST['id']);
    $data ="{'invalid':'data $id'}";
    
    if ($_REQUEST['cmd']==='record'){
        $data = getDataTable_Values('vatRegister',"AND company = $id ORDER BY vatRegister.id, vatRegister.default DESC LIMIT 1");
    }
    echo json_encode($data, true);
}


