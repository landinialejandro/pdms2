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
    // the $where_id need to be likle the next line
    // $where_id =" AND attributes.attribute = {$id}";//change this to set select where
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

function getKindsData($id){
    $where_id =" AND kinds.code = {$id}";//change this to set select where
    $kind = getDataTable('kinds', $where_id);

    $result = json_decode($attr['value']);

    if (json_last_error() === JSON_ERROR_NONE) {
        // JSON is valid
        $kind[]=$result;
    }
    return $kind;
}

function get_xml_file($fileHash, &$projectFile){
        try {

                $projects = scandir("/xmlFiles");
                $projects = array_diff($projects, array('.', '..'));
                $userProject = $fileHash;
                $projectFile = null;

                foreach ($projects as $project) {
                        if ($userProject == md5($project)) {
                                $projectFile = $project;
                                break;
                        }
                }
                if (!$projectFile)
                        throw new RuntimeException('Project file not found.');

                // validate simpleXML extension enabled
                if (!function_exists('simpleXML_load_file')) {
                        throw new RuntimeException('Please, enable simplexml extention in your php.ini configuration file.');
                }


                // validate that the file is not corrupted
                @$xmlFile = simpleXML_load_file("../projects/$projectFile", 'SimpleXMLElement', LIBXML_NOCDATA);
                if (!$xmlFile) {
                        throw new RuntimeException('Invalid axp file.');
                }


                return $xmlFile;
        } catch (RuntimeException $e) {
                echo "<br>" . $e->getMessage();
                exit;
        }
}

function generate_valid_xml_from_array($array, $node_block='nodes', $node_name='node') {
	$xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";

	$xml .= '<p:FatturaElettronica versione="FPR12" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd">'."\n";
	$xml .= generate_xml_from_array($array, $node_name);
	$xml .= '</p:FatturaElettronica>'."\n";

	return $xml;
}

function generate_xml_from_array($array, $node_name) {
    $xml = '';

    if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                    if (is_numeric($key)) {
                            $key = $node_name;
                    }

                    $xml .= '<' . $key . '>' . "\n" . generate_xml_from_array($value, $node_name) . '</' . $key . '>' . "\n";
            }
    } else {
            $xml = htmlspecialchars($array, ENT_QUOTES) . "\n";
    }

    return $xml;
}
