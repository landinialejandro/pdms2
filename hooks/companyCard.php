<?php
//  
// Author: Alejandro Landini
// 
// 
// TODO: 
// revision:
// 
//
$cardDir = dirname(__FILE__);
include("$cardDir/../defaultLang.php");
include("$cardDir/../language.php");
include("$cardDir/../lib.php");

$where_id = intval($_REQUEST['id']);

$table_name = 'companies';

if (!$where_id) {
    exit(error_message(sprintf($Translation['invalid id'],$table_name),'', false));
}

/* retrive from table_name info */
/* grant access to all users who have access to the $table_name */
$table_from = get_sql_from($table_name);
if (!$table_from) {
    exit(error_message(sprintf($Translation['access denied'],$table_name),'', false));
}

$table_fields = get_sql_fields($table_name);
$res = sql("SELECT {$table_fields} FROM {$table_from} AND $table_name.id = {$where_id}", $eo);

if (!($result = db_fetch_assoc($res))) {
    exit(error_message($Translation['No records found'],'', false));
}
$recordKind = sqlValue("select kind from $table_name where $table_name.id = {$where_id} LIMIT 1;");

/* retrieve tableName attributes*/
$table_fields = get_sql_fields("attributes");
$table_from = get_sql_from("attributes");
$attributes = sql("SELECT {$table_fields} FROM {$table_from} AND `attributes`.`company` = {$where_id}",$eo);


$table_fields = get_sql_fields('addresses');
$table_from=get_sql_from('addresses');
$res= sql("SELECT {$table_fields} FROM {$table_from} AND `addresses`.`company` = {$where_id} ORDER BY `addresses`.`default` DESC LIMIT 1",$eo);

if (!($address = db_fetch_assoc($res))) {
        $address['address'] = '<p class="text-yellow"><i class="fa fa-bell-o"></i> '. $Translation['not found default address'].'</p>';
}
$defaultAddress = "{$address['address']} {$address['houseNumber']} {$address['town']} {$address['district']} {$address['country']}";

ob_start();
?>
<!-- insert HTML code-->
    <div class="row">
        <div class="col-lg-4">
            <div class="box box-info">
                <div class="">
                    <strong><h6 class="box-title"><?php echo $Translation['data']; ?></h6></strong>
                </div>
                Fiscal code: <?php echo $result['fiscalCode']; ?><br>
                vat: <?php echo $result['vat']; ?><br>
                <i class="fa fa-envelope"></i>: <?php echo $defaultAddress; ?><br>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box box-info">
                <div class="">
                    <strong><h6 class="box-title"><?php echo $Translation['notes']; ?></h6></strong>
                </div>
                <textarea class="form-control" rows="2"><?php echo $result['notes']; ?></textarea>
            </div>
        </div>
    </div>
<?php if($attributes->num_rows){ ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="">
                <h6 class="box-title"><?php echo $Translation['attributes']; ?></h6>
            </div>
            <div class="box-body">
                <?php 
                foreach ($attributes as $attribute){
                    echo $attribute['attribute'] . ": ". $attribute['value']."<br>";
                }
                //show progress bar
                $databar = dataBar($where_id);
                if ($databar['ratio']){
                ?>
                    <div class="progress">
                        <div id="barFido-<?php echo $recordKind; ?>" class="progress-bar progress-bar-<?php echo $databar['color']; ?>" role="progressbar" aria-valuenow="<?php echo $databar['ratio'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $databar['ratio'] ?>%">
                            <span class="">Fido <?php echo $result['kind'];?> <?php echo number_format($databar['ratio'],2,'.',''); ?>% Complete</span>
                        </div>
                    </div>
                <?php 
                } 
                if ($databar['overdraft'] ){
                ?>
                    scoperto: <?php echo money_format("%.2n", $databar['overdraft'] ); ?>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
    <div class="small-box bg-aqua">
            <small><?php 
            $date = date('j/n/Y', sqlValue("select dateUpdated from membership_userrecords where tableName ='$table_name' and pkValue='$where_id'"));
            echo "{$Translation['last modified']} $date"; ?>  </small>
            <a id="<?php echo $table_name; ?>_view_parent" pt="<?php echo $table_name; ?>" myid="<?php echo $where_id; ?>" class="btn btn-sm view_parent" type="button" title="Azienda Details" onclick="showParent(this);" ><?php echo $Translation['more info']; ?>
                <i class="fa fa-arrow-circle-right"></i>
            </a>
            <a class="btn btn-sm pull-right" type="button" title="Refresh data" onclick="refreshCards()" ><?php echo $Translation['refresh']; ?>
                <i class="fa fa-refresh"></i>
            </a>
    </div>
<?php
$html_code = ob_get_contents();
ob_end_clean();
echo $html_code;