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
$order_values = getDataTable_Values('orders',$where_id);
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
        retCompanyData($company,$company_values,$order_values['company']);

        retCompanyAddress($address, $address_values, $order_values['company']);

        retMailPhonelFax_Company($mail, $phone, $fax, $company['id']);

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
            retMailPhonelFax_Contact($mailContact, $phoneContact, $faxContact, $defualtContactId);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* retrieve customer info */
///////////////////////////
if ($order_values['customer']){
    retCompanyData($customer,$customer_values,$order_values['customer'],false);
    
    //Client address
    retCompanyAddress($addressCustomer, $addressCustomer_values, $customer['id']);
            
    //default PEC Company mail 
    $where_id ="AND mails.company = {$customer['id']} AND mails.kind = 'PEC'";//change this to set select where
    $PECmail = getDataTable('mails',$where_id);
    
    //shiping client address
    retCompanyAddress($addressCustomerShip, $addressCustomerShip_values, $customer['id']);

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
    retCompanyData($shipper,$shipper_values,$order_values['shipVia'],false);
    
    //shipper address
    retCompanyAddress($addressCustomerShip, $addressCustomerShip_values, $shipper['id']);
    
}else{
    exit(error_message('<h1>order Shipper not valid</h1>', false));
}


$invoice=<<<XML
<?xml version="1.0" encoding="UTF-8" ?> 
<p:FatturaElettronica versione="FPR12" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" 
xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xsi:schemaLocation="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd">
    <FatturaElettronicaHeader>
    </FatturaElettronicaHeader>
    <FatturaElettronicaBody>
        <!-- 2.1 -->
        <DatiGenerali>
        </DatiGenerali>
        <!-- 2.2 -->
        <DatiBeniServizi>
        </DatiBeniServizi>
    </FatturaElettronicaBody>
</p:FatturaElettronica>
        
XML;

//creating object of SimpleXMLElement
$xml_invoice = new SimpleXMLElement($invoice);

//1
$header = $xml_invoice->FatturaElettronicaHeader;
    //1.1
    $DatiTrasmissione = $xml_invoice->FatturaElettronicaHeader->addChild("DatiTrasmissione");
        //1.1.1
        $IdTrasmittente = $DatiTrasmissione->addChild("IdTrasmittente");
            //1.1.1.1 obligatory
            $IdTrasmittente->addChild("IdPaese",$address['country']);
            //1.1.1.2 obligatory
            $IdTrasmittente->addChild("IdCodice",$company['vat']);
        //1.1.2 obligatory
        $DatiTrasmissione->addChild("ProgressivoInvio",$order['multiOrder']);
        //1.1.3 obligatory assume valore fisso pari a “FPA12”, se la fattura è destinata ad una pubblica amministrazione, oppure “FPR12”, se la fattura è destinata ad un soggetto privato.
        $DatiTrasmissione->addChild("FormatoTrasmissione",$company_values['FormatoTrasmissione']);
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
        $DatiTrasmissione->addChild("CodiceDestinatario",$company_values['codiceDestinatario']);
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
    $CedentePrestatore = $xml_invoice->FatturaElettronicaHeader->addChild("CedentePrestatore");
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
                $CP_Anagrafica->addChild("Denominazione",$company['companyName']);
                //1.2.1.3.2
//                $CP_Anagrafica->addChild("Nome",$contact['name']);
//                //1.2.1.3.3
//                $CP_Anagrafica->addChild("Cognome",$contact['lastName']);
//                //1.2.1.3.4
//                $CP_Anagrafica->addChild("Titolo",$contact['title']);
//                //1.2.1.3.5
//                $CP_Anagrafica->addChild("codEORI",$contact['CodEORI']);
            //1.2.1.4
            $CP_DatiAnagrafici->addChild("AlboProfessionale","");
            //1.2.1.5
            $CP_DatiAnagrafici->addChild("ProvinciaAlbo","");
            //1.2.1.6
            $CP_DatiAnagrafici->addChild("NumeroIscrizioneAlbo","");
            //1.2.1.7
            $CP_DatiAnagrafici->addChild("DataIscrizioneAlbo","");
            //1.2.1.8 obligatory
            $CP_DatiAnagrafici->addChild("RegimeFiscale",$company_values['regimeFiscale']);
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
                */
        $CP_StabileOrganizzazione =$xml_invoice->FatturaElettronicaHeader->addchild("CedentePrestatore")->addChild("StabileOrganizzazione");
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
        //1.2.4 IscrizioneREA
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
        //1.2.5
        if($phone['phoneNumber'] || $fax['phoneNumber'] || $mail['mail']){
            $CP_Contatti =  $CedentePrestatore->addChild("Contatti");
                //1.2.5.1
                $CP_Contatti->addChild("Telefono",$phone['phoneNumber']);
                //1.2.5.2
                $CP_Contatti->addChild("Fax",$fax['phoneNomber']);
                //1.2.5.3
                $CP_Contatti->addChild("Email",$mail['mail']);
        }
        //1.2.6 obligatory
        $CedentePrestatore->addChild("RiferimentoAmministrazione",$company['RiferimentoAmministrazione']);
    // 1.3 RappresentanteFiscale 
    /* il cedente/prestatore si configura come soggetto non residente che effettua nel
        territorio dello stato italiano operazioni rilevanti ai fini IVA e che si avvale, in Italia,
        di un rappresentante fiscale
        */
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
//                $DatiAnagrafici_Anagrafica->addChild("Nome",$contact['name']);
//                $DatiAnagrafici_Anagrafica->addChild("Cognome",$contact['lastName']);
//                $DatiAnagrafici_Anagrafica->addChild("Titolo",$contact['title']);
//                $DatiAnagrafici_Anagrafica->addChild("CodEORI",$contact['CodEORI']);
    //1.4
    $CessionarioCommittente = $xml_invoice->FatturaElettronicaHeader->addChild("CessionarioCommittente");
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
//                $CC_DatiAnagrafici_Anagrafica->addChild("Nome",$contactCustomer['name']);
//                //1.4.1.3.3
//                $CC_DatiAnagrafici_Anagrafica->addChild("Cognome",$contactCustomer['lastName']);
//                //1.4.1.3.4
//                $CC_DatiAnagrafici_Anagrafica->addChild("Titolo",$contactCustomer['title']);
//                //1.4.1.3.5
//                $CC_DatiAnagrafici_Anagrafica->addChild("CodEORI",$contactCustomer['codEORI']);
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
        /*
         * il cessionario/committente è un soggetto che non risiede in Italia ma che, in
            Italia, dispone di una stabile organizzazione attraverso la quale svolge la
            propria attività oggetto di fatturazione
            */
        $CC_StabileOrganizzazione = $CessionarioCommittente->addChild("StabileOrganizzazione");
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
        //1.4.4 RappresentanteFiscale
        /*  
         * il cessionario/committentee si configura come soggetto non residente che effettua
            nel territorio dello stato italiano operazioni rilevanti ai fini IVA e che si avvale, in
            Italia, di un rappresentante fiscale
            */
        $CC_RappresentanteFiscale = $CessionarioCommittente->addChild("RappresentanteFiscale");
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
        
    //1.5 TerzoIntermediarioOSoggettoEmittente
    /*
     * l’impegno di emettere fattura elettronica per conto del cedente/prestatore è
        assunto da un terzo sulla base di un accordo preventivo; il cedente/prestatore
        rimane responsabile dell’adempimento fiscale
            */
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
//                //1.5.1.3.2
//                $TS_DatiAnagrafici_Anagrafica->addChild("Nome",$contactCustomer['name']);
//                //1.5.1.3.3
//                $TS_DatiAnagrafici_Anagrafica->addChild("Cognome",$contactCustomer['lastName']);
//                //1.5.1.3.4
//                $TS_DatiAnagrafici_Anagrafica->addChild("Titolo",$contactCustomer['title']);
//                //1.5.1.3.5
//                $TS_DatiAnagrafici_Anagrafica->addChild("CodEORI",$contactCustomer['codEORI']);
    //1.6 SoggettoEmittente  indicare “CC” se la fattura è stata compilata da parte del cessionario/committente, “TZ” se è stata compilata da un soggetto terzo.
    $header->addChild("SoggettoEmittente","CC");
//2
$body = $xml_invoice->FatturaElettronicaBody;      
    //2.1 DatiGenerali
        //2.1.1
        $DatiGeneraliDocumento = $body->DatiGenerali->addChild("DatiGeneraliDocumento");
            //2.1.1.1
            $DatiGeneraliDocumento->addChild("TipoDocumento",$order_values['typeDoc']);
            //2.1.1.2
            $DatiGeneraliDocumento->addChild("Divisa","EUR");
            //2.1.1.3
            $DatiGeneraliDocumento->addChild("Data",$order['date']);
            //2.1.1.4
            $DatiGeneraliDocumento->addChild("Numero",$order['multiOrder']);
            //2.1.1.5
            $DD_DatiRitenuta = $DatiGeneraliDocumento->addChild('DatiRitenuta');
                //2.1.1.5.1
                $DD_DatiRitenuta->addchild("TipoRitenuta","");
                //2.1.1.5.2
                $DD_DatiRitenuta->addchild("ImportoRitenuta","");
                //2.1.1.5.3
                $DD_DatiRitenuta->addchild("AliquotaRitenuta","");
                //2.1.1.5.4
                $DD_DatiRitenuta->addchild("CausalePagamento","");
            //2.1.1.6
            $DD_DatiBollo = $DatiGeneraliDocumento->addChild('DatiBollo');
                //2.1.1.6.1
                $DD_DatiBollo->addChild("NumeroBollo","");
                //2.1.1.6.2
                $DD_DatiBollo->addChild("ImportoBollo","");
            //2.1.1.7
            $DD_DatiCassaPrevidenziale = $DatiGeneraliDocumento->addChild('DatiCassaPrevidenziale');
                //2.1.1.7.1
                $DD_DatiCassaPrevidenziale->addChild("TipoCassa","");
                //2.1.1.7.2
                $DD_DatiCassaPrevidenziale->addChild("AlCassa","");
                //2.1.1.7.3
                $DD_DatiCassaPrevidenziale->addChild("ImportoContributoCassa","");
                //2.1.1.7.4
                $DD_DatiCassaPrevidenziale->addChild("ImponibileCassa","");
                //2.1.1.7.5
                $DD_DatiCassaPrevidenziale->addChild("AliquotaIVA","");
                //2.1.1.7.6
                $DD_DatiCassaPrevidenziale->addChild("Ritenuta","");
                //2.1.1.7.7
                $DD_DatiCassaPrevidenziale->addChild("Natura","");
                //2.1.1.7.8
                $DD_DatiCassaPrevidenziale->addChild("RiferimentoAmministrazione","");
            //2.1.1.8
            $DD_ScontoMaggiorazione = $DatiGeneraliDocumento->addChild("ScontoMaggiorazione");
                //2.1.1.8.1
                $DD_ScontoMaggiorazione->addChild("Tipo","");
                //2.1.1.8.2
                $DD_ScontoMaggiorazione->addChild("Percentuale","");
                //2.1.1.8.3
                $DD_ScontoMaggiorazione->addChild("Importo","");
            //2.1.1.9
            $DatiGeneraliDocumento->addChild("ImportoTotaleDocumento","");
            //2.1.1.10
            $DatiGeneraliDocumento->addChild("Arrotondamento","");
            //2.1.1.11
            $DatiGeneraliDocumento->addChild("Causale","");
            //2.1.1.12
            $DatiGeneraliDocumento->addChild("Art73","");
        //2.1.2
        $DatiOrdineAcquisto = $body->DatiGenerali->addChild("DatiOrdineAcquisto");
            //2.1.2.1
            $DatiOrdineAcquisto->addChild("RiferimentoNumeroLinea","");
            //2.1.2.2
            $DatiOrdineAcquisto->addChild("IdDocumento","");
            //2.1.2.3
            $DatiOrdineAcquisto->addChild("Data","");
            //2.1.2.4
            $DatiOrdineAcquisto->addChild("NumItem","");
            //2.1.2.5
            $DatiOrdineAcquisto->addChild("CodiceCommessaConvenzione","");
            //2.1.2.6
            $DatiOrdineAcquisto->addChild("CodiceCUP","");
            //2.1.2.7
            $DatiOrdineAcquisto->addChild("CodiceCIG","");
        //2.1.3
        $body->DatiGenerali->addChild("DatiContratto","");
        //2.1.4
        $body->DatiGenerali->addChild("DatiConvenzione","");
        //2.1.5
        $body->DatiGenerali->addChild("DatiRicezione","");
        //2.1.6
        $body->DatiGenerali->addChild("DatiFattureCollegate","");
        //2.1.7
        $datiSAL = $body->DatiGenerali->addChild("DatiSAL");
            //2.1.7.1
            $datiSAL->addChild("RiferimentoFase","");
        //2.1.8
        $datiDDT = $body->DatiGenerali->addChild("DatiDDT");
            //2.1.8.1
            $datiDDT->addChild("NumeroDDT","");
            //2.1.8.2
            $datiDDT->addChild("DataDDT","");
            //2.1.8.3
            $datiDDT->addChild("RiferimentoNumeroLinea","");
        //2.1.9
        $datiTrasporto = $body->DatiGenerali->addChild("DatiTrasporto");
            //2.1.9.1
            $DatiAnagraficiVettore = $datiTrasporto->addChild("DatiAnagraficiVettore");
                //2.1.9.1.1
                $DAV_IdFiscaleIVA = $DatiAnagraficiVettore->addChild("IdFiscaleIVA");
                    //2.1.9.1.1.1
                    $DAV_IdFiscaleIVA->addChild("IdPaese","");
                    //2.1.9.1.1.2
                    $DAV_IdFiscaleIVA->addChild("IdCodice","");
                //2.1.9.1.2
                $DatiAnagraficiVettore->addChild("CodiceFiscale","");
                //2.1.9.1.3
                $DAV_Anagrafica = $DatiAnagraficiVettore->addChild("Anagrafica");
                    //2.1.9.1.3.1
                    $DAV_Anagrafica->addChild("Denominazione","");
//                    //2.1.9.1.3.2
//                    $DAV_Anagrafica->addChild("Nome","");
//                    //2.1.9.1.3.3
//                    $DAV_Anagrafica->addChild("Cognome","");
//                    //2.1.9.1.3.4
//                    $DAV_Anagrafica->addChild("Titolo","");
//                    //2.1.9.1.3.5
//                    $DAV_Anagrafica->addChild("CodEORI","");
                //2.1.9.1.4
                $DatiAnagraficiVettore->addChild("NumeroLicenzaGuida","");
            //2.1.9.2
            $datiTrasporto->addChild("MezzoTrasporto","");
            //2.1.9.3
            $datiTrasporto->addChild("CausaleTrasporto","");
            //2.1.9.4
            $datiTrasporto->addChild("NumeroColli","");
            //2.1.9.5
            $datiTrasporto->addChild("Descrizione","");
            //2.1.9.6
            $datiTrasporto->addChild("UnitaMisuraPeso","");
            //2.1.9.7
            $datiTrasporto->addChild("PesoLordo","");
            //2.1.9.8
            $datiTrasporto->addChild("PesoNetto","");
            //2.1.9.9
            $datiTrasporto->addChild("DataOraRitiro","");
            //2.1.9.10
            $datiTrasporto->addChild("DataInizioTrasporto","");
            //2.1.9.11
            $datiTrasporto->addChild("TipoResa","");
            //2.1.9.12
            $IndirizzoResa = $datiTrasporto->addChild("IndirizzoResa");
                //2.1.9.12.1
                $IndirizzoResa->addChild("Indirizzo","");
                //2.1.9.12.2
                $IndirizzoResa->addChild("NumeroCivico","");
                //2.1.9.12.3
                $IndirizzoResa->addChild("CAP","");
                //2.1.9.12.4
                $IndirizzoResa->addChild("Comune","");
                //2.1.9.12.5
                $IndirizzoResa->addChild("Provincia","");
                //2.1.9.12.6
                $IndirizzoResa->addChild("Nazione","");
            //2.1.9.13
            $datiTrasporto->addChild("DataOraConsegna",$order['consigneeHour']);
        //2.1.10
        $FatturaPrincipale = $body->DatiGenerali->addChild("FatturaPrincipale");
            //2.1.10.1
            $FatturaPrincipale->addChild("NumeroFatturaPrincipale","");
            //2.1.10.2
            $FatturaPrincipale->addChild("DataFatturaPrincipale","");
            
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
        $categoryData = getKindsData($categoryId );
        //2.2.1
        $DettaglioLinee = $DatiBeniServizi->addChild("DettaglioLinee");
            //2.2.1.1
            $DettaglioLinee->addChild("NumeroLinea",$i+1);
            //2.2.1.2
            $DettaglioLinee->addChild("TipoCessionePrestazione",$item['Discount']? "SC" : "");
            //2.2.1.3
            $CodiceArticolo = $DettaglioLinee->addChild("CodiceArticolo");//two childs
                //2.2.1.3.1
                $CodiceArticolo->addChild("CodiceTipo",$categoryData['code']);
                //2.2.1.3.2
                $CodiceArticolo->addChild("CodiceValore",$item['productCode']);
            //2.2.1.4
            $DettaglioLinee->addChild("Descrizione",$product['productName']);
            //2.2.1.5
            $DettaglioLinee->addChild("Quantita",$item['QuantityReal']);
            //2.2.1.6
            $DettaglioLinee->addChild("UnitaMisura",$product['UM']);
            //2.2.1.7
            $DettaglioLinee->addChild("DataInizioPeriodo","");
            //2.2.1.8
            $DettaglioLinee->addChild("DataFinePeriodo","");
            //2.2.1.9
            $DettaglioLinee->addChild("PrezzoUnitario",number_format($item['UnitPriceValue'] , 2));
            //2.2.1.10
            $ScontoMaggiorazione = $DettaglioLinee->addChild("ScontoMaggiorazione");//tree childs
                //2.2.1.10.1
                $ScontoMaggiorazione->addChild("Tipo",$item['Discount']? "SC" : "");
                //2.2.1.10.2
                $ScontoMaggiorazione->addChild("Percentuale",number_format($item['Discount'] , 2));
                //2.2.1.10.3
                $ScontoMaggiorazione->addChild("Importo",number_format($item['SubtotalValue']*$item['Discount']/100 , 2));
            //2.2.1.11
            $DettaglioLinee->addChild("PrezzoTotale",number_format($item['SubtotalValue'] , 2));
            //2.2.1.12
            $DettaglioLinee->addChild("AliquotaIVA",number_format($item['taxesValue'] , 2));
            //2.2.1.13
            $DettaglioLinee->addChild("Ritenuta","");
            //2.2.1.14
            $DettaglioLinee->addChild("Natura","");
            //2.2.1.15
            $DettaglioLinee->addChild("RiferimentoAmministrazione","");
            //2.2.1.16
            $AltriDatiGestionali = $DettaglioLinee->addChild("AltriDatiGestionali");//four childs
                //2.2.1.16.1
                $ScontoMaggiorazione->addChild("TipoDato","");
                //2.2.1.16.2
                $ScontoMaggiorazione->addChild("RiferimentoTesto","");
                //2.2.1.16.3
                $ScontoMaggiorazione->addChild("RiferimentoNumero","");
                //2.2.1.16.4
                $ScontoMaggiorazione->addChild("RiferimentoData","");
            
        $inponibiliTotale = $inponibiliTotale + $item['SubtotalValue'];
        $taxesTotales = $taxesTotales + $item['taxesValue'];
    }
    ///////////////////////////
        //2.2.2
        $DatiRiepilogo = $DatiBeniServizi->addChild("DatiRiepilogo");
            //2.2.2.1
            $DatiRiepilogo->addChild("AliquotaIVA","4.00");
            //2.2.2.2
            $DatiRiepilogo->addChild("Natura","");
            //2.2.2.3
            $DatiRiepilogo->addChild("SpeseAccessorie","");
            //2.2.2.4
            $DatiRiepilogo->addChild("Arrotondamento","");
            //2.2.2.5
            $DatiRiepilogo->addChild("ImponibileImporto",number_format($inponibiliTotale , 2));
            //2.2.2.6
            $DatiRiepilogo->addChild("Imposta",number_format($taxesTotales , 2));
            //2.2.2.7
            $DatiRiepilogo->addChild("EsigibilitaIVA","D");
            //2.2.2.8
            $DatiRiepilogo->addChild("RiferimentoNormativo","");

    //2.3
    $datiVeicoli = $body->DatiGenerali->addChild("DatiVeicoli");
        //2.3.1
        $datiVeicoli->addChild("Data","");
        //2.3-2
        $datiVeicoli->addChild("TotalePercorso","");
    //2.4
    $datiPagamento = $body->DatiGenerali->addChild("DatiPagamento");
        //2.4.1
        $datiPagamento->addChild("CondizioniPagamento","");
        //2.4.2
        $DettaglioPagamento = $datiPagamento->addChild("DettaglioPagamento");
            //2.4.2.1
            $DettaglioPagamento->addChild("Beneficiario","");
            //2.4.2.2
            $DettaglioPagamento->addChild("ModalitaPagamento","");
            //2.4.2.3
            $DettaglioPagamento->addChild("DataRiferimentoTerminiPagamento","");
            //2.4.2.4
            $DettaglioPagamento->addChild("GiorniTerminiPagamento","");
            //2.4.2.5
            $DettaglioPagamento->addChild("DataScadenzaPagamento","");
            //2.4.2.6
            $DettaglioPagamento->addChild("ImportoPagamento","");
            //2.4.2.7
            $DettaglioPagamento->addChild("CodUfficioPostale","");
            //2.4.2.8
            $DettaglioPagamento->addChild("CognomeQuietanzante","");
            //2.4.2.9
            $DettaglioPagamento->addChild("NomeQuietanzante","");
            //2.4.2.10
            $DettaglioPagamento->addChild("CFQuietanzante","");
            //2.4.2.11
            $DettaglioPagamento->addChild("TitoloQuietanzante","");
            //2.4.2.12
            $DettaglioPagamento->addChild("IstitutoFinanziario","");
            //2.4.2.13
            $DettaglioPagamento->addChild("IBAN","");
            //2.4.2.14
            $DettaglioPagamento->addChild("ABI","");
            //2.4.2.15
            $DettaglioPagamento->addChild("CAB","");
            //2.4.2.16
            $DettaglioPagamento->addChild("BIC","");
            //2.4.2.17
            $DettaglioPagamento->addChild("ScontoPagamentoAnticipato","");
            //2.4.2.18
            $DettaglioPagamento->addChild("DataLimitePagamentoAnticipato","");
            //2.4.2.19
            $DettaglioPagamento->addChild("PenalitaPagamentiRitardati","");
            //2.4.2.20
            $DettaglioPagamento->addChild("DataDecorrenzaPenale","");
            //2.4.2.21
            $DettaglioPagamento->addChild("CodicePagamento","");
    //2.5
    $allegati = $body->DatiGenerali->addChild("Allegati");
            //2.5.1
        $allegati->addChild("NomeAttachment","");
            //2.5.2
        $allegati->addChild("AlgoritmoCompressione","");
            //2.5.3
        $allegati->addChild("FormatoAttachment","");
            //2.5.4
        $allegati->addChild("DescrizioneAttachment","");
            //2.5.5
        $allegati->addChild("Attachment","");
    
/*
 * Remove empty (no children) and blank (no text) XML element nodes, but not an empty root element (/child::*).
 */
do {
    $removed = false;
    foreach( $xml_invoice->xpath('/child::*//*[not(*) and not(text()[normalize-space()])]') as $emptyElement ) {
        unset( $emptyElement[0] );
        $removed = true;
    }
} while ($removed) ;

$xml_fileName = $address['country'] . $company['vat'] . "_FPR" . $order['multiOrder'];

//saving generated xml file
$xml_file = $xml_invoice->asXML("xmlFiles/$xml_fileName.xml");

//success and error message based on xml creation
if($xml_file){
            $msg = '<div class="alert alert-success"><h1>
                XML file have been generated successfully.
            </h1></div>';
    echo $msg;
    $link = "<script>window.open('xmlFiles/$xml_fileName.xml')</script>";
    echo $link;
    
}else{
    exit(error_message('XML file generation error.', false));
}

