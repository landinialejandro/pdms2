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
    exit(error_message('The invoice file exist, you can\'t make a new xml file after print invoice.', false));
}

if($kindOrder !== 'OUT'){
    exit(error_message('<h1>order not valid</h1>' . $order['kind'], false));
}

/* retrieve multycompany info */
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$multyCompany_id=intval(sqlValue("select company from orders where id={$order_id}"));
$where_id =" AND companies.id={$multyCompany_id}";//change this to set select where
$company = getDataTable('companies',$where_id);

$where_id =" AND addresses.company = {$company['id']} AND addresses.default = 1";//change this to set select where
$address = getDataTable('addresses',$where_id);
if (!$address){
    exit(error_message('<h1>Adrress order not valid</h1>', false));
}
$addressCountryId = sqlValue("select country from addresses where addresses.id = {$address['id']}");
$countryCode = sqlValue("select code from countries where countries.id = {$addressCountryId} ");

$where_id =" AND mails.company = {$company['id']} AND mails.kind = 'WORK'";//change this to set select where
$mails = getDataTable('mails',$where_id);

$codiceDestinatarioId = intval(sqlValue("select codiceDestinatario from companies where companies.id = $multyCompany_id"));
$codiceDestinatario = sqlValue("select code from codiceDestinatario where codiceDestinatario.id = $codiceDestinatarioId");

$defualtContactId = intval(sqlValue("SELECT contacts_companies.contact FROM contacts_companies WHERE contacts_companies.company = {$multyCompany_id} ORDER BY contacts_companies.default DESC LIMIT 1"));
if (!$defualtContactId){
    exit(error_message('<h1>Contact company not setting</h1>', false));
}
$where_id = " AND  id = {$defualtContactId}";
$contact = getDataTable("contacts", $where_id);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
    exit(error_message('<h1>order Customer not valid</h1>', false));
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
    exit(error_message('<h1>order Shipper not valid</h1>', false));
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
        <!-- 1.1 -->
        <DatiTrasmissione>
            <IdTrasmittente>
                <IdPaese>{$countryCode}</IdPaese> <!-- SI, sempre -->
                <IdCodice>{$company['vat']}</IdCodice> <!-- SI, sempre -->
            </IdTrasmittente>
            <ProgressivoInvio>{$order['multiOrder']}</ProgressivoInvio> <!-- SI, sempre -->
            <FormatoTrasmissione>FPR12</FormatoTrasmissione> <!-- SI, sempre -->
            <CodiceDestinatario>{$codiceDestinatario}</CodiceDestinatario> <!-- SI, sempre -->
            <ContattiTrasmittente>
                <Telefono></Telefono> <!-- NO -->
                <Email>{$mails['mail']}</Email> <!-- NO -->
            </ContattiTrasmittente>
            <PECDestinatario>mailCliente@via.PEC</PECDestinatario> <!-- SI, ma solo se -->
        </DatiTrasmissione>
        <!-- 1.2 -->
        <CedentePrestatore>
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese>{$countryCode}</IdPaese> <!-- obligatory -->
                    <IdCodice>{$company['vat']}</IdCodice> <!-- obligatory -->
                </IdFiscaleIVA>
                <CodiceFiscale>{$company['vat']}</CodiceFiscale> <!-- Consigliata -->
                <Anagrafica>
                    <Denominazione>{$company['companyName']}</Denominazione> <!-- SI, ma solo se --> 
                    <Nome>{$contact['name']}</Nome> <!-- SI, ma solo se -->
                    <Cognome>{$contact['lastName']}</Cognome> <!-- SI, ma solo se -->
                    <Titolo>{$contact['title']}</Titolo> <!-- NO -->
                    <codEORI>{$contact['CodEORI']}</codEORI> <!-- NO -->
                </Anagrafica>
                <AlboProfessionale></AlboProfessionale> <!-- NO -->
                <ProvinciaAlbo></ProvinciaAlbo> <!-- NO -->
                <NumeroIscrizioneAlbo></NumeroIscrizioneAlbo> <!-- NO -->
                <DataIscrizioneAlbo></DataIscrizioneAlbo> <!-- NO -->
                <RegimeFiscale>{$company['regimeFiscale']}</RegimeFiscale> <!-- obligatory -->
            </DatiAnagrafici>
            <Sede>
                <Indirizzo>{$address['address']}</Indirizzo> <!-- obligatory -->
                <NumeroCivico>{$address['houseNumber']}</NumeroCivico> <!-- SI, ma solo se -->
                <CAP>{$address['postalCode']}</CAP> <!-- obligatory -->
                <Comune>{$address['town']}</Comune> <!-- obligatory -->
                <Provincia>{$address['district']}</Provincia> <!-- SI, ma solo se -->
                <Nazione>{$address['country']}</Nazione> <!-- obligatory -->
            </Sede>
            <StabileOrganizzazione> <!-- 1.2.3  il cedente/prestatore è un soggetto che non risiede in Italia ma che, in Italia,
                                                dispone di una stabile organizzazione attraverso la quale svolge la propria
                                                attività (cessioni di beni o prestazioni di servizi oggetto di fatturazione)
                                    -->
                <Indirizzo></Indirizzo> <!-- SI, ma solo se -->
                <NumeroCivico></NumeroCivico><!-- SI, ma solo se -->
                <CAP></CAP> <!-- SI, ma solo se -->
                <Comune></Comune> <!-- SI, ma solo se -->
                <Provincia></Provincia> <!-- SI, ma solo se -->
                <Nazione></Nazione> <!-- SI, ma solo se -->
            </StabileOrganizzazione>
            <IscrizioneREA> <!-- 1.2.4  il cedente/prestatore è una società iscritta nel registro delle imprese e come
                                        tale ha l’obbligo di indicare in tutti i documenti anche i dati relativi all’iscrizione
                                        (art. 2250 codice civile)
                            -->
                <Ufficio></Ufficio> 
                <NumeroREA></NumeroREA> 
                <CapitaleSociale></CapitaleSociale> 
                <SocioUnico></SocioUnico> 
                <StatoLiquidazione></StatoLiquidazione> 
            </IscrizioneREA> 
            <Contatti>
                <Telefono></Telefono> 
                <Fax></Fax> 
                <Email></Email> 
            </Contatti> 
            <RiferimentoAmministrazione></RiferimentoAmministrazione> 
        </CedentePrestatore>
        <!-- 1.3 -->
        <RappresentanteFiscale>
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese></IdPaese> 
                    <IdCodice></IdCodice> 
                </IdFiscaleIVA> 
                <Anagrafica>
                    <Denominazione></Denominazione> 
                    <Nome></Nome> 
                    <Cognome></Cognome> 
                    <Titolo></Titolo> 
                    <CodEORI></CodEORI> 
                </Anagrafica> 
            </DatiAnagrafici> 
        </RappresentanteFiscale>
        <!-- 1.4 -->
        <CessionarioCommittente> 
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese></IdPaese> 
                    <IdCodice></IdCodice> 
                </IdFiscaleIVA> 
                <CodiceFiscale>{$customer['vat']}</CodiceFiscale> 
                <Anagrafica>
                    <Denominazione>{$customer['companyName']}</Denominazione> 
                    <Nome></Nome> 
                    <Cognome></Cognome> 
                    <Titolo></Titolo> 
                    <CodEORI></CodEORI> 
                </Anagrafica>
            </DatiAnagrafici>
            <Sede>
                <Indirizzo>{$addressCustomer['address']} {$addressCustomer['houseNumber']}</Indirizzo> 
                <NumeroCivico></NumeroCivico>
                <CAP>{$addressCustomer['postalCode']}</CAP> 
                <Comune>{$addressCustomer['town']}</Comune> 
                <Provincia>{$addressCustomer['district']}</Provincia> 
                <Nazione>{$addressCustomer['country']}</Nazione> 
            </Sede>
        </CessionarioCommittente>
        <!-- 1.5 -->
        <TerzoIntermediarioOSoggettoEmittente>
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese></IdPaese> 
                    <IdCodice></IdCodice> 
                </IdFiscaleIVA> 
                <CodiceFiscale></CodiceFiscale> 
                <Anagrafica>
                    <Denominazione></Denominazione> 
                    <Nome></Nome> 
                    <Cognome></Cognome> 
                    <Titolo></Titolo> 
                    <CodEORI></CodEORI> 
                </Anagrafica>
            </DatiAnagrafici>
        </TerzoIntermediarioOSoggettoEmittente>
        <!-- 1.6 -->
        <SoggettoEmittente></SoggettoEmittente> 
    </FatturaElettronicaHeader>
    <FatturaElettronicaBody>
        <!-- 2.1 -->
        <DatiGenerali>
            <DatiGeneraliDocumento>
                <TipoDocumento>TD01</TipoDocumento> 
                <Divisa>EUR</Divisa> 
                <Data>{$order['sellDate']}</Data> 
                <Numero>{$order['multiOrder']}</Numero> 
                <DatiRitenuta>
                    <TipoRitenuta></TipoRitenuta> 
                    <ImportoRitenuta></ImportoRitenuta> 
                    <AliquotaRitenuta></AliquotaRitenuta> 
                    <CausalePagamento></CausalePagamento> 
                </DatiRitenuta> 
                <DatiBollo>
                    <NumeroBollo></NumeroBollo> 
                    <ImportoBollo></ImportoBollo> 
                </DatiBollo> 
                <DatiCassaPrevidenziale>
                    <TipoCassa></TipoCassa> 
                    <AlCassa></AlCassa> 
                    <ImportoContributoCassa></ImportoContributoCassa> 
                    <ImponibileCassa></ImponibileCassa> 
                    <AliquotaIVA></AliquotaIVA> 
                    <Ritenuta></Ritenuta> 
                    <Natura></Natura> 
                    <RiferimentoAmministrazione></RiferimentoAmministrazione> 
                </DatiCassaPrevidenziale> 
                <ScontoMaggiorazione>
                    <Tipo></Tipo> 
                    <Percentuale></Percentuale> 
                    <Importo></Importo> 
                </ScontoMaggiorazione> 
                <ImportoTotaleDocumento></ImportoTotaleDocumento> 
                <Arrotondamento></Arrotondamento> 
                <Causale>LA FATTURA FA RIFERIMENTO AD UNA OPERAZIONE</Causale> 
                <Art73></Art73> 
            </DatiGeneraliDocumento>
            <DatiOrdineAcquisto>
                <RiferimentoNumeroLinea>1</RiferimentoNumeroLinea> 
                <IdDocumento>66685</IdDocumento> 
                <Data></Data> 
                <NumItem>1</NumItem> 
                <CodiceCommessaConvenzione></CodiceCommessaConvenzione> 
                <CodiceCUP></CodiceCUP> 
            </DatiOrdineAcquisto>
            <DatiContratto></DatiContratto> 
            <DatiConvenzione></DatiConvenzione> 
            <DatiRicezione></DatiRicezione> 
            <DatiFattureCollegate></DatiFattureCollegate> 
            <DatiSAL>
                <RiferimentoFase></RiferimentoFase> 
            </DatiSAL> 
            <DatiDDT>
                <NumeroDDT></NumeroDDT> 
                <DataDDT></DataDDT> 
                <RiferimentoNumeroLinea></RiferimentoNumeroLinea> 
            </DatiDDT> 
            <DatiTrasporto>
                <DatiAnagraficiVettore>
                    <IdFiscaleIVA>
                        <IdPaese>IT</IdPaese> 
                        <IdCodice>24681012141</IdCodice> 
                    </IdFiscaleIVA>
                    <Anagrafica>
                        <Denominazione>{$shipper['companyName']}</Denominazione> 
                        <Nome></Nome> 
                        <Cognome></Cognome> 
                        <Titolo></Titolo> 
                    </Anagrafica>
                    <NumeroLicenzaGuida></NumeroLicenzaGuida>
                </DatiAnagraficiVettore>
                <MezzoTrasporto></MezzoTrasporto>
                <CausaleTrasporto></CausaleTrasporto>
                <NumeroColli></NumeroColli>
                <Descrizione></Descrizione>
                <UnitaMisuraPeso></UnitaMisuraPeso>
                <PesoLordo></PesoLordo>
                <PesoNetto></PesoNetto>
                <DataOraRitiro></DataOraRitiro>
                <DataInizioTrasporto></DataInizioTrasporto>
                <TipoResa></TipoResa>
                <IndirizzoResa>
                    <Indirizzo></Indirizzo> 
                    <NumeroCivico></NumeroCivico>
                    <CAP></CAP> 
                    <Comune></Comune> 
                    <Provincia></Provincia> 
                    <Nazione></Nazione> 
                </IndirizzoResa>
                <DataOraConsegna>{$order['consigneeHour']}</DataOraConsegna> 
            </DatiTrasporto>
            <NormaDiRiferimento></NormaDiRiferimento> 
            <FatturaPrincipale>
                <NumeroFatturaPrincipale></NumeroFatturaPrincipale> 
                <DataFatturaPrincipale></DataFatturaPrincipale> 
            </FatturaPrincipale> 
        </DatiGenerali>
        <!-- 2.2 -->
        <DatiBeniServizi>
        </DatiBeniServizi>
        <!-- 2.3 -->
        <DatiVeicoli>
            <Data></Data> 
            <TotalePercorso></TotalePercorso> 
        </DatiVeicoli> 
        <!-- 2.4 -->
        <DatiPagamento>
            <CondizioniPagamento>TP01</CondizioniPagamento> 
            <DettaglioPagamento>
                <Beneficiario></Beneficiario> 
                <ModalitaPagamento>MP01</ModalitaPagamento> 
                <DataRiferimentoTerminiPagamento></DataRiferimentoTerminiPagamento> 
                <GiorniTerminiPagamento></GiorniTerminiPagamento> 
                <DataScadenzaPagamento>2015-01-30</DataScadenzaPagamento> 
                <ImportoPagamento>30.50</ImportoPagamento> 
                <CodUfficioPostale></CodUfficioPostale> 
                <CognomeQuietanzante></CognomeQuietanzante> 
                <NomeQuietanzante></NomeQuietanzante> 
                <CFQuietanzante></CFQuietanzante> 
                <TitoloQuietanzante></TitoloQuietanzante> 
                <IstitutoFinanziario></IstitutoFinanziario> 
                <IBAN></IBAN> 
                <ABI></ABI> 
                <CAB></CAB> 
                <BIC></BIC> 
                <ScontoPagamentoAnticipato></ScontoPagamentoAnticipato> 
                <DataLimitePagamentoAnticipato></DataLimitePagamentoAnticipato> 
                <PenalitaPagamentiRitardati></PenalitaPagamentiRitardati> 
                <DataDecorrenzaPenale></DataDecorrenzaPenale> 
                <CodicePagamento></CodicePagamento> 
            </DettaglioPagamento>
        </DatiPagamento>
        <!-- 2.5 -->
        <Allegati>
            <NomeAttachment></NomeAttachment> 
            <AlgoritmoCompressione></AlgoritmoCompressione> 
            <FormatoAttachment></FormatoAttachment> 
            <DescrizioneAttachment></DescrizioneAttachment> 
            <Attachment></Attachment> 
        </Allegati> 
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
    $productId = intval(sqlValue("select ordersDetails.productCode from ordersDetails where ordersDetails.id = {$item['id']} "));
    if (!$productId){
        echo '<div class="alert alert-danger alert-dismissible"><h1>product id not valid: '. $productId.'/'.$item['id'].'</h1></div>';
    }
    $where_id = " AND products.id = $productId";
    $product = getDataTable("products", $where_id);
    $categoryId = sqlValue("select products.CategoryID from products where products.id = {$product['id']}");
    $categoryData = getKindsData($categoryId);
    
    $DettaglioLinee = $DatiBeniServizi->addChild("DettaglioLinee");
        $DettaglioLinee->addChild("NumeroLinea",$i+1);
        $DettaglioLinee->addChild("TipoCessionePrestazione",$item['Discount']? "SC" : "");
        $CodiceArticolo = $DettaglioLinee->addChild("CodiceArticolo");//two childs
            $CodiceArticolo->addChild("CodiceTipo",$categoryData['code']);
            $CodiceArticolo->addChild("CodiceValore",$item['productCode']);
        
        $DettaglioLinee->addChild("Descrizione",$product['productName']);
        $DettaglioLinee->addChild("Quantita",$item['QuantityReal']);
        $DettaglioLinee->addChild("UnitaMisura",$product['UM']);
        $DettaglioLinee->addChild("DataInizioPeriodo","");
        $DettaglioLinee->addChild("DataFinePeriodo","");
        $DettaglioLinee->addChild("PrezzoUnitario",number_format($item['UnitPriceValue'] , 2));
        $ScontoMaggiorazione = $DettaglioLinee->addChild("ScontoMaggiorazione");//tree childs
            $ScontoMaggiorazione->addChild("Tipo",$item['Discount']? "SC" : "");
            $ScontoMaggiorazione->addChild("Percentuale",number_format($item['Discount'] , 2));
            $ScontoMaggiorazione->addChild("Importo",number_format($item['SubtotalValue']*$item['Discount']/100 , 2));
            
        $DettaglioLinee->addChild("PrezzoTotale",number_format($item['SubtotalValue'] , 2));
        $DettaglioLinee->addChild("AliquotaIVA",number_format($item['taxesValue'] , 2));
        $DettaglioLinee->addChild("Ritenuta","");
        $DettaglioLinee->addChild("Natura","");
        $DettaglioLinee->addChild("RiferimentoAmministrazione","");
        $AltriDatiGestionali = $DettaglioLinee->addChild("AltriDatiGestionali");//four childs
            $ScontoMaggiorazione->addChild("TipoDato","");
            $ScontoMaggiorazione->addChild("RiferimentoTesto","");
            $ScontoMaggiorazione->addChild("RiferimentoNumero","");
            $ScontoMaggiorazione->addChild("RiferimentoData","");
        
    $inponibiliTotale = $inponibiliTotale + $item['SubtotalValue'];
    $taxesTotales = $taxesTotales + $item['taxesValue'];
}
///////////////////////////

    $DatiRiepilogo = $DatiBeniServizi->addChild("DatiRiepilogo");
        $DatiRiepilogo->addChild("AliquotaIVA","4.00");
        $DatiRiepilogo->addChild("Natura","");
        $DatiRiepilogo->addChild("SpeseAccessorie","");
        $DatiRiepilogo->addChild("Arrotondamento","");
        $DatiRiepilogo->addChild("ImponibileImporto",number_format($inponibiliTotale , 2));
        $DatiRiepilogo->addChild("Imposta",number_format($taxesTotales , 2));
        $DatiRiepilogo->addChild("EsigibilitaIVA","D");
        $DatiRiepilogo->addChild("RiferimentoNormativo","");
    
//saving generated xml file
$xml_file = $xml_invoice->asXML('xmlFiles/users.xml');

//success and error message based on xml creation
if($xml_file){
            $msg = '<div class="alert alert-success"><h1>
                XML file have been generated successfully.
            </h1></div>';
    echo $msg;
    $link = "<script>window.open('xmlFiles/users.xml')</script>";
    echo $link;
    
}else{
    exit(error_message('XML file generation error.', false));
}