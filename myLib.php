<?php

$currDir = dirname(__FILE__);
include("$currDir/hooks/_mk/_mkbuttons.php");

/**
 * This hook function is called when get a row from a table. 
 * 
 * @param $table_name
 * table name to get data
 * 
 * @param $where_id
 * is a string to indicate the select id from record use:
 * example " AND id=1"
 * 
 * @return
 * db_fetch from data result
*/

function getDataTable($table_name, $where_id = "", $debug =FALSE){
    // the $where_id need to be likle the next line
    // $where_id ="AND attributes.attribute = {$id}";//change this to set select where
    $table_from = get_sql_from($table_name);
    $table_fields = get_sql_fields($table_name);
    $where_id = "" ? "" : " " . $where_id;
    $sql="SELECT {$table_fields} FROM {$table_from}" . $where_id;
    if ($debug){
        echo "<br>".$sql."<br>";
    }
    $res = sql($sql, $eo);
    return db_fetch_assoc($res);
}

function getDataTable_Values($table_name, $where_id = "", $debug =FALSE){
    // the $where_id need to be likle the next line
    // $where_id ="AND attributes.attribute = {$id}";//change this to set select where
    $where_id = "" ? "" : " where 1=1 " . $where_id;
    $sql = "SELECT * FROM {$table_name}" . $where_id;
    if ($debug){
        printf( "<br>".$sql."<br>");
    }
    $res = sql($sql, $eo);
    return db_fetch_assoc($res);
}

function getLimitsCompany($id, $code){
    /* return limit credit*/
    // $res = sql("select * from SQL_customersLimits where cust_id = '$id' and attr_code = '$code' LIMIT 1;",$eo);
    $where_id = "AND  cust_id = '$id' AND attr_code = '$code' LIMIT 1;";
    $res = getDataTable_Values('SQL_customersLimits', $where_id);
    if(!$res){
        $res[] = "";
    }
    return $res;
}

function getPurchasesCompany($id){ //customers
    /*return purchasses amount */
    $res = sql("select sum(ordersDetails.LineTotal) as 'total_purchases' from orders left outer join ordersDetails on ordersDetails.`order` = orders.id where orders.customer = '{$id}' LIMIT 1;",$eo);
    if(!($row = db_fetch_array($res))){
        $row[]="";
    }
    return $row;
}

function dataBar($id){
    $data = array_merge(getLimitsCompany($id,'CUST_CREDIT'),getPurchasesCompany($id));
//    var_dump($data);
    //si el limite de credito es mayor que lo comprado? total comprado / credito : exede el credito.
    if ($data['val_limit']){
        $ratio=100;
        $color='red';
        $overdraft = $data['total_purchases'] - $data['val_limit'];//descubierto
        if ($overdraft < 0 ){
            $ratio = ($data['total_purchases']/$data['val_limit'])*100;
            $color='green';
            if ($ratio > 75){
                $color = 'red';
            }elseif($ratio > 50){
                $color= 'yellow';
            }
        }else{
            //alcanzo el limite de credito
        }
        $ret = array(
            "ratio"     => $ratio,
            "color"     => $color,
            "overdraft" => $overdraft
        );
    }else{
        $ret[]="";
    }
    return $ret;
}

function getKindsData($code = "", $name = ""){
    
    if($code){
        $code = " AND kinds.code = '{$code}'";
    }
    if($name){
        $name = " AND kinds.name = '{$name}'";
    }
    $where_id = $code . $name;//change this to set select where

    $res = getDataTable('kinds', $where_id);

    $result = json_decode($res['value']);

    if (json_last_error() === JSON_ERROR_NONE) {
        // JSON is valid
        $res[]=$result;
    }
    return $res;
}

function getTotCol($parameters,$fieldToSUM){
    //return tot value
    $sumQuery="select sum(`".$parameters['ChildTable']."`.`". $fieldToSUM ."`) from ".$parameters['ChildTable']." where `". $parameters['ChildLookupField']."` = '". $parameters['SelectedID']. "'";
    $res= sqlValue($sumQuery);
    return $res;
}

function updateSqlViews(){
    $dir = dirname(__FILE__) . "/hooks/SQL_Views";
    $views = array_diff(scandir($dir), array('.', '..'));
    foreach ($views as $sql){
        $res = sql(file_get_contents("$dir/$sql"),$eo);
    }
}

function importData(){
    $dir = dirname(__FILE__) . "/data";
    $views = array_diff(scandir($dir), array('.', '..'));
    foreach ($views as $sql){
        $res = sql(file_get_contents("$dir/$sql"),$eo);
    }
}
