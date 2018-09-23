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

/* grant access to all users who have access to the town table */
$table_name = 'town';
$table_from = get_sql_from($table_name);
if (!$table_from) {
    exit(error_message('Access denied to town!', false));
}
$where_id = intval($_REQUEST['id']);

if (!$where_id) {
    exit(error_message('The monkey are eating the town Code. (the town code are lost)', true));
}

/* retrive from town info */
$table_fields = get_sql_fields($table_name);
$res = sql("SELECT {$table_fields} FROM {$table_from} AND id = {$where_id}", $eo);

if (!($result = db_fetch_assoc($res))) {
    exit(error_message('town not found', false));
}

$country = sqlValue("select country from countries where id = {$result['country']}");
$countryCode = sqlValue("select code from countries where id = {$result['country']}");

ob_start();
?>
<!-- insert HTML code-->
    <div class="row">
        <div class="col-lg-12">
            <h7 class="ui-widget-header ui-corner-all" style="text-align: center;">
                <?php echo $result['town']; ?><br>
                <small><?php echo $country . ' ('.$countryCode. ')'; ?></small><br>
            </h7><br>
            <div class="col-lg-6">
                IdStat: <?php echo $result['fiscalCode']; ?><br>
                Comune: <?php echo $result['vat']; ?><br>
                Provincia: <?php echo $result['UM']; ?><br>
                Regione: <?php echo $result['UM']; ?><br>
            </div>
            <div class="col-lg-6">
                Prefisso: <?php echo $result['UM']; ?><br>
                CAP: <?php echo $result['UM']; ?><br>
                Codice Fiscale: <?php echo $result['UM']; ?><br>
                Abitanti: <?php echo $result['UM']; ?><br>
            </div>
        </div>
    </div>
    </h6>
<?php
$html_code = ob_get_contents();
ob_end_clean();
echo $html_code;