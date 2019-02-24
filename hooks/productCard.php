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
$productDir = dirname(__FILE__);
include("$productDir/../defaultLang.php");
include("$productDir/../language.php");
include("$productDir/../lib.php");

if (!isset($_REQUEST['cmd'])){
    exit(error_message('Process command not found','',false));
}

$where_id = intval($_REQUEST['id']);

if ($_REQUEST['cmd'] !== 'productCard'){
    $b = $_REQUEST['cmd'];
    $a = sqlvalue("select `{$b}` from products where id = {$where_id}");
    if ($b === 'tax'){
        //return tax value
        $a = sqlValue("select `value` from kinds where code = '{$a}'");
    }
    echo $a;
    return;
}

/* grant access to all users who have access to the orders table */
$table_name = 'products';
$table_from = get_sql_from($table_name);
if(!$table_from){
    exit(error_message('Access denied!','', false));
}

if(!$where_id){
    exit(error_message('The monkey are eating the product Code. (the product code are lost)','', false));
}

/* retrive de product info*/
$table_fields = get_sql_fields($table_name);
$res = sql("SELECT {$table_fields} FROM {$table_from} AND id = {$where_id}", $eo);

if(!($result = db_fetch_assoc($res))){
    exit(error_message('Product not found','',false));
}

$product = $result;

$product_update = sqlvalue("select `update_date` from products where id = $where_id");

$res = sql("SELECT * FROM SQL_productsStock where prodId=$where_id LIMIT 1;",$eo);
$stock = db_fetch_assoc($res);
$classes='danger';
if($stock['Stock']>0){
    $classes='success';
}
elseif($stock['Stock']==0){
    $classes='warning';
}

/* retrive attributes info*/
$table_name = 'attributes';
$attributes_from= get_sql_from($table_name);
$attributes_fields= get_sql_fields($table_name);
$res = sql("SELECT {$attributes_fields} FROM {$attributes_from} and product = {$where_id}", $eo);
$attributes = db_fetch_row($res);


ob_start();
?>
<!-- insert HTML code-->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $product['productName']; ?> <?php echo $product['sellPrice']; ?></h3>
            </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="box box-info">
                    <div class="">
                        <strong><h7 class="box-title">Data</h7></strong>
                    </div>
                    Aliquota: <?php echo $product['tax']; ?><br>
                    Categoria: <?php echo $product['CategoryID']; ?><br>
                    UM: <?php echo $product['UM']; ?><br>
                    Tara: <?php echo $product['tare']; ?><br>
                    Prezzo Vendita: <?php echo $product['sellPrice']; ?><br>
                    <div class="callout callout-<?php echo $classes; ?>">
                        <P>Stock Casse: <?php echo $stock['Stock']; ?></P>
                        <P>Stock Net Weight: <?php echo $stock['NetoIN'] - $stock['NetoOUT']; ?></P>
                        <P>Stock Gross Weight: <?php echo $stock['PesoStock']; ?></P>
                    </div>
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
                <small><?php echo 'Last update ' . time_elapsed_string($product_update); ?>  </small>
                <a id="products_view_parent" pt="products" myid="<?php echo $where_id; ?>" class="btn btn-sm view_parent" type="button" title="Product Details" onclick="showParent(this);" >more info
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
                <a class="btn btn-sm pull-right" type="button" title="Refresh data" onclick="refreshCards()" >refresh
                    <i class="fa fa-refresh"></i>
                </a>
            </div>
        </div>
<?php
$html_code = ob_get_contents();
ob_end_clean();
echo $html_code;


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}