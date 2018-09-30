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