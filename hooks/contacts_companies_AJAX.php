<?php
header('Content-type: application/json');
$currDir = dirname(__FILE__);
include("$currDir/../lib.php");

if(isset($_REQUEST['cmd']) && isset($_REQUEST['id'])){
    $id=makeSafe($_REQUEST['id']);
    $data ="{'invalid':'data $id'}";
    if ($_REQUEST['cmd']==='record'){
        $res = sql("SELECT * FROM contacts_companies WHERE contacts_companies.id = {$id} LIMIT 1;",$eo);
        if(!($row = db_fetch_array($res))){
            $row[]="";
        }
        $data=$row;
    }
    echo json_encode($data, true);
}

