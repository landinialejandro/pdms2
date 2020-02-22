<?php
//  
// Author: Alejandro Landini
// REP_printSummaryDocument.php 25/8/18, 10:00
// 
//

if (isset($_REQUEST['id'])){

    $order_id = intval($_REQUEST['id']);
    if(!$order_id) exit(error_message('Invalid order ID!', false));

    $currDir = dirname(__FILE__);
    include("$currDir/defaultLang.php");
    include("$currDir/language.php");
    include("$currDir/lib.php");
    include_once("$currDir/hooks/orders.php");
    printDocument($order_id);
}


function printDocument($recID){
    $currDir = dirname(__FILE__);
    require "$currDir/vendor/autoload.php";
    
    // print order
    $where_id = "AND orders.id = $recID";
    $order = getDataTable('orders', $where_id);
    $order_values = getDataTable_Values('orders', $where_id);

    $multiOrder = $newOrder_values['multiOrder'];

    /* retrieve multycompany info */
    
    retCompanyData($company,$company_values,$order_values['company'], false);

    retCompanyAddress($address, $address_values, $order_values['company'], false);
    

    $filename = $company['companyCode']."_".$orderTypeId."#".$multiOrder.".pdf"; //pdf name

    /* retrieve customer info */

    retCompanyData($customer,$customer_values,$order_values['customer'], false);

    retCompanyAddress($addressCustomer, $addressCustomer_values, $order_values['customer'], false);
    
    /* shiping client address */

    $where_id =" AND addresses.company = {$customer['id']} AND addresses.ship = 1"; //change this to set select where
    $addressCustomerShip = getDataTable('addresses',$where_id);

    
    /* retrieve order items */
    $where_id = "AND ordersDetails.order = {$recID}";
    $table_name = 'ordersDetails';
    $table_from = get_sql_from($table_name);
    $table_fields = get_sql_fields($table_name);
    $where_id = "" ? "" : " " . $where_id;
    $sql="SELECT {$table_fields} FROM {$table_from}" . $where_id;
    $items = sql($sql, $eo);


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
                    <h1><?php echo $company['companyName']; ?></h1>
                </th>
                <th align="right">
                    <h2><?php echo $order['typeDoc']; ?> Nr. <?php echo $order['multiOrder']; ?></h2>
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
                $where_id =" AND productCode = {$item['productCode']}";//change this to set select where
                $product = getDataTable('products',$where_id);
                $numDDT = sqlvalue("select multiOrder from orders where id = {$item['related']} ")
                ?>
                    <tr>
                        <td><?php echo $numDDT; ?></td>
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
                        <th class="text-right">€<?php echo number_format($order['orderTotal'], 2); ?></th>
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
    //
    //openpdf($file, $filename);
}