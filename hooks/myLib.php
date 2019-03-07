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

function retCompanyData(&$company,&$company_values, $id = false, $control = true){
    
    if ($id){
        $where_id ="AND companies.id={$id}";//change this to set select where
    }
    $company = getDataTable('companies',$where_id);
    $company_values = getDataTable_Values('companies', $where_id);

    //error control
    if ($control){
        if(!$company['vat']){
            exit(error_message('<h1>vat not valid in company data</h1>', false));
        }
        if(!$company['FormatoTrasmissione']){
            exit(error_message('<h1>Formato Trasmissione not valid in company data</h1>', false));
        }
        if(!$company['regimeFiscale']){
            exit(error_message('<h1>regime fiscale not valid in company data</h1>', false));
        }
//        if(!$company['RiferimentoAmministrazione']){
//            exit(error_message('<h1>Riferimento Amministrazione not valid in company data</h1>', false));
//        }
    }
}

function retCompanyAddress(&$address, &$address_values, $companyId = false, $control = true){
    //default multiCompany address or firstaddress found
        if (!$companyId){
            exit(error_message('<h1>not select company for a valid address</h1>', false));
        }
        
        $where_id = "AND addresses.company = {$companyId} ORDER BY addresses.default, addresses.id DESC LIMIT 1;";
    
        $address = getDataTable("addresses", $where_id);
        $address_values = getDataTable_Values('addresses', $where_id);
            //error control
        if ($control){
        
            if (!$address['country']){
                exit(error_message('<h1>country not valid in company address</h1>', false));
            }
            if (!$address['address']){
                exit(error_message('<h1>address not valid in company address</h1>', false));
            }
            if (!$address['houseNumber']){
                exit(error_message('<h1>numero civico not valid in company address</h1>', false));
            }
            if (!$address['postalCode']){
                exit(error_message('<h1>postal Code not valid in company address</h1>', false));
            }
            if (!$address['district']){
                exit(error_message('<h1>district Code not valid in company address</h1>', false));
            }
            if (!$address['town']){
                exit(error_message('<h1>town not valid in company address</h1>', false));
            }
        }
}

function retMailPhonelFax_Company(&$mail, &$phone, &$fax, $companyId){
    
        //default work multiCompany mail 
        $where_id ="AND mails.company = {$companyId} AND mails.kind = 'WORK'";//change this to set select where
        $mail = getDataTable('mails',$where_id);
        
        //default work multiCompany phone 
        $where_id ="AND phones.company = {$companyId} AND phones.kind = 'WORK'";//change this to set select where
        $phone = getDataTable('phones',$where_id);
        
        //default work multiCompany phone 
        $where_id ="AND phones.company = {$companyId} AND phones.kind = 'FAX'";//change this to set select where
        $fax = getDataTable('phones',$where_id);

}
function retMailPhonelFax_Contact(&$mail, &$phone, &$fax, $contactId){
    
        //and defaul mail contact
        $where_id="AND mails.contact = {$contactId} ORDER BY mails.id DESC LIMIT 1;";
        $mail = getDataTable("mails", $where_id);

        //and default phone contact
        $where_id="AND phones.contact = {$contactId} ORDER BY phones.id DESC LIMIT 1;";
        $phone = getDataTable("phones", $where_id);

        //and default FAX phone contact
        $where_id="AND phones.contact = {$contactId} AND phones.kind = 'FAX' ORDER BY phones.id DESC LIMIT 1;";
        $fax = getDataTable("phones", $where_id);

}