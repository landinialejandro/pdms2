<?php
// 
// Author: Alejandro Landini
// 
// 
// toDo: 
// revision:
// 
//
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");

/* get order ID */
$order_id = intval($_REQUEST['id']);
if(!$order_id) {exit(error_message('Invalid order ID!', false));}

/* retrieve order info */
///////////////////////////
$where_id =" AND orders.id = {$order_id}";//change this to set select where
$order = getDataTable('orders',$where_id);
$docCategorie_id= makeSafe(sqlValue("select typeDoc from orders where id={$order_id}"));
$kindOrder = sqlValue("select kind from orders where id={$order_id}");
///////////////////////////

if (!is_null($order['document'])){
    echo 'The invoice file exist, you can\'t make a new xml file after print invoice.';
    return;
}

if($kindOrder !== 'OUT'){
    echo '<h1>order not valid</h1>' . $order['kind'];
    return ;
}

/* retrieve multycompany info */
///////////////////////////
$multyCompany_id=intval(sqlValue("select company from orders where id={$order_id}"));
$where_id =" AND companies.id={$multyCompany_id}";//change this to set select where
$company = getDataTable('companies',$where_id);
///////////////////////////
$where_id =" AND addresses.company = {$company['id']} AND addresses.default = 1";//change this to set select where
$address = getDataTable('addresses',$where_id);
var_dump($address);
if (!$address){
    echo '<h1>Adrress order not valid</h1>';
    return;
}
$addressCountryId = sqlValue("select country from addresses where addresses.id = {$address['id']}");
$countryCode = sqlValue("select code from countries where countries.id = {$addressCountryId} ");
///////////////////////////
$where_id =" AND mails.company = {$company['id']} AND mails.kind = 'WORK'";//change this to set select where
$mails = getDataTable('mails',$where_id);
$codiceDestinatarioId = intval(sqlValue("select codiceDestinatario from companies where companies.id = $multyCompany_id"));
$codiceDestinatario = sqlValue("select code from codiceDestinatario where codiceDestinatario.id = $codiceDestinatarioId");
///////////////////////////

/* retrieve customer info */
///////////////////////////
$customer_id = intval(sqlValue("select customer from orders where orders.id={$order_id}"));
if ($customer_id){
    $where_id=" AND companies.id = {$customer_id}";
    $customer = getDataTable('companies',$where_id);
    ///////////////////////////Client address
    $where_id =" AND addresses.company = {$customer['id']} AND addresses.default = 1";//change this to set select where
    $addressCustomer = getDataTable('addresses',$where_id);

    ///////////////////////////shiping client address
    $where_id =" AND addresses.company = {$customer['id']} AND addresses.ship = 1";//change this to set select where
    $addressCustomerShip = getDataTable('addresses',$where_id);
    ///////////////////////////
}else{
    echo '<h1>order Customer not valid</h1>';
    return;
}

// shipper via
$shipper_id = intVal(sqlValue("select shipVia from orders where orders.id ={$order_id}"));
if ($shipper_id){
    $where_id=" AND companies.id = {$shipper_id}";
    $shipper = getDataTable('companies',$where_id);
    ///////////////////////////Client address
    $where_id =" AND addresses.company = {$shipper['id']} AND addresses.default = 1";//change this to set select where
    $addressShipper = getDataTable('addresses',$where_id);
}else{
    echo '<h1>order Shipper not valid</h1>';
    return;
}


$invoice=<<<XML
<?xml version="1.0" encoding="UTF-8" ?> 
<p:FatturaElettronica 
    versione="FPR12" 
    xmlns:ds="http://www.w3.org/2000/09/xmldsig#" 
    xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:schemaLocation="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd"
>
    <FatturaElettronicaHeader>
        <DatiTrasmissione>
            <IdTrasmittente>
                <IdPaese>{$countryCode}</IdPaese> 
                <IdCodice>{$company['vat']}</IdCodice> 
            </IdTrasmittente>
            <ProgressivoInvio>{$order['multiOrder']}</ProgressivoInvio> 
            <FormatoTrasmissione>SDI10</FormatoTrasmissione> 
            <CodiceDestinatario>{$codiceDestinatario}</CodiceDestinatario> 
            <PECDestinatario>{$mails['mail']}</PECDestinatario> 
        </DatiTrasmissione>
        <CedentePrestatore>
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese>{$countryCode}</IdPaese> 
                    <IdCodice>{$company['vat']}</IdCodice> 
                </IdFiscaleIVA>
                <Anagrafica>
                    <Denominazione>{$company['companyName']}</Denominazione> 
                    <Nome></Nome>
                    <Cognome></Cognome>
                    <Titolo></Titolo>
                    <codEORI></codEORI>
                </Anagrafica>
                <RegimeFiscale>RF01</RegimeFiscale> 
            </DatiAnagrafici>
            <Sede>
                <Indirizzo>{$address['address']} {$address['houseNumber']}</Indirizzo> 
                <CAP>{$address['postalCode']}</CAP> 
                <Comune>{$address['town']}</Comune> 
                <Provincia>{$address['district']}</Provincia> 
                <Nazione>{$address['country']}</Nazione> 
            </Sede>
        </CedentePrestatore>
        <CessionarioCommittente>
            <DatiAnagrafici>
                <CodiceFiscale>{$customer['vat']}</CodiceFiscale> 
                <Anagrafica>
                    <Denominazione>{$customer['companyName']}</Denominazione> 
                </Anagrafica>
            </DatiAnagrafici>
            <Sede>
                <Indirizzo>{$addressCustomer['address']} {$addressCustomer['houseNumber']}</Indirizzo> 
                <CAP>{$addressCustomer['postalCode']}</CAP> 
                <Comune>{$addressCustomer['town']}</Comune> 
                <Provincia>{$addressCustomer['district']}</Provincia> 
                <Nazione>{$addressCustomer['country']}</Nazione> 
            </Sede>
        </CessionarioCommittente>
    </FatturaElettronicaHeader>
    <FatturaElettronicaBody>
        <DatiGenerali>
            <DatiGeneraliDocumento>
                <TipoDocumento>TD01</TipoDocumento> 
                <Divisa>EUR</Divisa> 
                <Data>{$order['sellDate']}</Data> 
                <Numero>{$order['multiOrder']}</Numero> 
                <Causale>LA FATTURA FA RIFERIMENTO AD UNA OPERAZIONE</Causale> 
                <Causale>SEGUE DESCRIZIONE CAUSALE NEL CASO IN CUI NON SIANO STATI SUFFICIENTI 200 CARATTERI</Causale> 
            </DatiGeneraliDocumento>
            <DatiOrdineAcquisto>
                <RiferimentoNumeroLinea>1</RiferimentoNumeroLinea> 
                <IdDocumento>66685</IdDocumento> 
                <NumItem>1</NumItem> 
            </DatiOrdineAcquisto>
            <DatiTrasporto>
                <DatiAnagraficiVettore>
                    <IdFiscaleIVA>
                        <IdPaese>IT</IdPaese> 
                        <IdCodice>24681012141</IdCodice> 
                    </IdFiscaleIVA>
                    <Anagrafica>
                        <Denominazione>{$shipper['companyName']}</Denominazione> 
                    </Anagrafica>
                </DatiAnagraficiVettore>
                <DataOraConsegna>{$order['consigneeHour']}</DataOraConsegna> 
            </DatiTrasporto>
        </DatiGenerali>
        <DatiBeniServizi>
        </DatiBeniServizi>
        <DatiPagamento>
            <CondizioniPagamento>TP01</CondizioniPagamento> 
            <DettaglioPagamento>
                <ModalitaPagamento>MP01</ModalitaPagamento> 
                <DataScadenzaPagamento>2015-01-30</DataScadenzaPagamento> 
                <ImportoPagamento>30.50</ImportoPagamento> 
            </DettaglioPagamento>
        </DatiPagamento>
    </FatturaElettronicaBody>
</p:FatturaElettronica>
        
XML;


//creating object of SimpleXMLElement
$xml_invoice = new SimpleXMLElement($invoice);

$DatiBeniServizi = $xml_invoice->FatturaElettronicaBody->DatiBeniServizi;

/* retrieve order items */
///////////////////////////
$item_fields = get_sql_fields('ordersDetails');
$item_from = get_sql_from('ordersDetails');
$items = sql("select {$item_fields} from {$item_from} and ordersDetails.order={$order_id}", $eo);
foreach($items as $i => $item){
    $DettaglioLinee = $DatiBeniServizi->addChild("DettaglioLinee");
        $DettaglioLinee->addChild("NumeroLinea",$i+1);
        $DettaglioLinee->addChild("Descrizione",$item['productCode']);
        $DettaglioLinee->addChild("Quantita",$item['QuantityReal']);
        $DettaglioLinee->addChild("PrezzoUnitario",$item['UnitPriceValue']);
        $DettaglioLinee->addChild("PrezzoTotale",$item['SubtotalValue']);
        $DettaglioLinee->addChild("AliquotaIVA",$item['taxesValue']);
    $inponibiliTotale = $inponibiliTotale + $item['SubtotalValue'];
    $taxesTotales = $taxesTotales + $item['taxesValue'];
}
///////////////////////////

    $DatiRiepilogo = $DatiBeniServizi->addChild("DatiRiepilogo");
        $DatiRiepilogo->addChild("AliquotaIVA","4.00");
        $DatiRiepilogo->addChild("ImponibileImporto",$inponibiliTotale);
        $DatiRiepilogo->addChild("Imposta",$taxesTotales);
        $DatiRiepilogo->addChild("EsigibilitaIVA","D");
    
//saving generated xml file
$xml_file = $xml_invoice->asXML('xmlFiles/users.xml');

//success and error message based on xml creation
if($xml_file){
    echo 'XML file have been generated successfully.';
    $link = "<script>window.open('xmlFiles/users.xml')</script>";
    echo $link;
    
}else{
    echo 'XML file generation error.';
}
