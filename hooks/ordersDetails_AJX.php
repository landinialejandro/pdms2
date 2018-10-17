<?php

$currDir = dirname(__FILE__);
$base_dir = realpath("{$currDir}/..");  
if(!function_exists('makeSafe')){
    include("$base_dir/lib.php");
}  

if (isset($_POST['action']) && isset($_POST['id'])){
    $cmd   = makeSafe($_POST['action']);
    $id    = makeSafe($_POST['id']);
    $cant  = makeSafe($_POST['cant']);
    $order = makeSafe($_POST['IDorder']);
    
    
    echo processRequest($cmd, $id, $cant, $order);
    return;
}

function processRequest($cmd, $id, $cant, $order){
    $ret="ret - $cmd, $id, $cant, $order";
    
    
    if ($cmd === 'fastAdd'){
        fastAdd($id, $cant, $order);
    }
    if ($cmd === 'totOrder'){
        $parameters = $_POST['parameters'];
        $ret = getTotOrder($parameters, $id);
    }
    
    return $ret;
}

function fastAdd($id, $cant, $order){
    $statment="select sellPrice from products where id = '$id'";
    $unitPrice = sqlValue($statment);
    $val = $cant * $unitPrice;
    $today = date("Y-m-d");
    $statment = "insert into ordersDetails SET ordersDetails.manufactureDate = '$today', ordersDetails.sellDate = '$today', ordersDetails.order = '$order', productCode = '$id', Quantity = '$cant', UnitPrice = '$unitPrice', LineTotal = '$val', transaction_type = 'Outgoing' ";
    $ret = sql($statment,$eo);
    return $ret;
}

function getTotdetails($data){
    $parameters['ChildTable'] = 'ordersDetails';
    $parameters['SelectedID'] = $data['order'];
    $parameters['ChildLookupField'] = 'order';
    $tot = getTotOrder($parameters,'LineTotal');
    return $tot;
}
        
function getTotOrder($parameters,$fieldToSUM){
    $sumQuery="select sum(`".$parameters['ChildTable']."`.`". $fieldToSUM ."`) from ".$parameters['ChildTable']." where `". $parameters['ChildLookupField']."` = '". $parameters['SelectedID']. "'";
    $res= sqlValue($sumQuery);
    return $res;
}
        