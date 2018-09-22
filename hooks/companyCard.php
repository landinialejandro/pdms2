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
$currDir = dirname(__FILE__);
include("$currDir/../defaultLang.php");
include("$currDir/../language.php");
include("$currDir/../lib.php");

/* grant access to all users who have access to the companies table */
$table_name = 'companies';
$table_from = get_sql_from($table_name);
if (!$table_from) {
    exit(error_message('Access denied to companies!', false));
}
$where_id = intval($_REQUEST['id']);

if (!$where_id) {
    exit(error_message('The monkey are eating the companies Code. (the company code are lost)', true));
}

/* retrive from companies info */
$table_fields = get_sql_fields($table_name);
$res = sql("SELECT {$table_fields} FROM {$table_from} AND id = {$where_id}", $eo);

if (!($result = db_fetch_assoc($res))) {
    exit(error_message('company not found', false));
}


ob_start();
?>
<!-- insert HTML code-->
    <div class="row">
        <div class="col-lg-4">
            <h7 class="ui-widget-header ui-corner-all" style="text-align: center;">Data</h7><br>
            Fiscal code: <?php echo $result['fiscalCode']; ?><br>
            vat: <?php echo $result['vat']; ?><br>
            Address: <?php echo $result['UM']; ?><br>
        </div>
        <div class="col-lg-8">
            <h7 class="ui-widget-header ui-corner-all" style="text-align: center;">Notes</h7><br>
            <textarea class="form-control" rows="2"><?php echo $result['notes']; ?></textarea>
        </div>
    </div>
    <h6 class="ui-widget-header ui-corner-all" style="text-align: center;">
        <small><?php echo 'Last update ?'; ?>  </small>
        <button id="companies_view_parent" pt="companies" myid="<?php echo $where_id; ?>" class="btn btn-sm view_parent" type="button" title="Azienda Details" onclick="showParent(this);" >show</button>
        <button class="btn btn-sm pull-right" type="button" title="Refresh data" onclick="refreshCards()" >refresh</button>
    </h6>
<?php
$html_code = ob_get_contents();
ob_end_clean();
echo $html_code;