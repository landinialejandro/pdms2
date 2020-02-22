<?php
//  
// Author: Alejandro Landini
// REP_printSummaryDocument.php 25/8/18, 10:00
// 
//

$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/hooks/orders.php");
include("$currDir/REP_SummaryDocument_print.php");

// mm: can member insert record?
$arrPerm=getTablePermissions('orders');
if(!$arrPerm[1]){
        return false;
}

$orderTypeId = 'TD01'; //for destination document type
$summaryDocument = 'DDT'; // summary document type

/* get order ID */
$order_id = intval($_REQUEST['OrderID']);
if(!$order_id) exit(error_message('Invalid order ID!', false));

/* retrieve order info */
///////////////////////////
$where_id =" AND orders.id = {$order_id}";//change this to set select where
$order = getDataTable('orders',$where_id);
$order_values = getDataTable_Values('orders', $where_id);

$orderDate = strtotime($order_values['date']);

$month_ = date('m',$orderDate);
$year_ = date('Y',$orderDate);

//if( !is_null($order['related'])){
//    exit(error_message('The selected orders already has a report!', false));
//}


$totOrderDetail = sqlvalue(
        "SELECT SUM(`LineTotal`) FROM SQL_ordersDetails WHERE " .
            "1=1 ".
           "AND company  = {$order_values['company']}
            AND typeDoc  = '{$summaryDocument}'
            AND customer = {$order_values['customer']} 
            AND MONTH    = {$month_} 
            AND YEAR     = {$year_}");
            
if (!$totOrderDetail){
    exit(error_message('invalid order total!: '. $totOrderDetail, false));
}      

/*
 * Adding a new $orderTypeId 
 *
 *  
 */

$data = array(
            'kind' => $order_values['kind'],
            'company' => $order_values['company'],
            'typeDoc' => $orderTypeId, //fattura
            'customer' => $order_values['customer'],
            'date' => parseMySQLDate(date('Y-m-d'), ''),
            'orderTotal' => $totOrderDetail
        );

$recID = addOrder($data);

$data += array(
            'Month' => $month_,
            'Year' => $year_,
            'orderTypeId' => $orderTypeId, //for destination document type
            'summaryDocument' => $summaryDocument // summary document type
        );

/*
 * add lines to new $summaryDocument with related id
 * 
 */

addOrderDetails($data, $recID);

//updating related orders.

//buscar las ordenes y actualizar related con la orden actual.

$sql_update = "UPDATE
    `orders` 
SET
    related = {$recID} 
WHERE
    `kind` = 'OUT'
    AND `company` = '{$order_values['company']}'
    AND `typeDoc` = '{$summaryDocument}'
    AND `customer` = '{$order_values['customer']}'
    AND `related` IS NULL";
    
sql($sql_update,$eo);

///go to pint!!

printDocument($recID);

function addOrder($data){
    
    // hook: orders_before_insert
    $args=array();
    
    if(!orders_before_insert($data, getMemberInfo(), $args)){ return false; }

    if (!insert('orders', $data, $error)){
        exit(error_message('Error! ' . $error, false));
    }

    // no funca
    $recID = db_insert_id(db_link());//get last id insert

    // hook: orders_after_insert
    $res = sql("select * from `orders` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);

    if($row = db_fetch_assoc($res)){
        $data = array_map('makeSafe', $row);
    }

    $data['selectedID'] = makeSafe($recID, false);

    $args=array();
    if(!orders_after_insert($data, getMemberInfo(), $args)){ return $recID; }

    // mm: save ownership data
    set_record_owner('orders', $recID, getLoggedMemberID());

    return $recID;
}

function addOrderDetails($data, $recID){
    
    
    
    //copy details items to $orderTypeId
    $sql="INSERT INTO `ordersDetails` 
    (   `order`,
        `manufactureDate`,
        `sellDate`,
        `expiryDate`,
        `daysToExpiry`,
        `codebar`,
        `UM`,
        `productCode`,
        `batch`,
        `packages`,
        `noSell`,
        `Quantity`,
        `QuantityReal`,
        `UnitPrice`,
        `Subtotal`,
        `taxes`,
        `Discount`,
        `LineTotal`,
        `section`,
        `transaction_type`,
        `skBatches`,
        `averagePrice`,
        `averageWeight`,
        `commission`,
        `return`,
        `supplierCode`, 
        `related`)
    SELECT
        '{$recID}' as `order`,
        `manufactureDate`,
        `sellDate`,
        `expiryDate`,
        `daysToExpiry`,
        `codebar`,
        `UM`,
        `productCode`,
        `batch`,
        `packages`,
        `noSell`,
        `Quantity`,
        `QuantityReal`,
        `UnitPrice`,
        `Subtotal`,
        `taxes`,
        `Discount`,
        `LineTotal`,
        `section`,
        `transaction_type`,
        `skBatches`,
        `averagePrice`,
        `averageWeight`,
        `commission`,
        `return`,
        `supplierCode`,
        orders.id as `related`
    FROM
        `SQL_ordersDetails`
    JOIN orders ON orders.id = SQL_ordersDetails.order 
    WHERE 
        SQL_ordersDetails.company = {$data['company']} 
        AND SQL_ordersDetails.typeDoc = '{$data['summaryDocument']}'
        AND SQL_ordersDetails.customer ={$data['customer']} 
        AND SQL_ordersDetails.MONTH = {$data['Month']} 
        AND SQL_ordersDetails.YEAR = {$data['Year']}";

    sql($sql,$eo);
    
}