<?php
header('Content-type: application/json');
$currDir = dirname(__FILE__);
include("$currDir/../lib.php");

if(isset($_REQUEST['cmd']) && isset($_REQUEST['id'])){
    $id=makeSafe($_REQUEST['id']);
    $data ="{'invalid':'data'}";
    if ($_REQUEST['cmd']==='limit'){
        $code = $_REQUEST['code'];
        $data = array_merge(getLimitsCompany($id,$code),getPurchasesCompany($id));
    }
    if ($_REQUEST['cmd']==='bar'){
        $data = dataBar($id);
    }
    if ($_REQUEST['cmd']==='commision'){
        $where_id =" AND attributes.attribute = 'COMMISION' AND attributes.company = {$id}";//change this to set select where
        $data = getDataTable('attributes', $where_id);
    }
    echo json_encode($data, true);
}

