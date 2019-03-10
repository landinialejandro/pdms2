<?php
// 
// Author: Alejandro Landini
// REP_printDocument 31/7/18, 21:00
// 
//

$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
require "$currDir/vendor/autoload.php";

/* get order ID */
$order_id = intval($_REQUEST['OrderID']);

if(!$order_id) {exit(error_message('Invalid order ID!', false));}

/* retrieve order info */
///////////////////////////
$where_id =" AND orders.id = {$order_id}";//change this to set select where
$order = getDataTable('orders',$where_id);
$order_values = getDataTable_Values('orders',$where_id);

//if (!is_null($order['document'])){
//    if (is_file($order['document'])){
//        openpdf($order['document'], $order['document']);
//    }
//    return;
//}

/* retrieve multycompany info */

retCompanyData($company, $company_values, $order_values['company'], false);

retCompanyAddress($address, $address_values, $order_values['company'],false);

/* retrieve customer info */

retCompanyData($customer, $customer_values, $order_values['customer'],false);

retCompanyAddress($addressCustomer, $addressCustomer_values, $order_values['customer'],false);

/* shiping client address */
$where_id =" AND addresses.company = {$customer['id']} AND addresses.ship = 1";//change this to set select where
$addressCustomerShip = getDataTable('addresses',$where_id);

$filename = $company['companyCode']."_".$order_values['typeDoc']."#".$order['multiOrder'].".pdf"; //pdf name

// shipper via

/* retrieve order items */
///////////////////////////
$item_fields = get_sql_fields('ordersDetails');
$item_from = get_sql_from('ordersDetails');
$items = sql("select {$item_fields} from {$item_from} and ordersDetails.order={$order_id}", $eo);
///////////////////////////


//VERIFICAR EL MONTO TOTAL Y LA CANTIDAD DE INTEMS.
if ($items->num_rows <1){
    //not items
    exit(error_message('<h1>not items loads in order</h1>', false));
}


ob_start();
include("$currDir/REP_header.php");
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
                <h2><?php echo $company['companyName']; ?></h2>
            </th>
            <th align="right">
                <h3><?php echo $order_values['typeDoc']; ?> Nr. <?php echo $order['multiOrder']; ?></h3>
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
                VAT: <?php echo $company['vat']; ?><br>
                CF: <?php echo $company['fiscalCode']; ?>
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
			<?php foreach($items as $i => $item){ 
                                $where_id = "AND productCode = '{$item['productCode']}'";
                                $product = getDataTable('products', $where_id);
                            ?>
				<tr>
					<td class="text-center"><?php echo ($i + 1); ?></td>
					<td><?php echo $item['productCode'] . " - " . $product['productName']; ?></td>
					<td class="text-right"><?php echo $item['UnitPrice']; ?></td>
					<td class="text-right"><?php echo $item['Quantity']; ?></td>
					<td class="text-right"><?php echo $item['LineTotal']; ?></td>
				</tr>
			<?php } ?>
                                <tr>
                                    <td colspan="5"><hr></td>
                                </tr>
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
include("$currDir/REP_footer.php");
$html_code = ob_get_contents();
ob_end_clean();
echo $html_code;

$file = $currDir . '/PDFfolder/' . $filename;

//makePdf($html_code, $file);

sql("UPDATE `orders` SET `document` = '{$file}' WHERE id = {$order_id}",$eo);

//openpdf($file, $filename);
