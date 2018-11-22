<?php

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

function getDataTable($table_name,$where_id){
    $table_from = get_sql_from($table_name);
    $table_fields = get_sql_fields($table_name);
    $res = sql("SELECT {$table_fields} FROM {$table_from}" . $where_id, $eo);
    return db_fetch_assoc($res);
}

function getLimitsCompany($id, $code){
    /* return json limit credit*/
    $res = sql("select * from SQL_customersLimits where cust_id = '$id' and attr_code = '$code' LIMIT 1;",$eo);
    if(!($row = db_fetch_array($res))){
        $row[]="";
    }
    return $row;
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

function kindName($code){
    return makeSafe(sqlValue("select name from kinds where code = '{$code}'"));
}