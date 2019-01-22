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
$where_id ="AND orders.id = {$order_id}";//change this to set select where
$order = getDataTable('orders',$where_id);
$order_values = getDataTable_Value('orders',$where_id);
if(!$order['multiOrder']){
    exit(error_message('<h1>order number not valid</h1>' . $order['kind'], false));
}
///////////////////////////

if (!is_null($order['document'])){
    exit(error_message('The invoice file exist, you can\'t make a new xml file after print invoice.', false));
}

if($order_values['kind'] !== 'OUT'){
    exit(error_message('<h1>order not valid</h1>' . $order['kind'], false));
}

/* retrieve multycompany info <CedentePrestatore> */
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $where_id ="AND companies.id={$order_values['company']}";//change this to set select where
        $company = getDataTable('companies',$where_id);
        $company_values = getDataTable_Value('companies', $where_id);
            //error control
            if(!$company['vat']){
                exit(error_message('<h1>vat not valid in company data</h1>', false));
            }
            if(!$company['FormatoTrasmissione']){
                exit(error_message('<h1>Formato Trasmissione not valid in company data</h1>', false));
            }
            if(!$company['regimeFiscale']){
                exit(error_message('<h1>regime fiscale not valid in company data</h1>', false));
            }
            if(!$company['RiferimentoAmministrazione']){
                exit(error_message('<h1>Riferimento Amministrazione not valid in company data</h1>', false));
            }

        //default multiCompany address or firstaddress found
        $where_id = "AND addresses.company = {$order_values['company']} ORDER BY addresses.default, addresses.id DESC LIMIT 1;";
        $address = getDataTable("addresses", $where_id);
            //error control
            if (!$address['country']){
                exit(error_message('<h1>country not valid in company address</h1>', false));
            }
            if (!$address['address']){
                exit(error_message('<h1>address not valid in company address</h1>', false));
            }
            if (!$address['houseNumber']){
                exit(error_message('<h1>numero civico not valid in company address</h1>', false));
            }
            if (!$address['postalCode']){
                exit(error_message('<h1>postal Code not valid in company address</h1>', false));
            }
            if (!$address['district']){
                exit(error_message('<h1>district Code not valid in company address</h1>', false));
            }
            if (!$address['town']){
                exit(error_message('<h1>town not valid in company address</h1>', false));
            }

        //default work multiCompany mail 
        $where_id ="AND mails.company = {$company['id']} AND mails.kind = 'WORK'";//change this to set select where
        $mail = getDataTable('mails',$where_id);
        
        
        //default work multiCompany phone 
        $where_id ="AND phones.company = {$company['id']} AND phones.kind = 'WORK'";//change this to set select where
        $phone = getDataTable('phones',$where_id);
        
        //default work multiCompany phone 
        $where_id ="AND phones.company = {$company['id']} AND phones.kind = 'FAX'";//change this to set select where
        $fax = getDataTable('phones',$where_id);

        //default contact in multiCompany or first contact found
        $defualtContactId = intval(sqlValue("SELECT contacts_companies.contact FROM contacts_companies WHERE contacts_companies.company = {$order_values['company']} ORDER BY contacts_companies.default DESC LIMIT 1"));
            if (!$defualtContactId){
                exit(error_message('<h1>Contact company not setting</h1>', false));
            }
            $where_id = "AND contacts.id = {$defualtContactId}";
            $contact = getDataTable("contacts", $where_id);
            
            //and address contact
            $where_id="AND addresses.contact = {$defualtContactId} ORDER BY addresses.default, addresses.id DESC LIMIT 1;";
            $addressContact = getDataTable("addresses", $where_id);

            if (!$addressContact) {
                exit(error_message('<h1>Adrress contact not valid</h1>', false));
            }
            
            //and defaul mail contact
            $where_id="AND mails.contact = {$defualtContactId} ORDER BY mails.id DESC LIMIT 1;";
            $mailContact = getDataTable("mails", $where_id);
            
            //and default phone contact
            $where_id="AND phones.contact = {$defualtContactId} ORDER BY phones.id DESC LIMIT 1;";
            $mailContact = getDataTable("phones", $where_id);
            
            //and default FAX phone contact
            $where_id="AND phones.contact = {$defualtContactId} AND phones.kind = 'FAX' ORDER BY phones.id DESC LIMIT 1;";
            $mailContact = getDataTable("phones", $where_id);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* retrieve customer info */
///////////////////////////
if ($order_values['customer']){
    $where_id="AND companies.id = {$order_values['customer']}";
    $customer = getDataTable('companies',$where_id);
    $customer_values = getDataTable_Value("companies", $where_id);
    
    //Client address
    $where_id ="AND addresses.company = {$customer['id']} ORDER BY addresses.default DESC LIMIT 1;";//change this to set select where
    $addressCustomer = getDataTable('addresses',$where_id);
    if (!$addressCustomer){
        exit(error_message("<h1>The customer's address is not valid</h1>", false));
    }

    //default PEC Company mail 
    $where_id ="AND mails.company = {$customer['id']} AND mails.kind = 'PEC'";//change this to set select where
    $PECmail = getDataTable('mails',$where_id);
    
    //shiping client address
    $where_id ="AND addresses.company = {$customer['id']} AND addresses.ship = 1;";//change this to set select where
    $addressCustomerShip = getDataTable('addresses',$where_id);
    if (!$addressCustomerShip){
        exit(error_message("<h1>The customer's shipping address is not valid</h1>", false));
    }
    //default contact in multiCompany or first contact found
        $defualtContactId_customer = intval(sqlValue("SELECT contacts_companies.contact FROM contacts_companies WHERE contacts_companies.company = {$order_values['customer']} ORDER BY contacts_companies.default DESC LIMIT 1"));
            if (!$defualtContactId_customer){
                exit(error_message('<h1>Contact company not setting</h1>', false));
            }
            $where_id = "AND contacts.id = {$defualtContactId_customer}";
            $contactCustomer = getDataTable("contacts", $where_id);
            
    ///////////////////////////
}else{
    exit(error_message('<h1>order Customer not valid</h1>', false));
}

// shipper via
if ($order_values['shipVia']){
    $where_id="AND companies.id = {$order_values['shipVia']}";
    $shipper = getDataTable('companies',$where_id);
    ///////////////////////////shipper address
    $where_id ="AND addresses.company = {$shipper['id']} AND addresses.default = 1";//change this to set select where
    $addressShipper = getDataTable('addresses',$where_id);
}else{
    exit(error_message('<h1>order Shipper not valid</h1>', false));
}


$invoice_=<<<XML
<?xml version="1.0" encoding="UTF-8" ?> 
<p:FatturaElettronica 
    versione="FPR12" 
    xmlns:ds="http://www.w3.org/2000/09/xmldsig#" 
    xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:schemaLocation="http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd"
>
    <FatturaElettronicaHeader>
        <!-- 1.1 -->
        <DatiTrasmissione>
        </DatiTrasmissione>
        <!-- 1.2 -->
        <CedentePrestatore>
            <DatiAnagrafici>
                <IdFiscaleIVA>
                    <IdPaese>{$address['country']}</IdPaese> <!-- obligatory -->
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
                <Ufficio></Ufficio> <!-- SI, ma solo se -->
                <NumeroREA></NumeroREA> <!-- SI, ma solo se -->
                <CapitaleSociale></CapitaleSociale> <!-- SI, ma solo se -->
                <SocioUnico></SocioUnico> <!-- SI, ma solo se -->
                <StatoLiquidazione></StatoLiquidazione> <!-- SI, ma solo se -->
            </IscrizioneREA> 
            <Contatti>
                <Telefono></Telefono> <!-- NO -->
                <Fax></Fax> <!-- NO -->
                <Email></Email> <!-- NO -->
            </Contatti> 
            <RiferimentoAmministrazione></RiferimentoAmministrazione> <!-- obligatory -->
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
$dir = __DIR__."/xmlFiles";
//$invoice = file_get_contents("$dir/_baseProforma.xml");
//creating object of SimpleXMLElement
//$xml_invoice = new SimpleXMLElement($invoice);
 $xml_invoice = simplexml_load_file("$dir/_baseProforma.xml");
//1
$header = $xml_invoice->FatturaElettronicaHeader;
    //1.1
    $DatiTrasmissione = $xml_invoice->FatturaElettronicaHeader->DatiTrasmissione;
        //1.1.1
        $IdTrasmittente = $DatiTrasmissione->addChild("IdTrasmittente");
            //1.1.1.1 obligatory
            $IdTrasmittente->addChild("IdPaese",$address['country']);
            //1.1.1.2 obligatory
            $IdTrasmittente->addChild("IdCodice",$company['vat']);
        //1.1.2 obligatory
        $DatiTrasmissione->addChild("ProgressivoInvio",$order['multiOrder']);
        //1.1.3 obligatory assume valore fisso pari a “FPA12”, se la fattura è destinata ad una pubblica amministrazione, oppure “FPR12”, se la fattura è destinata ad un soggetto privato.
        $DatiTrasmissione->addChild("FormatoTrasmissione",$company['FormatoTrasmissione']);
        /*  1.1.4 obligatory
            Utilità: è indispensabile al Sistema di Interscambio per individuare gli
            elementi necessari per recapitare correttamente il file al destinatario.
         * 
            Criteri di valorizzazione: occorre distinguere il tipo di destinatario;
            se la fattura è destinata ad una pubblica amministrazione, il campo deve
            contenere il codice di 6 caratteri, presente su IndicePA tra le informazioni
            relative al servizio di fatturazione elettronica, associato all’ufficio che,
            all’interno dell’amministrazione destinataria, svolge la funzione di ricezione
            (ed eventualmente lavorazione) della fattura; in alternativa, è possibile
            valorizzare il campo con il codice Ufficio “centrale” o con il valore di default
            “999999”, quando ricorrono le condizioni previste dalle disposizioni della
            circolare interpretativa del Ministero dell’Economia e delle Finanze n.1 del
            31 marzo 2014;

         *  se la fattura è destinata ad un soggetto privato, il campo deve contenere il
            codice di 7 caratteri che il Sistema di Interscambio ha attribuito a chi, in
            qualità di titolare di un canale di trasmissione diverso dalla PEC abilitato a
            ricevere fatture elettroniche, ne abbia fatto richiesta attraverso l’apposita
            funzionalità presente sul sito www.fatturapa.gov.it; se la fattura deve
            essere recapitata ad un soggetto che intende ricevere le fatture
            elettroniche attraverso il canale PEC, il campo deve essere valorizzato con
            sette zeri (“0000000”) e deve essere valorizzato il campo PECDestinatario
            (1.1.6).
         */
        $DatiTrasmissione->addChild("CodiceDestinatario",$company['codiceDestinatario']);
        //1.1.5
        if ($phone['phoneNumber'] || $mail['mail']){
            $ContattiTrasmittente = $DatiTrasmissione->addChild("ContattiTrasmittente");
                //1.1.5.1 NO
                if ($phone['phoneNumber']){
                    $ContattiTrasmittente->addChild("Telefono",$phone['phoneNumber']);
                }
                //1.1.5.2 NO
                if ($mail['mail']){
                    $ContattiTrasmittente->addChild("Email",$mail['mail']);
                }
        }
        //1.1.6 SI, ma solo se la fattura è destinata ad un soggetto privato e tale soggetto intende ricevere le fatture elettroniche attraverso il canale PEC. 
        if ($company['FormatoTrasmissione'] === 'FPR12' && $PECmail['mail']){
            $DatiTrasmissione->addChild("PECDestinatario",$PECmail['mail']);
        }

    //1.2
    $CedentePrestatore = $xml_invoice->FatturaElettronicaHeader->CedentePrestatore;
        //1.2.1
        $CP_DatiAnagrafici = $CedentePrestatore->addChild("DatiAnagrafici");
            //1.2.1.1
            $IdFiscaleIVA = $CP_DatiAnagrafici->addChild("IdFiscaleIVA");
                //1.2.1.1.1 obligatory
                $IdFiscaleIVA->addChild("IdPaese",$address['country']);
                //1.2.1.1.2 obligatory
                $IdFiscaleIVA->addChild("IdCodice",$company['vat']);
            //1.2.1.2 recomend    
            $CP_DatiAnagrafici->addChild("CodiceFiscale",$company['vat']);
            //1.2.1.3
            $CP_Anagrafica = $CP_DatiAnagrafici->addChild("Anagrafica");
                //1.2.1.3.1
                if($company['companyName']){
                    $CP_Anagrafica->addChild("Denominazione",$company['companyName']);
                }
                //1.2.1.3.2
                if($contact['name']){
                    $CP_Anagrafica->addChild("Nome",$contact['name']);
                }
                //1.2.1.3.3
                if($contact['lastName']){
                    $CP_Anagrafica->addChild("Cognome",$contact['lastName']);
                }
                //1.2.1.3.4
                if ($contact['title']){
                    $CP_Anagrafica->addChild("Titolo",$contact['title']);
                }
                //1.2.1.3.5
                if ($contact['CodEORI']){
                    $CP_Anagrafica->addChild("codEORI",$contact['CodEORI']);
                }
                /*
                 * not enabled yet
            //1.2.1.4
            $CP_DatiAnagrafici->addChild("AlboProfessionale");
            //1.2.1.5
            $CP_DatiAnagrafici->addChild("ProvinciaAlbo");
            //1.2.1.6
            $CP_DatiAnagrafici->addChild("NumeroIscrizioneAlbo");
            //1.2.1.7
            $CP_DatiAnagrafici->addChild("DataIscrizioneAlbo");
                 */
            //1.2.1.8 obligatory
            $CP_DatiAnagrafici->addChild("RegimeFiscale",$company['regimeFiscale']);
        //1.2.2 Sede
        $CP_Sede = $CedentePrestatore->addChild("Sede");
            //1.2.2.1  
            $CP_Sede->addChild("Indirizzo",$address['address']);
            //1.2.2.2  
            $CP_Sede->addChild("NumeroCivico",$address['houseNumber']);
            //1.2.2.3  
            $CP_Sede->addChild("CAP",$address['postalCode']);
            //1.2.2.4  
            $CP_Sede->addChild("Comune",$address['town']);
            //1.2.2.5  
            $CP_Sede->addChild("Provincia",$address['district']);
            //1.2.2.6  
            $CP_Sede->addChild("Nazione",$address['country']);
        //1.2.3 StabileOrganizzazione
            /*  not enabled yet
             *  solo se
             *  il cedente/prestatore è un soggetto che non risiede in Italia ma che, in Italia,
                dispone di una stabile organizzazione attraverso la quale svolge la propria
                attività (cessioni di beni o prestazioni di servizi oggetto di fatturazione)
        $CP_StabileOrganizzazione =$xml_invoice->FatturaElettronicaHeader->CedentePrestatore->StabileOrganizzazione;
             //1.2.3.1  
            $CP_StabileOrganizzazione->addChild("Indirizzo",$address['address']);
            //1.2.3.2  
            $CP_StabileOrganizzazione->addChild("NumeroCivico",$address['houseNumber']);
            //1.2.3.3  
            $CP_StabileOrganizzazione->addChild("CAP",$address['postalCode']);
            //1.2.3.4  
            $CP_StabileOrganizzazione->addChild("Comune",$address['town']);
            //1.2.3.5  
            $CP_StabileOrganizzazione->addChild("Provincia",$address['district']);
            //1.2.3.6  
            $CP_StabileOrganizzazione->addChild("Nazione",$address['country']);
             */
        //1.2.4 IscrizioneREA
        if ($company['REA_NumeroREA']){
            /*solo se
             *  il cedente/prestatore è una società iscritta nel registro delle imprese e come
                tale ha l’obbligo di indicare in tutti i documenti anche i dati relativi all’iscrizione
                (art. 2250 codice civile)
             */
            $CP_IscrizioneREA = $CedentePrestatore->addChild("IscrizioneREA");
                //1.2.4.1
                $CP_IscrizioneREA->addChild("Ufficio",$company['REA_Ufficio']);
                //1.2.4.2
                $CP_IscrizioneREA->addChild("NumeroREA",$company['REA_NumeroREA']);
                //1.2.4.3
                $CP_IscrizioneREA->addChild("CapitaleSociale",$company['REA_CapitaleSociale']);
                //1.2.4.4
                $CP_IscrizioneREA->addChild("SocioUnico",$company['REA_SocioUnico']);
                //1.2.4.5
                $CP_IscrizioneREA->addChild("StatoLiquidazione",$company['REA_StatoLiquidazione']);
        }    
        //1.2.5
        if($phone['phoneNumber'] || $fax['phoneNumber'] || $mail['mail']){
            $CP_Contatti =  $CedentePrestatore->addChild("Contatti");
                //1.2.5.1
                if($phone['phoneNumber']){
                    $CP_Contatti->addChild("Telefono",$phone['phoneNumber']);
                }
                //1.2.5.2
                if($fax['phoneNumber']){
                    $CP_Contatti->addChild("Fax",$fax['phoneNomber']);
                }
                //1.2.5.3
                if($mail['mail']){
                    $CP_Contatti->addChild("Email",$mail['mail']);
                }
        }
        //1.2.6 obligatory
        $CedentePrestatore->addChild("RiferimentoAmministrazione",$company['RiferimentoAmministrazione']);
    //1.3 RappresentanteFiscale
    /* not enabled yet
     * il cedente/prestatore si configura come soggetto non residente che effettua nel
        territorio dello stato italiano operazioni rilevanti ai fini IVA e che si avvale, in Italia,
        di un rappresentante fiscale
    $RappresentanteFiscale = $header->addChild("RappresentanteFiscale");
        //1.3.1
        $RP_DatiAnagrafici = $RappresentanteFiscale->addChild("DatiAnagrafici");
            //1.3.1.1
            $DatiAnagrafici_IdFiscaleIVA = $RP_DatiAnagrafici->addChild("IdFiscaleIVA");
                //1.3.1.1.1
                $DatiAnagrafici_IdFiscaleIVA->addChild("IdPaese",$address['country']);
                //1.3.1.1.2
                $DatiAnagrafici_IdFiscaleIVA->addChild("IdCodice",$company['vat']);
            //1.3.1.2
            $DatiAnagrafici_Anagrafica = $RP_DatiAnagrafici->addChild("Anagrafica");
                //1.3.1.2
                $DatiAnagrafici_Anagrafica->addChild("Denominazione",$company['companyName']);
                $DatiAnagrafici_Anagrafica->addChild("Nome",$contact['name']);
                $DatiAnagrafici_Anagrafica->addChild("Cognome",$contact['lastName']);
                $DatiAnagrafici_Anagrafica->addChild("Titolo",$contact['title']);
                $DatiAnagrafici_Anagrafica->addChild("CodEORI",$contact['CodEORI']);
     */
    //1.4
    $CessionarioCommittente = $xml_invoice->FatturaElettronicaHeader->CessionarioCommittente;
        //1.4.1
        $CC_DatiAnagrafici = $CessionarioCommittente->addChild("DatiAnagrafici");
            //1.4.1.1
            $CC_DatiAnagrafici_IdFiscaleIVA = $CC_DatiAnagrafici->addChild("IdFiscaleIVA");
                //1.4.1.1.1
                $CC_DatiAnagrafici_IdFiscaleIVA->addChild("IdPaese",$addressCustomer['country']);
                //1.4.1.1.2
                $CC_DatiAnagrafici_IdFiscaleIVA->addChild("IdCodice",$customer['vat']);
            //1.4.1.2
            $CC_DatiAnagrafici->addChild("CodiceFiscale",$customer['vat']);
            //1.4.1.3
            $CC_DatiAnagrafici_Anagrafica = $CC_DatiAnagrafici->addChild("Anagrafica");
                //1.4.1.3.1
                $CC_DatiAnagrafici_Anagrafica->addChild("Denominazione",$customer['companyName']);
                //1.4.1.3.2
                $CC_DatiAnagrafici_Anagrafica->addChild("Nome",$contactCustomer['name']);
                //1.4.1.3.3
                $CC_DatiAnagrafici_Anagrafica->addChild("Cognome",$contactCustomer['lastName']);
                //1.4.1.3.4
                $CC_DatiAnagrafici_Anagrafica->addChild("Titolo",$contactCustomer['title']);
                //1.4.1.3.5
                $CC_DatiAnagrafici_Anagrafica->addChild("CodEORI",$contactCustomer['codEORI']);
        //1.4.2
        $CC_Sede = $CessionarioCommittente->addChild("Sede");
            //1.4.2.1
            $CC_Sede->addChild("Indirizzo",$addressCustomer['address']);
            //1.4.2.2
            $CC_Sede->addChild("NumeroCivico",$addressCustomer['hoseNumber']);
            //1.4.2.3
            $CC_Sede->addChild("CAP",$addressCustomer['postalCode']);
            //1.4.2.4
            $CC_Sede->addChild("Comune",$addressCustomer['town']);
            //1.4.2.5
            $CC_Sede->addChild("Provincia",$addressCustomer['district']);
            //1.4.2.6
            $CC_Sede->addChild("Nazione",$addressCustomer['country']);
        //1.4.3 StabileOrganizzazione
        /* not enabled yet
         * il cessionario/committente è un soggetto che non risiede in Italia ma che, in
            Italia, dispone di una stabile organizzazione attraverso la quale svolge la
            propria attività oggetto di fatturazione
        $CC_StabileOrganizzazione = $CessionarioCommittentes->addChild("StabileOrganizzazione");
            //1.4.2.1
            $CC_StabileOrganizzazione->addChild("Indirizzo",$addressCustomer['address']);
            //1.4.2.2
            $CC_StabileOrganizzazione->addChild("NumeroCivico",$addressCustomer['hoseNumber']);
            //1.4.2.3
            $CC_StabileOrganizzazione->addChild("CAP",$addressCustomer['postalCode']);
            //1.4.2.4
            $CC_StabileOrganizzazione->addChild("Comune",$addressCustomer['town']);
            //1.4.2.5
            $CC_StabileOrganizzazione->addChild("Provincia",$addressCustomer['district']);
            //1.4.2.6
            $CC_StabileOrganizzazione->addChild("Nazione",$addressCustomer['country']);
         */
        //1.4.4 RappresentanteFiscale
        /*  not enabled yet
         * il cessionario/committentee si configura come soggetto non residente che effettua
            nel territorio dello stato italiano operazioni rilevanti ai fini IVA e che si avvale, in
            Italia, di un rappresentante fiscale
        $CC_RappresentanteFiscale = $CessionarioCommittentes->addChild("RappresentanteFiscale");
            //1.4.4.1
            $CC_RappresentanteFiscale_IdFiscaleIVA = $CC_RappresentanteFiscale->addChild("IdFiscaleIVA");
                //1.4.4.1.1
                $CC_RappresentanteFiscale_IdFiscaleIVA->addChild("IdPaese",$addressCustomer['country']);
                //1.4.4.1.2
                $CC_RappresentanteFiscale_IdFiscaleIVA->addChild("IdCodice",$customer['vat']);
            //1.4.4.2
            $CC_RappresentanteFiscale->addChild("Denominazione",$customer['companyName']);
            //1.4.4.3
            $CC_RappresentanteFiscale->addChild("Nome",$contactCustomer['name']);
            //1.4.4.4
            $CC_RappresentanteFiscale->addChild("Cognome",$contactCustomer['lastName']);
         */
        
    //1.5 TerzoIntermediarioOSoggettoEmittente
    /*not enabled yet
     * l’impegno di emettere fattura elettronica per conto del cedente/prestatore è
        assunto da un terzo sulla base di un accordo preventivo; il cedente/prestatore
        rimane responsabile dell’adempimento fiscale
            
    $TerzoIntermediarioOSoggettoEmittente = $header->addChild("TerzoIntermediarioOSoggettoEmittente");
        //1.5.1
        $TS_DatiAnagrafici = $CessionarioCommittente->addChild("DatiAnagrafici");
            //1.5.1.1
            $TS_DatiAnagrafici_IdFiscaleIVA = $TS_DatiAnagrafici->addChild("IdFiscaleIVA");
                //1.5.1.1.1
                $TS_DatiAnagrafici_IdFiscaleIVA->addChild("IdPaese",$addressCustomer['country']);
                //1.5.1.1.2
                $TS_DatiAnagrafici_IdFiscaleIVA->addChild("IdCodice",$customer['vat']);
            //1.5.1.2
            $TS_DatiAnagrafici->addChild("CodiceFiscale",$customer['vat']);
            //1.5.1.3
            $TS_DatiAnagrafici_Anagrafica = $TS_DatiAnagrafici->addChild("Anagrafica");
                //1.5.1.3.1
                $TS_DatiAnagrafici_Anagrafica->addChild("Denominazione",$customer['companyName']);
                //1.5.1.3.2
                $TS_DatiAnagrafici_Anagrafica->addChild("Nome",$contactCustomer['name']);
                //1.5.1.3.3
                $TS_DatiAnagrafici_Anagrafica->addChild("Cognome",$contactCustomer['lastName']);
                //1.5.1.3.4
                $TS_DatiAnagrafici_Anagrafica->addChild("Titolo",$contactCustomer['title']);
                //1.5.1.3.5
                $TS_DatiAnagrafici_Anagrafica->addChild("CodEORI",$contactCustomer['codEORI']);
     */
    //1.6 SoggettoEmittente  indicare “CC” se la fattura è stata compilata da parte del cessionario/committente, “TZ” se è stata compilata da un soggetto terzo.
    $header->addChild("SoggettoEmittente","CC");
//2
$body = $xml_invoice->FatturaElettronicaBody;      
    //2.1 DatiGenerali
        //2.1.1
        $DatiGeneraliDocumento = $body->DatiGenerali->DatiGeneraliDocumento;
            $DatiGeneraliDocumento->addChild("TipoDocumento",$order_values['typeDoc']);
            $DatiGeneraliDocumento->addChild("Divisa","EUR");
            $DatiGeneraliDocumento->addChild("Data",$order['date']);
            $DatiGeneraliDocumento->addChild("Numero",$order['multiOrder']);
            $DD_DatiRitenuta = $DatiGeneraliDocumento->addChild('DatiRitenuta');
                $DD_DatiRitenuta->addchild("TipoRitenuta");
                $DD_DatiRitenuta->addchild("ImportoRitenuta");
                $DD_DatiRitenuta->addchild("AliquotaRitenuta");
                $DD_DatiRitenuta->addchild("CausalePagamento");
            $DD_DatiBollo = $DatiGeneraliDocumento->addChild('DatiBollo');
                $DD_DatiBollo->addChild("NumeroBollo");
                $DD_DatiBollo->addChild("ImportoBollo");
            $DD_DatiCassaPrevidenziale = $DatiGeneraliDocumento->addChild('DatiCassaPrevidenziale');
                $DD_DatiCassaPrevidenziale->addChild("TipoCassa");
                $DD_DatiCassaPrevidenziale->addChild("AlCassa");
                $DD_DatiCassaPrevidenziale->addChild("ImportoContributoCassa");
                $DD_DatiCassaPrevidenziale->addChild("ImponibileCassa");
                $DD_DatiCassaPrevidenziale->addChild("AliquotaIVA");
                $DD_DatiCassaPrevidenziale->addChild("Ritenuta");
                $DD_DatiCassaPrevidenziale->addChild("Natura");
                $DD_DatiCassaPrevidenziale->addChild("RiferimentoAmministrazione");
            $DD_ScontoMaggiorazione = $DatiGeneraliDocumento->addChild("ScontoMaggiorazione");
                $DD_ScontoMaggiorazione->addChild("Tipo");
                $DD_ScontoMaggiorazione->addChild("Percentuale");
                $DD_ScontoMaggiorazione->addChild("Importo");
            $DatiGeneraliDocumento->addChild("ImportoTotaleDocumento");
            $DatiGeneraliDocumento->addChild("Arrotondamento");
            $DatiGeneraliDocumento->addChild("Causale");
            $DatiGeneraliDocumento->addChild("Art73");
        $DatiOrdineAcquisto = $body->DatiGenerali->DatiOrdineAcquisto;
            
//2.2 
$DatiBeniServizi = $body->DatiBeniServizi;

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
    $where_id = "AND products.id = $productId";
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