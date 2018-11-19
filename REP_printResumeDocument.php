<?php
//  
// Author: Alejandro Landini
// REP_printResumeDocument.php 25/8/18, 10:00
// 
// GET parameteres for print documents
// 
// toDo: 
// revision:
// 
//
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
//if(function_exists('orders_before_insert')){
    include_once("$currDir/hooks/orders.php");
//}
require "$currDir/vendor/autoload.php";

// mm: can member insert record?
$arrPerm=getTablePermissions('orders');
if(!$arrPerm[1]){
        return false;
}

$orderTypeId='DFD'; //for destination document type

/* get order ID */
$order_id = intval($_REQUEST['OrderID']);
if(!$order_id) exit(error_message('Invalid order ID!', false));

/* retrieve order info */
///////////////////////////
$where_id =" AND orders.id = {$order_id}";//change this to set select where
$order = getDataTable('orders',$where_id);
$docCategorie_id= makeSafe(sqlValue("select typeDoc from orders where id={$order_id}"));
$month_ = sqlValue("select month(date) from orders where id={$order_id}");
$year_ = sqlValue("select year(date) from orders where id={$order_id}");
$kind = sqlValue("select kind from orders where id={$order_id}");
///////////////////////////

if( !is_null($order['related'])){
    exit(error_message('The selected orders already has a report!', false));
}

/* retrieve multycompany info */
///////////////////////////
$company_id=intval(sqlValue("select company from orders where id={$order_id}"));
$where_id =" AND companies.id={$company_id}";//change this to set select where
$company = getDataTable('companies',$where_id);
///////////////////////////
$where_id =" AND addresses.company = {$company['id']} AND addresses.default = 1";//change this to set select where
$address = getDataTable('addresses',$where_id);
///////////////////////////

/* retrieve customer info */
///////////////////////////
$customer_id = intval(sqlValue("select customer from orders where orders.id={$order_id}"));
$where_id=" AND companies.id = {$customer_id}";
$customer = getDataTable('companies',$where_id);
///////////////////////////Client address
$where_id =" AND addresses.company = {$customer['id']} AND addresses.default = 1";//change this to set select where
$addressCustomer = getDataTable('addresses',$where_id);
///////////////////////////shiping client address
$where_id =" AND addresses.company = {$customer['id']} AND addresses.ship = 1";//change this to set select where
$addressCustomerShip = getDataTable('addresses',$where_id);
///////////////////////////

$totOrderDetail = sqlvalue("SELECT SUM(`LineTotal`) FROM SQL_ordersDetails WHERE company = {$company_id} 
AND customer ={$customer_id} 
AND MONTH = {$month_} 
AND YEAR = {$year_}");


/*
 * Adding fatura differita and update DDT with related id
 * 
 */

$data = array(
                    'kind' => $kind,
                    'company' => $company_id,
                    'typeDoc' => $orderTypeId,
                    'customer' => $customer_id,
                    'date' => parseMySQLDate(date('Y-m-d'), ''),
                    'orderTotal' => $totOrderDetail
		);

// hook: orders_before_insert
$args=array();
//orders_before_insert($data, getMemberInfo(), $args);
if(!orders_before_insert($data, getMemberInfo(), $args)){ return false; }

insert('orders', $data);

$recID = db_insert_id(db_link());

// hook: orders_after_insert
$res = sql("select * from `orders` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
if($row = db_fetch_assoc($res)){
    $data = array_map('makeSafe', $row);
}
$data['selectedID'] = makeSafe($recID, false);
$args=array();
if(!orders_after_insert($data, getMemberInfo(), $args)){ return $recID; }

// mm: save ownership data
set_record_owner('orders', $recID, getLoggedMemberID());


//copy details items to DFD
$sql="INSERT INTO `ordersDetails` 
(   `order`,
    `manufactureDate`,
    `sellDate`,
    `expiryDate`,
    `daysToExpiry`,
    `codebar`,
    `UM`,
    `productCode`,
    `batch`,
    `packages`,
    `noSell`,
    `Quantity`,
    `QuantityReal`,
    `UnitPrice`,
    `Subtotal`,
    `taxes`,
    `Discount`,
    `LineTotal`,
    `section`,
    `transaction_type`,
    `skBatches`,
    `averagePrice`,
    `averageWeight`,
    `commission`,
    `return`,
    `supplierCode`)
SELECT
    '{$recID}' as `order`,
    `manufactureDate`,
    `sellDate`,
    `expiryDate`,
    `daysToExpiry`,
    `codebar`,
    `UM`,
    `productCode`,
    `batch`,
    `packages`,
    `noSell`,
    `Quantity`,
    `QuantityReal`,
    `UnitPrice`,
    `Subtotal`,
    `taxes`,
    `Discount`,
    `LineTotal`,
    `section`,
    `transaction_type`,
    `skBatches`,
    `averagePrice`,
    `averageWeight`,
    `commission`,
    `return`,
    `supplierCode`
FROM
    `SQL_ordersDetails`
WHERE company = {$company_id} 
AND customer ={$customer_id} 
AND MONTH = {$month_} 
AND YEAR = {$year_}";

sql($sql,$eo);

//updating related orders.

//buscar las ordenes y actualizar related con la orden actual.


$sql = "UPDATE
    `orders` 
SET
    related = {$recID} 
WHERE
    `kind` = '{$kind}'
    AND `company` = '{$company_id}'
    AND `typeDoc` = '{$docCategorie_id}'
    AND `customer` = '{$customer_id}'
    AND `related` IS NULL";
sql($sql,$eo);
//$row = db_fetch_assoc($res);


$multiOrder = intval(sqlvalue("select multiOrder from orders where id = {$recID}"));
$filename = $company['companyCode']."_".$orderTypeId."#".$multiOrder.".pdf"; //pdf name

$where_id =" AND orders.id = {$recID}";//change this to set select where
$order = getDataTable('orders',$where_id);
$docCategorie_id= makeSafe(sqlValue("select typeDoc from orders where id={$recID}"));


/* retrieve order items */
//$order_total = 0;
$items = sql("SELECT * FROM SQL_ordersDetails WHERE SQL_ordersDetails.order = {$recID}", $eo);

ob_start();
?>
<!-- insert HTML code table version-->
<!-- MultyCompy data-->
                
<table border="0" width="100%">
    <thead>
        <tr>
            <td>Azienda</td>
            <td align="right">Documento</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>
                <h1><?php echo $company['companyName']; ?></h1>
            </th>
            <th align="right">
                <h1><?php echo $docCategorie_id; ?> Nr. <?php echo $order['multiOrder']; ?></h1>
            </th>
        </tr>
        <tr>
            <td>
                <h4>Address: <?php echo $address['address']. " " . $address['houseNumber']; ?></h4>
                Town: <?php echo $address['town'] . " (". $address['country'] . ")"; ?> <br>
            </td>
            <td align="right">
                <h5>Date: <?php echo $order['date']; ?></h5>
            </td>
        </tr>
        <tr>
            <td>
                PostalCode: <?php echo $address['postalCode']; ?><br>
                District: <?php echo $address['district']; ?><br>
            </td>
            <td align="right">
                <h5><?php echo $order['typeDoc']; ?></h5>
            </td>
        </tr>
        <tr>
            <td>
                <h4>VAT: <?php echo $company['vat']; ?></h4>
            </td>
            <td align="right">
            </td>
        </tr>
    </tbody>
</table>
<hr>
<!-- /MultyCompy data-->

<!-- Customer data-->
<table border="0" width="100%">
    <thead>
        <tr>
            <th>Cliente</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border-radius:5px 5px 5px 5px"><h3><?php echo $customer['companyName']; ?></h3></td>
            <td><h4><strong>Shiping Address</strong></h4></td>
        </tr>
        <tr>
            <td>
                <h4>Address: <?php echo $addressCustomer['address']. " " . $addressCustomer['houseNumber']; ?></h4>
                Town: <?php echo $addressCustomer['town'] . " (". $addressCustomer['country'] . ")"; ?> <br>
                PostalCode: <?php echo $addressCustomer['postalCode']; ?><br>
                District: <?php echo $addressCustomer['district']; ?><br>
            </td>
            <td>
                <h4>Address: <?php echo $addressCustomerShip['address']. " " . $addressCustomerShip['houseNumber']; ?></h4>
                Town: <?php echo $addressCustomerShip['town'] . " (". $addressCustomerShip['country'] . ")"; ?> <br>
                PostalCode: <?php echo $addressCustomerShip['postalCode']; ?><br>
                District: <?php echo $addressCustomerShip['district']; ?><br>
            </td>
            
        </tr>
        <tr>
            <td>VAT: <?php echo $customer['vat']; ?></td>
        </tr>
    </tbody>
</table>
<hr>


<table border="0" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>DDT</th>
            <th>Data</th>
            <th>UM</th>
            <th>Quant</th>
            <th>Prezzo Un.</th>
            <th>Descrizione Articolo</th>
            <th>IVA</th>
            <th>imponibile</th>
            <th>Imposta</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($items as $i => $item){ 
            $where_id =" AND id = {$item['productCode']}";//change this to set select where
            $product = getDataTable('products',$where_id);
            ?>
                <tr>
                    <td><?php echo $item['order']; ?></td>
                    <td><?php echo $item['sellDate']; ?></td>
                    <td><?php echo $item['UM']; ?></td>
                    <td><?php echo $item['Quantity']; ?></td>
                    <td><?php echo $item['UnitPrice']; ?></td>
                    <td><?php echo $product['productName']; ?></td>
                    <td><?php echo $product['tax']; ?></td>
                    <td><?php echo $item['Subtotal']; ?></td>
                    <td><?php echo $item['LineTotal']; ?></td>
                </tr>
            <?php } ?>
    </tbody>
    <tfoot>
            <tr>
                    <th colspan="8" class="text-right">Subtotale</th>
                    <th class="text-right">€<?php echo number_format($totOrderDetail, 2); ?></th>
            </tr>
    </tfoot>
</table>

<?php
$html_code = ob_get_contents();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 5,
	'margin_right' => 5,
	'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10
]);
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Piattaforma Digitale Management System - FD");
$mpdf->SetAuthor("PDSM");
$mpdf->SetWatermarkText("PDMS");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html_code);
$f=$currDir.'/PDFfolder/';
$mpdf->Output($f.$filename, 'F');

$file = $f . $filename;
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
@readfile($file);
