<?php
//  
// Author: Alejandro Landini
// DDT_printResume.php 25/8/18, 10:00
// 
// GET parameteres for print documents
// 
// toDo: 
// revision:
// 
//
$cardDir = dirname(__FILE__);
include("$cardDir/../defaultLang.php");
include("$cardDir/../language.php");
include("$cardDir/../lib.php");

/* grant access to all users who have access to the companies table */
$table_name = 'companies';
$table_from = get_sql_from($table_name);
if (!$table_from) {
    exit(error_message('Access denied to companies!','', false));
}
$where_id = intval($_REQUEST['id']);

if (!$where_id) {
    exit(error_message('The monkey are eating the companies Code. (the company code are lost)','', true));
}

/* retrive from companies info */
$table_fields = get_sql_fields($table_name);
$res = sql("SELECT {$table_fields} FROM {$table_from} AND id = {$where_id}", $eo);

if (!($result = db_fetch_assoc($res))) {
    exit(error_message('company not found','', false));
}

$table_fields = get_sql_fields('addresses');
$table_from=get_sql_from('addresses');
$res= sql("SELECT {$table_fields} FROM {$table_from} AND `addresses`.`company` = {$where_id} AND `addresses`.`default` = 1",$eo);

if (!($address = db_fetch_assoc($res))) {
    $defaultAddress = "not found default address";
}else{
    $defaultAddress = "{$address['address']} {$address['houseNumber']} {$address['town']} {$address['district']} {$address['country']}";
}


ob_start();
?>
<!-- insert HTML code-->
    <div class="row">
        <div class="col-lg-4">
            <div class="box box-info">
                <div class="">
                    <strong><h7 class="box-title">Data</h7></strong>
                </div>
                Fiscal code: <?php echo $result['fiscalCode']; ?><br>
                vat: <?php echo $result['vat']; ?><br>
                Address: <?php echo $defaultAddress; ?><br>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box box-info">
                <div class="">
                    <strong><h7 class="box-title">Notes</h7></strong>
                </div>
                <textarea class="form-control" rows="2"><?php echo $result['notes']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="small-box bg-aqua">
            <small><?php echo 'Last update ?'; ?>  </small>
            <a id="companies_view_parent" pt="companies" myid="<?php echo $where_id; ?>" class="btn btn-sm view_parent" type="button" title="Azienda Details" onclick="showParent(this);" >more info
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