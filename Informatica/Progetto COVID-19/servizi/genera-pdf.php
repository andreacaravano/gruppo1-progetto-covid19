<?php
if (intval(date("H")) >= 18 || isset($_GET["primo"])) {
    if (file_exists('riepiloghi/' . 'riepilogo-' . date("d-m-Y") . '.pdf')) {
        header("Location: " . 'riepiloghi/' . 'riepilogo-' . date("d-m-Y") . '.pdf', true, 302);
        return;
    }

    $query =
        "SELECT CentroPeriferico.Regione,
       SUM(UnitaOperativa.RicoveratiConSintomi)       AS RicoveratiConSintomi,
       SUM(UnitaOperativa.RicoveratiTerapiaIntensiva) AS RicoveratiTerapiaIntensiva,
       SUM(UnitaOperativa.TotaleOspedalizzati)        AS TotaleOspedalizzati,
       SUM(UnitaOperativa.IsolamentiDomiciliari)      AS IsolamentiDomiciliari,
       SUM(UnitaOperativa.TotalePositiviAttuale)      AS TotalePositiviAttuale,
       SUM(UnitaOperativa.NuovoTotalePositivi)        AS NuovoTotalePositivi,
       SUM(UnitaOperativa.NuovoTotaleGuariti)         AS NuovoTotaleGuariti,
       SUM(UnitaOperativa.NuovoTotaleDeceduti)        AS NuovoTotaleDeceduti,
       SUM(UnitaOperativa.NuovoTotaleCasi)            AS NuovoTotaleCasi,
       SUM(UnitaOperativa.NumeroTamponiEffettuati)    AS NumeroTamponiEffettuati
FROM UnitaOperativa
         INNER JOIN (EnteLocale INNER JOIN CentroPeriferico ON EnteLocale.NomeCPR = CentroPeriferico.Nome)
                    ON UnitaOperativa.CodiceUnivocoEnteLocale = EnteLocale.CodiceUnivoco
GROUP BY CentroPeriferico.Regione";

    $nomiCampiDB = array(
        "Regione", "RicoveratiConSintomi", "RicoveratiTerapiaIntensiva", "TotaleOspedalizzati", "IsolamentiDomiciliari", "TotalePositiviAttuale",
        "NuovoTotalePositivi", "NuovoTotaleGuariti", "NuovoTotaleDeceduti", "NuovoTotaleCasi", "NumeroTamponiEffettuati"
    );

    $nomiCampiVisualizzati = array(
        "Regione", "Ricoverati<br/>con sintomi", "Terapia intensiva", "Totale<br/>ospedalizzati", "Isolamenti<br/>domiciliari", "Totale positivi<br/>attuale",
        "Nuovo totale<br/>positivi", "Nuovo totale<br/>guariti", "Nuovo totale<br/>deceduti", "Nuovo totale<br/>casi", "Numero<br/>tamponi<br/>effettuati"
    );

    include "includi.php";

    $connessione = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

    $ris = $connessione->query($query);

    if ($ris == false) {
        echo "<p style='color: red;'>Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error) . "</p>";
        return;
    }
    $numRighe = $ris->num_rows;

    $contenuto = "";

    if ($numRighe > 0) {
        $contenuto .= '<table border="1" style="text-align: center;"><thead><tr>';
        for ($i = 0; $i < count($nomiCampiVisualizzati); $i++) {
            $contenuto .= '<th scope="col">';
            $contenuto .= $nomiCampiVisualizzati[$i];
            $contenuto .= '</th>';
        }
        $contenuto .= '</tr></thead><tbody>';
        while (($dati = $ris->fetch_assoc()) != null) {
            $contenuto .= "<tr>";
            $contenuto .= "<td><strong>" . torna($dati[$nomiCampiDB[0]]) . "</strong></td>";
            for ($i = 1; $i < count($nomiCampiDB); $i++) {
                $contenuto .= "<td>" . torna($dati[$nomiCampiDB[$i]]) . "</td>";
            }
            $contenuto .= "</tr>";
        }
        $contenuto .= '</tbody></table>';
    } else $contenuto = "<h4 style='color: orangered;'>Non sono stati trovati dati.</h4>";

    $connessione->close();

    include_once('TCPDF/tcpdf.php');

    class RiepilogoPDF extends TCPDF
    {
        public function Header()
        {
            $image_file = K_PATH_MAIN . 'logo-pdf.jpg';
            $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetFont('helvetica', 'B', 20);
            $this->Cell(0, 15, '', 0, true, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(0, 15, 'Riepilogo giornaliero - ' . date("d/m/Y"), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
    }

    $pdf = new RiepilogoPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator("Gruppo 1");
    $pdf->SetAuthor("Gruppo 1");
    $pdf->SetTitle("Riepilogo giornaliero - " . date("d/m/Y"));

    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setFont('dejavusans', '', 9.5, '', true);

    $pdf->AddPage("L", "A4");

    $pdf->writeHTML($contenuto);

    $pdf->Output(K_PATH_MAIN . '../riepiloghi/riepilogo-' . date("d-m-Y") . '.pdf', 'F');

    $pdf->Output('riepilogo-' . date("d-m-Y") . '.pdf', 'I');
} else {
    if (file_exists('riepiloghi/' . 'riepilogo-' . date("d-m-Y", strtotime("-1 days")) . '.pdf')) {
        header("Location: " . 'riepiloghi/' . 'riepilogo-' . date("d-m-Y", strtotime("-1 days")) . '.pdf', true, 302);
        return;
    } else {
        header("Location: genera-pdf.php?primo", true, 302);
        return;
    }
}