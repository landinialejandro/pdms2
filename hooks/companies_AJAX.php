<?php
header('Content-type: application/json');
$currDir = dirname(__FILE__);
include("$currDir/../lib.php");

if(isset($_REQUEST['cmd']) && isset($_REQUEST['id'])){
    $id=makeSafe($_REQUEST['id']);
    if ($_REQUEST['cmd']==='limit'){
        $data = array_merge(getCreditCompany($id),getPurchasesCompany($id));
        echo json_encode($data, true);
    }
    if ($_REQUEST['cmd']==='bar'){
        $data = dataBar($id);
        echo json_encode($data, true);
    }
}

