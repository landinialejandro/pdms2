<?php
//  
// Author: Alejandro Landini
// 
// toDo: 
// revision:
// 
//
$cardDir = dirname(__FILE__);
include("$cardDir/../defaultLang.php");
include("$cardDir/../language.php");
include("$cardDir/../lib.php");

setlocale(LC_MONETARY, 'it_IT');
/* grant access to all users who have access to the orders table */
$table_name = 'orders';
$table_from = get_sql_from($table_name);
if (!$table_from) {
    exit(error_message('Access denied to orders!','', false));
}
$where_id = intval($_REQUEST['id']);//order ID

if (!$where_id) {
    exit(error_message('The monkey are eating the orders Code. (the order code are lost)','', true));
}

/* retrive from orders info */
$table_fields = get_sql_fields($table_name);
$res = sql("SELECT {$table_fields} FROM {$table_from} AND `orders`.id = {$where_id}", $eo);

if (!($result = db_fetch_assoc($res))) {
    exit(error_message('order not found','', false));
}

$OrderKind = sqlValue("select kind from orders where id = {$where_id} LIMIT 1;");
$orderCompany = intval(sqlValue("select company from orders where id = {$where_id} LIMIT 1;"));

/* retrieve company attributes*/
$table_fields = get_sql_fields("attributes");
$table_from = get_sql_from("attributes");
$attributes = sql("SELECT {$table_fields} FROM {$table_from} AND `attributes`.`company` = {$orderCompany}",$eo);


$table_fields = get_sql_fields('addresses');
$table_from=get_sql_from('addresses');
$res= sql("SELECT {$table_fields} FROM {$table_from} AND `addresses`.`company` = {$orderCompany} AND `addresses`.`default` = 1",$eo);

if (!($address = db_fetch_assoc($res))) {
    //if not setting a default address, get the first.
    $res= sql("SELECT {$table_fields} FROM {$table_from} AND `addresses`.`company` = {$where_id} order by `addresses`.id ASC LIMIT 1",$eo);
    if (!($address = db_fetch_assoc($res))) {
        $address['address'] = "not found default address";
    }
}
$defaultAddress = "{$address['address']} {$address['houseNumber']} {$address['town']} {$address['district']} {$address['country']}";


ob_start();
?>
<!-- insert HTML code-->
    <div class="row">
        <div class="col-lg-4">
            <div class="box box-info">
                <div class="">
                    <strong><h7 class="box-title">Data</h7></strong>
                </div>
                <strong>Total Order:</strong> <?php echo $result['orderTotal']; ?><br>
                <strong>Customer/Provider:</strong> <?php echo $result['customer'].$result['supplier']; ?><br>
                <strong>Type Doc:</strong> <?php echo $result['typeDoc']; ?><br>
                <strong>Address:</strong> <?php echo $defaultAddress; ?><br>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box box-info">
                <div class="">
                    <strong><h7 class="box-title">Notes</h7></strong>
                </div>
                <textarea class="form-control" rows="2"><?php echo "order date".$result['date']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="small-box bg-aqua">
            <small><?php 
            $date = date('j/n/Y', sqlValue("select dateUpdated from membership_userrecords where tableName ='$table_name' and pkValue='$where_id'"));
            echo "Last update $date"; ?>  </small>
            <a id="<?php echo $table_name; ?>_view_parent" pt="<?php echo $table_name; ?>" myid="<?php echo $where_id; ?>" class="btn btn-sm view_parent" type="button" title="<?php echo $table_name; ?> Details" onclick="showParent(this);" >more info
                <i class="fa fa-arrow-circle-right"></i>
            </a>
            <a class="btn btn-sm pull-right" type="button" title="Refresh data" onclick="refreshCards()" >refresh
                <i class="fa fa-refresh"></i>
            </a>
    </div>
<?php
$html_code = ob_get_contents();
ob_end_clean();
echo $html_code;