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
$defualtContactId = intval(sqlValue("SELECT contacts_companies.contact FROM contacts_companies WHERE contacts_companies.company = {$multyCompany_id} ORDER BY contacts_companies.default DESC LIMIT 1"));
if (!$defualtContactId){
    echo '<h1>Contact company not setting</h1>';
    return;
}
$where_id = " AND  id = {$defualtContactId}";
$contact = getDataTable("contacts", $where_id);
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
        <!-- 1.1 -->
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
        <!-- 1.2 -->
        <CedentePrestatore>
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese>{$countryCode}</IdPaese> 
                    <IdCodice>{$company['vat']}</IdCodice> 
                </IdFiscaleIVA>
                <Anagrafica>
                    <Denominazione>{$company['companyName']}</Denominazione> 
                    <Nome>{$contact['name']}</Nome>
                    <Cognome>{$contact['lastName']}</Cognome>
                    <Titolo>{$contact['title']}</Titolo>
                    <codEORI>{$contact['CodEORI']}</codEORI>
                </Anagrafica>
                <RegimeFiscale>RF01</RegimeFiscale> 
                <AlboProfessionale></AlboProfessionale>
                <ProvinciaAlbo></ProvinciaAlbo>
                <NumeroIscrizioneAlbo></NumeroIscrizioneAlbo>
                <DataIscrizioneAlbo></DataIscrizioneAlbo>
                <RegimeFiscale></RegimeFiscale>
            </DatiAnagrafici>
            <Sede>
                <Indirizzo>{$address['address']} {$address['houseNumber']}</Indirizzo> 
                <NumeroCivico></NumeroCivico>
                <CAP>{$address['postalCode']}</CAP> 
                <Comune>{$address['town']}</Comune> 
                <Provincia>{$address['district']}</Provincia> 
                <Nazione>{$address['country']}</Nazione> 
            </Sede>
            <StabileOrganizzazione>
                <Indirizzo></Indirizzo> 
                <NumeroCivico></NumeroCivico>
                <CAP></CAP> 
                <Comune></Comune> 
                <Provincia></Provincia> 
                <Nazione></Nazione> 
            </StabileOrganizzazione>
            <IscrizioneREA>
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
    $DettaglioLinee = $DatiBeniServizi->addChild("DettaglioLinee");
        $DettaglioLinee->addChild("NumeroLinea",$i+1);
        $DettaglioLinee->addChild("TipoCessionePrestazione","");
        $CodiceArticolo = $DettaglioLinee->addChild("CodiceArticolo");//two childs
            $CodiceArticolo->addChild("CodiceTipo","");
            $CodiceArticolo->addChild("CodiceValore",$item['productCode']);
        
        $DettaglioLinee->addChild("Descrizione","");
        $DettaglioLinee->addChild("Quantita",$item['QuantityReal']);
        $DettaglioLinee->addChild("UnitaMisura","");
        $DettaglioLinee->addChild("DataInizioPeriodo","");
        $DettaglioLinee->addChild("DataFinePeriodo","");
        $DettaglioLinee->addChild("PrezzoUnitario",$item['UnitPriceValue']);
        $ScontoMaggiorazione = $DettaglioLinee->addChild("ScontoMaggiorazione");//tree childs
            $ScontoMaggiorazione->addChild("Tipo","");
            $ScontoMaggiorazione->addChild("Percentuale","");
            $ScontoMaggiorazione->addChild("Importo","");
            
        $DettaglioLinee->addChild("PrezzoTotale",$item['SubtotalValue']);
        $DettaglioLinee->addChild("AliquotaIVA",$item['taxesValue']);
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
        $DatiRiepilogo->addChild("ImponibileImporto",$inponibiliTotale);
        $DatiRiepilogo->addChild("Imposta",$taxesTotales);
        $DatiRiepilogo->addChild("EsigibilitaIVA","D");
        $DatiRiepilogo->addChild("RiferimentoNormativo","");
    
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
