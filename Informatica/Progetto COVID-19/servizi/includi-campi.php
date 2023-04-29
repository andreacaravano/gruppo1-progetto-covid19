<?php
$campi = array(
    array("CodiceUnivoco", "Nome", "Cognome", "DataNascita", "Indirizzo", "DataInizioMandato"),
    array("CodiceUnivoco", "Nome", "Gravit&agrave;", "Durata", "DanniMateriali", "NumeroFeriti", "NumeroVittime"),
    array("Nome", "Indirizzo", "NumeroTelefono", "Regione", "CodiceUnivocoCDR"),
    array("CodiceUnivoco", "Nome", "NomeSede", "NumeroCivili", "NumeroAbitanti", "Specializzazione", "NomeProvincia", "NomeCPR"),
    array("SiglaProvincia", "RicoveratiConSintomi", "RicoveratiTerapiaIntensiva", "TotaleOspedalizzati", "IsolamentiDomiciliari",
        "TotalePositiviAttuale", "NuovoTotalePositivi", "NuovoTotaleGuariti", "NuovoTotaleDeceduti", "NuovoTotaleCasi",
        "NumeroTamponiEffettuati", "CodiceUnivocoEnteLocale"),
    array("CodiceUnivocoCDR", "CodiceUnivocoEmergenza")
);

$nomiTag = array(
    array("", "nome-cdr", "cognome", "data-nascita", "indirizzo-cdr", "data-inizio-mandato"),
    array("codice-univoco-emergenza", "nome-emergenza", "gravita", "durata", "danni-materiali", "numero-feriti", "numero-vittime"),
    array("nome-cpr", "indirizzo-cpr", "numero-telefono", "regione", "codice-univoco-cdr-ext"),
    array("codice-univoco-el", "nome-el", "nome-sede", "numero-civili", "numero-abitanti", "specializzazione", "nome-provincia", "nome-cpr-ext"),
    array("sigla-provincia", "ricoverati-con-sintomi", "ricoverati-terapia-intensiva", "totale-ospedalizzati", "isolamenti-domiciliari",
        "totale-positivi-attuale", "nuovo-totale-positivi", "nuovo-totale-guariti", "nuovo-totale-deceduti", "nuovo-totale-casi",
        "numero-tamponi-effettuati", "codice-univoco-el-ext"),
    array("codice-univoco-cdr-ext2", "codice-univoco-emergenza-ext")
);

$campiDB = array(
    array("CodiceUnivoco", "Nome", "Cognome", "DataNascita", "Indirizzo", "DataInizioMandato"),
    array("CodiceUnivoco", "Nome", "Gravità", "Durata", "DanniMateriali", "NumeroFeriti", "NumeroVittime"),
    array("Nome", "Indirizzo", "NumeroTelefono", "Regione", "CodiceUnivocoCDR"),
    array("CodiceUnivoco", "Nome", "NomeSede", "NumeroCivili", "NumeroAbitanti", "Specializzazione", "NomeProvincia", "NomeCPR"),
    array("SiglaProvincia", "RicoveratiConSintomi", "RicoveratiTerapiaIntensiva", "TotaleOspedalizzati", "IsolamentiDomiciliari",
        "TotalePositiviAttuale", "NuovoTotalePositivi", "NuovoTotaleGuariti", "NuovoTotaleDeceduti", "NuovoTotaleCasi",
        "NumeroTamponiEffettuati", "CodiceUnivocoEnteLocale"),
    array("CodiceUnivocoCDR", "CodiceUnivocoEmergenza")
);

$intestazioni = array("Capo-Dipartimento Regionale", "Emergenza", "Centro Periferico", "Ente Locale", "Unit&agrave; Operativa", "Gestisce");

$identificativi = array("CDR", "Emergenza", "CPR", "EnteLocale", "UnitaOperativa", "Gestisce");

$interrogazioni = array("SELECT * FROM CapoDipartimentoRegionale", "SELECT * FROM Emergenza", "SELECT * FROM CentroPeriferico",
    "SELECT * FROM EnteLocale", "SELECT * FROM UnitaOperativa", "SELECT * FROM Gestisce");

$form = array(
    "
        <td>
            AUTOMATICO
        </td>
        <td>
            <input type='text' name='nome-cdr' id='nome-cdr' required/>
        </td>
        <td>
            <input type='text' name='cognome' id='cognome' required/>
        </td>
        <td>
            <input type='text' name='data-nascita' id='data-nascita' required/>
        </td>
        <td>
            <input type='text' name='indirizzo-cdr' id='indirizzo-cdr' required/>
        </td>
        <td>
            <input type='text' name='data-inizio-mandato' id='data-inizio-mandato'/>
        </td>
    ",
    "
        <td>
            <input type='number' name='codice-univoco-emergenza' id='codice-univoco-emergenza' min='0' placeholder='0' step='1' required/>
        </td>
        <td>
            <input type='text' name='nome-emergenza' id='nome-emergenza' required/>
        </td>
        <td>
            <input type='text' name='gravita' id='gravita' required/>
        </td>
        <td>
            <input type='text' name='durata' id='durata' placeholder='00:00' pattern='^[0-9]{1,10}[:][0-9]{2}$' required/>
        </td>
        <td>
            <input type='number' name='danni-materiali' id='danni-materiali' min='0' step='1' placeholder='0' required/>
        </td>
        <td>
            <input type='number' name='numero-feriti' id='numero-feriti' min='0' step='1' placeholder='0'/>
        </td>
        <td>
            <input type='number' name='numero-vittime' id='numero-vittime' min='0' step='1' placeholder='0'/>
        </td>
    ",
    "
        <td>
            <input type='text' name='nome-cpr' id='nome-cpr' required/>
        </td>
        <td>
            <input type='text' name='indirizzo-cpr' id='indirizzo-cpr' required/>
        </td>
        <td>
            <input type='text' name='numero-telefono' id='numero-telefono' maxlength='15' pattern='^[0-9]{1,15}$' required/>
        </td>
        <td>
            <input type='text' name='regione' id='regione' required/>
        </td>
        <td>
            <input type='number' name='codice-univoco-cdr-ext' id='codice-univoco-cdr-ext' required/>
        </td>
    ",
    "
        <td>
            <input type='text' name='codice-univoco-el' id='codice-univoco-el' pattern='^[A-Z]{2}$' required/>
        </td>
        <td>
            <input type='text' name='nome-el' id='nome-el' required/>
        </td>
        <td>
            <input type='text' name='nome-sede' id='nome-sede' required/>
        </td>
        <td>
            <input type='number' name='numero-civili' id='numero-civili' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='numero-abitanti' id='numero-abitanti' min='0' step='1' required/>
        </td>
        <td>
            <input type='text' name='specializzazione' id='specializzazione' required/>
        </td>
        <td>
            <input type='text' name='nome-provincia' id='nome-provincia' required/>
        </td>
        <td>
            <input type='text' name='nome-cpr-ext' id='nome-cpr-ext' required/>
        </td>
    ",
    "
        <td>
            <input type='text' name='sigla-provincia' id='sigla-provincia' pattern='^[A-Z]{2}$' required/>
        </td>
        <td>
            <input type='number' name='ricoverati-con-sintomi' id='ricoverati-con-sintomi' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='ricoverati-terapia-intensiva' id='ricoverati-terapia-intensiva' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='totale-ospedalizzati' id='totale-ospedalizzati' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='isolamenti-domiciliari' id='isolamenti-domiciliari' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='totale-positivi-attuale' id='totale-positivi-attuale' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='nuovo-totale-positivi' id='nuovo-totale-positivi' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='nuovo-totale-guariti' id='nuovo-totale-guariti' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='nuovo-totale-deceduti' id='nuovo-totale-deceduti' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='nuovo-totale-casi' id='nuovo-totale-casi' min='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='numero-tamponi-effettuati' id='numero-tamponi-effettuati' min='0' step='1' required/>
        </td>
        <td>
            <input type='text' name='codice-univoco-el-ext' id='codice-univoco-el-ext' pattern='^[A-Z]{2}$' required/>
        </td>
    ",
    "
        <td>
            <input type='number' name='codice-univoco-cdr-ext2' id='codice-univoco-cdr-ext' min='0' placeholder='0' step='1' required/>
        </td>
        <td>
            <input type='number' name='codice-univoco-emergenza-ext' id='codice-univoco-emergenza-ext' min='0' placeholder='0' step='1' required/>
        </td>
    "
)

?>