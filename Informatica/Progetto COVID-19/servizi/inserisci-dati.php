<?php
if (isset($_POST["submit"]) && !empty($_POST["ambito"])) {
    include "includi.php";
    session_start();
    switch ($_POST["ambito"]) {
        case "CDR":
            if (controllaTesto($_POST["nome-cdr"]) && controllaTesto($_POST["cognome"]) && validaData($_POST["data-nascita"]) &&
                controllaTesto($_POST["indirizzo-cdr"]) && validaData($_POST["data-inizio-mandato"])) {
                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                if ($connessione->connect_error) {
                    $_SESSION["msg"] = "Errore di connessione al database:" . htmlspecialchars($connessione->connect_error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }

                $sql = "INSERT INTO CapoDipartimentoRegionale(Nome, Cognome, DataNascita, Indirizzo, DataInizioMandato) VALUE (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, STR_TO_DATE(?, '%d/%m/%Y'))";
                $stmt = $connessione->prepare($sql);
                if ($stmt == false) {
                    $_SESSION["msg"] = "Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }
                $stmt->bind_param("sssss", $_POST["nome-cdr"], $_POST["cognome"], $_POST["data-nascita"], $_POST["indirizzo-cdr"], $_POST["data-inizio-mandato"]);
                if ($stmt->execute()) {
                    $_SESSION["msg"] = "Dati inseriti correttamente!";
                    $_SESSION["colore"] = "darkseagreen";
                } else {
                    $_SESSION["msg"] = "Il database non ha accettato l'immissione dei dati forniti. Riprova.";
                    $_SESSION["colore"] = "orangered";
                }
                $_SESSION["sql"] = $sql;
                header("Location: ../popola.php", true, 302);
            }
            break;
        case "Emergenza":
            if (is_numeric($_POST["codice-univoco-emergenza"]) && controllaTesto($_POST["nome-emergenza"]) && controllaTesto($_POST["gravita"]) && validaTempo($_POST["durata"]) &&
                is_numeric($_POST["danni-materiali"]) && is_numeric($_POST["numero-feriti"]) && is_numeric($_POST["numero-vittime"])) {
                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                if ($connessione->connect_error) {
                    $_SESSION["msg"] = "Errore di connessione al database:" . htmlspecialchars($connessione->connect_error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }

                $sql = "INSERT INTO Emergenza(CodiceUnivoco, Nome, Gravità, Durata, DanniMateriali, NumeroFeriti, NumeroVittime) VALUE (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connessione->prepare($sql);
                if ($stmt == false) {
                    $_SESSION["msg"] = "Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }
                $stmt->bind_param("isssiii", $_POST["codice-univoco-emergenza"], $_POST["nome-emergenza"], $_POST["gravita"], $_POST["durata"], $_POST["danni-materiali"], $_POST["numero-feriti"], $_POST["numero-vittime"]);
                if ($stmt->execute()) {
                    $_SESSION["msg"] = "Dati inseriti correttamente!";
                    $_SESSION["colore"] = "darkseagreen";
                } else {
                    $_SESSION["msg"] = "Il database non ha accettato l'immissione dei dati forniti. Riprova.";
                    $_SESSION["colore"] = "orangered";
                }
                $_SESSION["sql"] = $sql;
                header("Location: ../popola.php", true, 302);
            }
            break;
        case "CPR":
            if (controllaTesto($_POST["nome-cpr"]) && controllaTesto($_POST["indirizzo-cpr"]) && is_numeric($_POST["numero-telefono"])
                && controllaNumeroTelefono($_POST["numero-telefono"]) && controllaTesto($_POST["regione"]) && is_numeric($_POST["codice-univoco-cdr-ext"])) {
                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                if ($connessione->connect_error) {
                    $_SESSION["msg"] = "Errore di connessione al database:" . htmlspecialchars($connessione->connect_error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }

                $sql = "INSERT INTO CentroPeriferico(Nome, Indirizzo, NumeroTelefono, Regione, CodiceUnivocoCDR) VALUE (?, ?, ?, ?, ?)";
                $stmt = $connessione->prepare($sql);
                if ($stmt == false) {
                    $_SESSION["msg"] = "Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }
                $stmt->bind_param("ssssi", $_POST["nome-cpr"], $_POST["indirizzo-cpr"], $_POST["numero-telefono"], $_POST["regione"], $_POST["codice-univoco-cdr-ext"]);
                if ($stmt->execute()) {
                    $_SESSION["msg"] = "Dati inseriti correttamente!";
                    $_SESSION["colore"] = "darkseagreen";
                } else {
                    $_SESSION["msg"] = "Il database non ha accettato l'immissione dei dati forniti. Riprova.";
                    $_SESSION["colore"] = "orangered";
                }
                $_SESSION["sql"] = $sql;
                header("Location: ../popola.php", true, 302);
            }
            break;
        case "EnteLocale":
            if (controllaProvincia($_POST["codice-univoco-el"]) && controllaTesto($_POST["nome-el"]) && controllaTesto($_POST["nome-sede"]) && is_numeric($_POST["numero-civili"]) &&
                is_numeric($_POST["numero-abitanti"]) && controllaTesto($_POST["specializzazione"]) && controllaTesto($_POST["nome-provincia"]) &&
                controllaTesto($_POST["nome-cpr-ext"])) {
                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                if ($connessione->connect_error) {
                    $_SESSION["msg"] = "Errore di connessione al database:" . htmlspecialchars($connessione->connect_error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }

                $sql = "INSERT INTO EnteLocale(CodiceUnivoco, Nome, NomeSede, NumeroCivili, NumeroAbitanti, Specializzazione, NomeProvincia, NomeCPR) VALUE (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connessione->prepare($sql);
                if ($stmt == false) {
                    $_SESSION["msg"] = "Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }
                $stmt->bind_param("sssiisss", $_POST["codice-univoco-el"], $_POST["nome-el"], $_POST["nome-sede"], $_POST["numero-civili"], $_POST["numero-abitanti"], $_POST["specializzazione"], $_POST["nome-provincia"], $_POST["nome-cpr-ext"]);
                if ($stmt->execute()) {
                    $_SESSION["msg"] = "Dati inseriti correttamente!";
                    $_SESSION["colore"] = "darkseagreen";
                } else {
                    $_SESSION["msg"] = "Il database non ha accettato l'immissione dei dati forniti. Riprova.";
                    $_SESSION["colore"] = "orangered";
                }
                $_SESSION["sql"] = $sql;
                header("Location: ../popola.php", true, 302);
            }
            break;
        case "UnitaOperativa":
            if (controllaProvincia($_POST["sigla-provincia"]) && is_numeric($_POST["ricoverati-con-sintomi"]) && is_numeric($_POST["ricoverati-terapia-intensiva"]) && is_numeric($_POST["totale-ospedalizzati"]) &&
                is_numeric($_POST["isolamenti-domiciliari"]) && is_numeric($_POST["totale-positivi-attuale"]) && is_numeric($_POST["nuovo-totale-positivi"]) && is_numeric($_POST["nuovo-totale-guariti"]) &&
                is_numeric($_POST["nuovo-totale-deceduti"]) && is_numeric($_POST["nuovo-totale-casi"]) && is_numeric($_POST["numero-tamponi-effettuati"]) && controllaProvincia($_POST["codice-univoco-el-ext"])) {
                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                if ($connessione->connect_error) {
                    $_SESSION["msg"] = "Errore di connessione al database:" . htmlspecialchars($connessione->connect_error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }

                $sql = "INSERT INTO UnitaOperativa(SiglaProvincia, RicoveratiConSintomi, RicoveratiTerapiaIntensiva, TotaleOspedalizzati, IsolamentiDomiciliari, TotalePositiviAttuale, NuovoTotalePositivi, NuovoTotaleGuariti, NuovoTotaleDeceduti, NuovoTotaleCasi, NumeroTamponiEffettuati, CodiceUnivocoEnteLocale) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connessione->prepare($sql);
                if ($stmt == false) {
                    $_SESSION["msg"] = "Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }
                $stmt->bind_param("siiiiiiiiiis", $_POST["sigla-provincia"], $_POST["ricoverati-con-sintomi"], $_POST["ricoverati-terapia-intensiva"], $_POST["totale-ospedalizzati"], $_POST["isolamenti-domiciliari"], $_POST["totale-positivi-attuale"], $_POST["nuovo-totale-positivi"], $_POST["nuovo-totale-guariti"], $_POST["nuovo-totale-deceduti"], $_POST["nuovo-totale-casi"], $_POST["numero-tamponi-effettuati"], $_POST["codice-univoco-el-ext"]);
                if ($stmt->execute()) {
                    $_SESSION["msg"] = "Dati inseriti correttamente!";
                    $_SESSION["colore"] = "darkseagreen";
                } else {
                    $_SESSION["msg"] = "Il database non ha accettato l'immissione dei dati forniti. Riprova.";
                    $_SESSION["colore"] = "orangered";
                }
                $_SESSION["sql"] = $sql;
                header("Location: ../popola.php", true, 302);
            }
            break;
        case "Gestisce":
            if (isset($_POST["codice-univoco-cdr-ext2"]) && is_numeric($_POST["codice-univoco-cdr-ext2"]) && isset($_POST["codice-univoco-emergenza-ext"]) &&
                is_numeric($_POST["codice-univoco-emergenza-ext"])) {
                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                if ($connessione->connect_error) {
                    $_SESSION["msg"] = "Errore di connessione al database:" . htmlspecialchars($connessione->connect_error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }

                $sql = "INSERT INTO Gestisce(CodiceUnivocoCDR, CodiceUnivocoEmergenza) VALUE (?, ?)";
                $stmt = $connessione->prepare($sql);
                if ($stmt == false) {
                    $_SESSION["msg"] = "Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error);
                    $_SESSION["colore"] = "orangered";
                    $_SESSION["sql"] = "ERRORE";
                    header("Location: ../popola.php", true, 302);
                    return;
                }
                $stmt->bind_param("ii", $_POST["codice-univoco-cdr-ext2"], $_POST["codice-univoco-emergenza-ext"]);
                if ($stmt->execute()) {
                    $_SESSION["msg"] = "Dati inseriti correttamente!";
                    $_SESSION["colore"] = "darkseagreen";
                } else {
                    $_SESSION["msg"] = "Il database non ha accettato l'immissione dei dati forniti. Riprova.";
                    $_SESSION["colore"] = "orangered";
                }
                $_SESSION["sql"] = $sql;
                header("Location: ../popola.php", true, 302);
            }
            break;
    }
} else http_response_code(400); // BAD REQUEST
?>