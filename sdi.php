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
require "$currDir/vendor/autoload.php";

/* get order ID */
$order_id = intval($_REQUEST['id']);
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

include_once("$currDir/header_old.php");
$object = array(
    'FatturaElettronicaHeader' => array(
        'DatiTrasmissione' => array(
            'IdTrasmittente' => array(
                'IdPaese' => 'IT',
                'IdCodice' => '01234567890'
            ),
            'ProgressivoInvio' => '00001',
            'FormatoTrasmissione' => 'FPR12',
            'CodiceDestinatario' => '0000000',
            'PECDestinatario' => 'betagamma@pec.it'
        ),
        'CedentePrestatore' => array(
            'DatiAnagrafici' => array(
                'IdFiscaleIVA' => array(
                    'IdPaese' => "IT",
                    'IdCodice' => "01234567890"),
                'Anagrafica' => array(
                    'Denominazione' => "SOCIETA' ALPHA SRL"
                ),
                'RegimeFiscale' => "RF01"
            ),
            'Sede' => array(
                'Indirizzo' => 'VIALE ROMA 543',
                'CAP' => '07100',
                'Comune' => 'SASSARI',
                'Provincia' => 'SS',
                'Nazione' => 'IT'
            )
        ),
        'CessionarioCommittente' => array(
            'DatiAnagrafici' => array(
                'CodiceFiscale' => '09876543210',
                'Anagrafica' => array(
                    'Denominazione' => 'BETA GAMMA'
                )
            ),
            'Sede' => array(
                'Indirizzo' => 'VIA TORINO 38-B',
                'CAP' => '00145',
                'Comune' => 'ROMA',
                'Provincia' => 'RM',
                'Nazione' => 'IT'
            )
        )
    ),
    'FatturaElettronicaBody' => array(
        'DatiGenerali' => array(
            'DatiGeneraliDocumento' => array(
                'TipoDocumento' => 'TD01',
                'Divisa' => 'EUR',
                'Data' => '2014-12-18',
                'Numero' => '123',
                'Causale' => 'LA FATTURA FA RIFERIMENTO AD UNA OPERAZIONE AAAA BBBBBBBBBBBBBBBBBB CCC DDDDDDDDDDDDDDD E FFFFFFFFFFFFFFFFFFFF GGGGGGGGGG HHHHHHH II LLLLLLLLLLLLLLLLL MMM NNNNN OO PPPPPPPPPPP QQQQ RRRR SSSSSSSSSSSSSS',
                'Causale' => 'SEGUE DESCRIZIONE CAUSALE NEL CASO IN CUI NON SIANO STATI SUFFICIENTI 200 CARATTERI AAAAAAAAAAA BBBBBBBBBBBBBBBBB'
            ),
            'DatiOrdineAcquisto' => array(
                'RiferimentoNumeroLinea' => '1',
                'IdDocumento' => '66685',
                'NumItem' => '1'
            ),
            'DatiTrasporto' => array(
                'DatiAnagraficiVettore' => array(
                    'IdFiscaleIVA' => array(
                        'IdPaese' => 'IT',
                        'IdCodice' => '24681012141'
                    ),
                    'Anagrafica' => array(
                        'Denominazione' => 'Trasporto spa'
                    )
                ),
                'DataOraConsegna' => '2012-10-22T16:46:12.000+02:00'
            )
        ),
        'DatiBeniServizi' => array(
            'DettaglioLinee' => array(
                'NumeroLinea' => '1',
                'Descrizione' => "LA DESCRIZIONE DELLA FORNITURA PUO' SUPERARE I CENTO CARATTERI CHE RAPPRESENTAVANO IL PRECEDENTE LIMITE DIMENSIONALE. TALE LIMITE NELLA NUOVA VERSIONE E' STATO PORTATO A MILLE CARATTERI",
                'Quantita' => '5.00',
                'PrezzoUnitario' => "1.00",
                'PrezzoTotale' => "5.00",
                'AliquotaIVA' => "22.00"
            ),
            'DettaglioLinee' => array(
                'NumeroLinea' => "2",
                'Descrizione' => "FORNITURE VARIE PER UFFICIO",
                'Quantita' => "10.00",
                'PrezzoUnitario' => "2.00",
                'PrezzoTotale' => "20.00",
                'AliquotaIVA' => "22.00"
            ),
            'DatiRiepilogo' => array(
                'AliquotaIVA' => "22.00",
                'ImponibileImporto' => "25.00",
                'Imposta' => "5.50",
                'EsigibilitaIVA' => "D"
            )
        ),
        'DatiPagamento' => array(
            'CondizioniPagamento' => "TP01",
            'DettaglioPagamento' => array(
                'ModalitaPagamento' => "MP01",
                'DataScadenzaPagamento' => "2015-01-30",
                'ImportoPagamento' => "30.50"
            )
        )
    )
);

var_dump($object);
$result = generate_valid_xml_from_array($object);

   file_put_contents("xmlFiles/myxml.xml",$result);
   
function generate_valid_xml_from_array($array, $node_block='nodes', $node_name='node') {
	$xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";

	$xml .= '<p:FatturaElettronica versione="FPR12" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd">'."\n";
	$xml .= generate_xml_from_array($array, $node_name);
	$xml .= '</p:FatturaElettronica>'."\n";

	return $xml;
}

function generate_xml_from_array($array, $node_name) {
    $xml = '';

    if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                    if (is_numeric($key)) {
                            $key = $node_name;
                    }

                    $xml .= '<' . $key . '>' . "\n" . generate_xml_from_array($value, $node_name) . '</' . $key . '>' . "\n";
            }
    } else {
            $xml = htmlspecialchars($array, ENT_QUOTES) . "\n";
    }

    return $xml;
}
