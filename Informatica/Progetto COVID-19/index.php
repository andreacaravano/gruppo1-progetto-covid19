<?php
/*
 *  Studenti: Gruppo 1
 *    Classe: 5DIN
 *      A.S.: 2019/2020
 *
 * Ultima modifica: 29/05/2020
 *
 * Descrizione: Progetto interdisciplinare COVID-19/Protezione Civile in Informatica (PHP)
 */
?>
<?php
include "servizi/includi.php";

$connessione = new mysqli($DBServer, $DBUser, $DBPass);

if ($connessione->connect_error) {
    echo "<p style='color: red;'>Errore di connessione al database: " . htmlspecialchars($connessione->connect_error) . "</p>";
    return;
}
mysqli_set_charset($connessione, 'UTF-8');
$ris = $connessione->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'dbProgettoCOVID19'");
if ($ris->num_rows <= 0) {
    $connessione->close();
    header("Location: servizi/crea-db.php?lancia", true, 302);
    return;
}
$connessione->close();
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Gruppo 1 - Progetto COVID-19 (Protezione Civile)</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="rsc/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="nav-src/fa/css/fontawesome.min.css">
        <link rel="stylesheet" href="nav-src/fa/css/brands.css">
        <link rel="stylesheet" href="nav-src/fa/css/solid.css">
        <link rel="stylesheet" href="nav-src/la/css/line-awesome.min.css">
        <link rel="stylesheet" href="nav-src/stile-navbar1.css">
        <link rel="stylesheet" href="nav-src/stile-navbar2.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,700;1,700&display=swap"
              rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap"
              rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 50px;
                padding-bottom: 5vh;
            }

            .container {
                max-width: 90vw;
            }

            .table {
                margin-bottom: 0;
            }

            h4 {
                padding-top: 30px;
                padding-bottom: 5px;
            }
        </style>
        <link rel="stylesheet" href="rsc/css/prism.css"/>
        <link rel="stylesheet" href="datepicker-src/jquery-ui.css"/>
        <link rel="stylesheet" href="timepicker-rsc/timepicker.min.css">
        <script type="text/javascript" src="timepicker-rsc/timepicker.min.js"></script>
    </head>
    <body>
        <main role="main" class="container">
            <?php
            tornaNAV();
            include "servizi/includi-campi.php";

            for ($i = 0; $i < count($campi); $i++) {
                echo "<h4>Dati attualmente presenti (<span style='color: cornflowerblue;'>$intestazioni[$i]</span>):</h4>";

                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                $ris = $connessione->query($interrogazioni[$i]);

                if ($ris == false) {
                    echo "<p style='color: red;'>Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error) . "</p>";
                    return;
                }
                $numRighe = $ris->num_rows;

                if ($numRighe > 0) {
                    ?>
                    <div class="table-responsive">
                        <table border="1" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <?php
                                    for ($j = 0; $j < count($campi[$i]); $j++) {
                                        ?>
                                        <th scope="col">
                                            <?php echo $campi[$i][$j] ?>
                                        </th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                while (($dati = $ris->fetch_assoc()) != null) {
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $dati[$campiDB[$i][0]] . "</th>";
                                    for ($j = 1; $j < count($campiDB[$i]); $j++) {
                                        echo "<td>" . torna($dati[$campiDB[$i][$j]]) . "</td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else echo "<h4 style='color: orangered;'>Non sono stati trovati dati.</h4>";
            }

            $intestazioniAddizionali = array(
                "[Query 1]: Il numero totale dei guariti per ogni regione",
                "[Query 2]: La provincia con il peggior rapporto positivi/popolazione",
                "[Query 3]: Il nome del CDR che ha effettuato il maggior numero di tamponi",
                "[Query 4]: Le regioni con un numero di persone in isolamento domiciliare superiore a 500"
            );

            $interrogazioniAddizionali = array(
                "
SELECT CentroPeriferico.Regione, SUM(UnitaOperativa.NuovoTotaleGuariti) AS NuovoTotaleGuariti
FROM UnitaOperativa
         INNER JOIN (EnteLocale INNER JOIN CentroPeriferico ON EnteLocale.NomeCPR = CentroPeriferico.Nome)
                    ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
GROUP BY CentroPeriferico.Regione;",

                "
SELECT FIRST_VALUE(EnteLocale.NomeProvincia) OVER (ORDER BY EnteLocale.NomeProvincia) AS Provincia
FROM UnitaOperativa
         INNER JOIN EnteLocale ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
WHERE (UnitaOperativa.TotalePositiviAttuale / EnteLocale.NumeroAbitanti) = (
    SELECT MAX(UnitaOperativa.TotalePositiviAttuale / EnteLocale.NumeroAbitanti)
    FROM UnitaOperativa
             INNER JOIN EnteLocale
                        ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
);",
                "
SELECT CapoDipartimentoRegionale.Nome, CapoDipartimentoRegionale.Cognome
FROM UnitaOperativa
         INNER JOIN (EnteLocale INNER JOIN (CentroPeriferico INNER JOIN CapoDipartimentoRegionale ON
        CentroPeriferico.CodiceUnivocoCDR =
        CapoDipartimentoRegionale.CodiceUnivoco) ON EnteLocale.NomeCPR = CentroPeriferico.Nome)
                    ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
GROUP BY CapoDipartimentoRegionale.Nome, CapoDipartimentoRegionale.Cognome
ORDER BY(SUM(UnitaOperativa.NumeroTamponiEffettuati)) DESC
LIMIT 1;
                ",

                // VERSIONE ALTERNATIVA (QUERY 3)

                /* "
SELECT FIRST_VALUE(CapoDipartimentoRegionale.Nome)
                   OVER (ORDER BY CapoDipartimentoRegionale.Cognome) AS Nome,
       FIRST_VALUE(CapoDipartimentoRegionale.Cognome)
                   OVER (ORDER BY CapoDipartimentoRegionale.Cognome) AS Cognome
FROM UnitaOperativa
         INNER JOIN (EnteLocale INNER JOIN (CentroPeriferico INNER JOIN CapoDipartimentoRegionale ON
        CentroPeriferico.CodiceUnivocoCDR =
        CapoDipartimentoRegionale.CodiceUnivoco) ON EnteLocale.NomeCPR = CentroPeriferico.Nome)
                    ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
WHERE UnitaOperativa.NumeroTamponiEffettuati = (
    SELECT DISTINCT FIRST_VALUE(UnitaOperativa.NumeroTamponiEffettuati)
                                OVER (ORDER BY UnitaOperativa.NumeroTamponiEffettuati DESC)
    FROM UnitaOperativa
             INNER JOIN (EnteLocale INNER JOIN (CentroPeriferico INNER JOIN CapoDipartimentoRegionale ON
            CentroPeriferico.CodiceUnivocoCDR =
            CapoDipartimentoRegionale.CodiceUnivoco) ON EnteLocale.NomeCPR = CentroPeriferico.Nome)
                        ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
    GROUP BY CentroPeriferico.Regione
);", */
                "
SELECT CentroPeriferico.Regione
FROM UnitaOperativa
         INNER JOIN (EnteLocale INNER JOIN CentroPeriferico ON EnteLocale.NomeCPR = CentroPeriferico.Nome)
                    ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
GROUP BY CentroPeriferico.Regione
HAVING SUM(UnitaOperativa.IsolamentiDomiciliari) > 500;"
            );

            $campiAddizionaliDB = array(
                array("Regione", "NuovoTotaleGuariti"),
                array("Provincia"),
                array("Nome", "Cognome"),
                array("Regione")
            );

            $nomiCampiAddizionali = array(
                array("Regione", "NuovoTotaleGuariti"),
                array("Provincia"),
                array("Nome", "Cognome"),
                array("Regione")
            );

            for ($i = 0; $i < count($interrogazioniAddizionali); $i++) {
                echo "<h4>$intestazioniAddizionali[$i]</h4>";

                $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

                $ris = $connessione->query($interrogazioniAddizionali[$i]);

                if ($ris == false) {
                    echo "<p style='color: red;'>Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error) . "</p>";
                    return;
                }
                $numRighe = $ris->num_rows;

                if ($numRighe > 0) {
                    ?>
                    <div class="table-responsive">
                        <table border="1" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <?php
                                    for ($j = 0; $j < count($nomiCampiAddizionali[$i]); $j++) {
                                        ?>
                                        <th scope="col">
                                            <?php echo $nomiCampiAddizionali[$i][$j] ?>
                                        </th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                while (($dati = $ris->fetch_assoc()) != null) {
                                    echo "<tr>";
                                    for ($j = 0; $j < count($campiAddizionaliDB[$i]); $j++) {
                                        echo "<td>" . torna($dati[$campiAddizionaliDB[$i][$j]]) . "</td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else echo "<h4 style='color: orangered;'>Non sono stati trovati dati.</h4>";
            }

            $connessione->close();
            ?>
        </main>
        <?php
        ?>
        <script type="text/javascript" src="rsc/js/prism.js"></script>
        <script type="text/javascript" src="bootstrap-rsc/js/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap-rsc/js/bootstrap.min.js"></script>
        <script src="datepicker-src/jquery-ui.min.js"></script>
        <script src="nav-src/navbar.js"></script>
        <script type="text/javascript" src="datepicker-src/datepicker-it.js"></script>
    </body>
</html>
