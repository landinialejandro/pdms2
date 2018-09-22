<?php
// 
// Author: Alejandro Landini
// _printReport 31/7/18, 21:00
// 
// GET parameteres for print documents
// 
// toDo: 
// revision: *25/08/18 add cusotmer data
// 
//
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
require "$currDir/vendor/autoload.php";


/* grant access to all users who have access to the orders table */
$order_from = get_sql_from('orders');
if(!$order_from) exit(error_message('Access denied!', false));

/* get order ID */
$order_id = intval($_REQUEST['OrderID']);
if(!$order_id) exit(error_message('Invalid order ID!', false));

/* retrieve order info */
$order_fields = get_sql_fields('orders');
$res = sql("select {$order_fields} from {$order_from} and orders.id={$order_id}", $eo);
if(!($order = db_fetch_assoc($res))) exit(error_message('Order not found!', false));

//var_dump($order);

$docCategorie_id= makeSafe(sqlValue("select typeDoc from orders where id={$order_id}"));
//$docCategorie_idDocument=sqlvalue("select idDocument from docCategories where id={$docCategorie_id}");

/* retrieve multycompany info */
$multyCompany_id=intval(sqlValue("select company from orders where id={$order_id}"));
$multyCompany_from= get_sql_from('companies');
$multyCompany_fields = get_sql_fields('companies');

$res = sql("select {$multyCompany_fields} from {$multyCompany_from} and companies.id={$multyCompany_id}", $eo);
if(!($company = db_fetch_assoc($res))) exit(error_message('Company Data not found!', false));

//var_dump($company);

/* retrieve customer info */
$customer_id = intval(sqlValue("select customer from orders where orders.id={$order_id}"));
$customers_from = get_sql_from('companies');
$customers_fields = get_sql_fields('companies');
$res = sql("select {$customers_fields} from {$customers_from} and companies.id={$customer_id}", $eo);
    if(!($customer = db_fetch_assoc($res))) exit(error_message('Customer not found!', false));

//var_dump($customer);

/* retrieve order items */
$items = array();
$order_total = 0;
$item_fields = get_sql_fields('ordersDetails');
$item_from = get_sql_from('ordersDetails');
$res = sql("select {$item_fields} from {$item_from} and ordersDetails.order={$order_id}", $eo);
while($row = db_fetch_assoc($res)){
        $row['LineTotal'] = str_replace('$', '', $row['UnitPrice']) * $row['Quantity'];
        $items[] = $row;
        $order_total += $row['LineTotal'];
}

//var_dump($items);

ob_start();
include_once("$currDir/header.php");
?>
<!-- insert HTML code table version-->
<!-- MultyCompy data-->
                
<table border="0" width="100%">
    <thead>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>
                <h1><?php echo $company['company']; ?></h1>
            </th>
            <th align="right">
                <h1><?php echo $order['typeDoc']; ?></h1>
            </th>
        </tr>
        <tr>
            <td>
                <h4>Address: <?php echo $company['address']; ?></h4>
            </td>
            <td align="right">
                <h5>Date: <?php echo $order['OrderDate']; ?></h5>
            </td>
        </tr>
        <tr>
            <td>
                <h4><?php echo $company['address2']; ?></h4>
            </td>
            <td align="right">
                <h5><?php echo $docCategorie_idDocument; ?> Nr. <?php echo $order['multiOrder']; ?></h5>
            </td>
        </tr>
        <tr>
            <td>
                <h4>PC: <?php echo $company['postalCode']; ?></h4>
            </td>
            <td align="right">
            </td>
        </tr>
        <tr>
            <td>
                <h4>Town: <?php echo $company['town']; ?></h4>
            </td>
            <td align="right">
            </td>
        </tr>
        <tr>
            <td>
                <h4>VAT: <?php echo $company['vatNumber']; ?></h4>
            </td>
            <td align="right">
            </td>
        </tr>
    </tbody>
</table>
<hr>
<!-- MultyCompy data-->

<table border="0">
    <thead>
        <tr>
            <th><H3>Cliente</H3></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Company Name: <?php echo $customer['companyName']; ?></td>
        </tr>
        <tr>
            <td>Address: <?php echo $customer['address']; ?></td>
        </tr>
        <tr>
            <td>VAT: <?php echo $customer['vatNumber']; ?></td>
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
					<td class="text-right">€<?php echo number_format($item['LineTotal'], 2); ?></td>
				</tr>
			<?php } ?>
		</tbody>
		
		<tfoot>
			<tr>
				<th colspan="4" class="text-right">Subtotale</th>
				<th class="text-right">€<?php echo number_format($order_total, 2); ?></th>
			</tr>
			<tr>
				<th colspan="4" class="text-right">Trasporto</th>
				<th class="text-right">€<?php echo number_format($order['Freight'], 2); ?></th>
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
$mpdf->Output();

//include_once("$currDir/footer.php");

