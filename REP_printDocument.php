<?php
// 
// Author: Alejandro Landini
// _printReport 31/7/18, 21:00
// 
// GET parameteres for print documents
// 
// toDo: 
// revision:
//          *30/09/18   adding file to data base to close order.
//                      adding save file to PDFfolder
//                      check if exist save document and get it
//          *22/09/18   adapted to new data 
//          *25/08/18   add cusotmer data
// 
//
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include("$currDir/myLib.php");
require "$currDir/vendor/autoload.php";

/* get order ID */
$order_id = intval($_REQUEST['OrderID']);
if(!$order_id) {exit(error_message('Invalid order ID!', false));}

/* retrieve order info */
///////////////////////////
$where_id =" AND orders.id = {$order_id}";//change this to set select where
$order = getDataTable('orders',$where_id);
$docCategorie_id= makeSafe(sqlValue("select typeDoc from orders where id={$order_id}"));
///////////////////////////

if (!is_null($order['document'])){
    if (is_file($order['document'])){
        openpdf($order['document'], $order['document']);
    }
    return;
}

/* retrieve multycompany info */
///////////////////////////
$multyCompany_id=intval(sqlValue("select company from orders where id={$order_id}"));
$where_id =" AND companies.id={$multyCompany_id}";//change this to set select where
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

$filename = $company['companyCode']."_".$docCategorie_id."#".$order['multiOrder'].".pdf"; //pdf name

// shipper via

/* retrieve order items */
///////////////////////////
$item_fields = get_sql_fields('ordersDetails');
$item_from = get_sql_from('ordersDetails');
$items = sql("select {$item_fields} from {$item_from} and ordersDetails.order={$order_id}", $eo);
///////////////////////////

ob_start();
include_once("$currDir/header_old.php");
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

<!-- order items -->
<table class="table table-striped table-bordered">
		<thead>
			<th class="text-center">Nr.</th>
			<th>Articoli</th>
			<th class="text-center">Prezzo Un.</th>
			<th class="text-center">Quantità</th>
			<th class="text-center">Totale Linea</th>
		</thead>
		
		<tbody>
			<?php foreach($items as $i => $item){ ?>
				<tr>
					<td class="text-center"><?php echo ($i + 1); ?></td>
					<td><?php echo $item['productCode']; ?></td>
					<td class="text-right"><?php echo $item['UnitPrice']; ?></td>
					<td class="text-right"><?php echo $item['Quantity']; ?></td>
					<td class="text-right"><?php echo $item['LineTotal']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
		
		<tfoot>
			<tr>
				<th colspan="4" class="text-right">Subtotale</th>
				<th class="text-right">€<?php echo $order['orderTotal']; ?></th>
			</tr>
			<tr>
				<th colspan="4" class="text-right">Trasporto</th>
				<th class="text-right">€<?php echo $order['Freight']; ?></th>
			</tr>
			<tr>
				<th colspan="4" class="text-right">Totale</th>
				<th class="text-right">€<?php echo number_format($order_total + $order['Freight'], 2); ?></th>
			</tr>
		</tfoot>
	</table>

<?php
$html_code = ob_get_contents();
ob_end_clean();
//echo $html_code;

$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 5,
	'margin_right' => 5,
	'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10
]);
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Piattaforma Digitale Management System - Order");
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

sql("UPDATE `orders` SET `document` = '{$file}' WHERE id = {$order_id}",$eo);


openpdf($file, $filename);

function openpdf($file,$filename){
    
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');
    @readfile($file);
    return;
}