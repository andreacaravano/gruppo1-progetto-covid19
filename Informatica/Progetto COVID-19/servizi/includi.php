<?php
function validaData($data)
{
    if (preg_match("~^(((0[1-9]|[12]\\d|3[01])/(0[13578]|1[02])/((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)/(0[13456789]|1[012])/((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])/02/((19|[2-9]\\d)\\d{2}))|(29/02/((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$~", $data)) {

        $regexDataUSA = "/^((2000|2400|2800|(19|2[0-9](0[48]|[2468][048]|[13579][26])))-02-29)$"
            . "|^(((19|2[0-9])[0-9]{2})-02-(0[1-9]|1[0-9]|2[0-8]))$"
            . "|^(((19|2[0-9])[0-9]{2})-(0[13578]|10|12)-(0[1-9]|[12][0-9]|3[01]))$"
            . "|^(((19|2[0-9])[0-9]{2})-(0[469]|11)-(0[1-9]|[12][0-9]|30))$/";

        $comp = explode("/", $data);
        $dataConvertita = $comp[2] . "-" . $comp[1] . "-" . $comp[0];

        if (preg_match($regexDataUSA, $dataConvertita))
            return true;
        else
            return false;
    } else return false;
}

function torna($param)
{
    $regexDataUSA = "/^((2000|2400|2800|(19|2[0-9](0[48]|[2468][048]|[13579][26])))-02-29)$"
        . "|^(((19|2[0-9])[0-9]{2})-02-(0[1-9]|1[0-9]|2[0-8]))$"
        . "|^(((19|2[0-9])[0-9]{2})-(0[13578]|10|12)-(0[1-9]|[12][0-9]|3[01]))$"
        . "|^(((19|2[0-9])[0-9]{2})-(0[469]|11)-(0[1-9]|[12][0-9]|30))$/";

    if (preg_match($regexDataUSA, $param)) {
        $comp = explode("-", $param);
        return $comp[2] . "/" . $comp[1] . "/" . $comp[0];
    } else return $param;
}

function controllaTesto($param)
{
    if (!empty($param) && strlen($param) < 256)
        return true;
    else return false;
}

function validaTempo($tempo)
{
    if (preg_match("/^[0-9]{1,10}[:][0-9]{2}$/", $tempo))
        return true;
    else return false;
}

function controllaNumeroTelefono($num)
{
    if (!empty($num) && strlen($num) < 15)
        return true;
    else return false;
}

function controllaProvincia($prov)
{
    if (!empty($prov) && strlen($prov) == 2)
        return true;
    else return false;
}

function tornaNAV()
{
    echo "<nav class='navbar navbar-dark navbar-expand-md fixed-top bg-dark barraNav'>
    <div class='container'>
        <button data-toggle='collapse' class='navbar-toggler' data-target='#menu'>
            <span class='sr-only'></span>
            <span class='navbar-toggler-icon'>
                        <i class='la la-navicon'></i>
                    </span>
        </button>
        <div class='collapse navbar-collapse' id='menu'>
            <ul class='nav navbar-nav flex-grow-1 justify-content-between'>
                <li class='nav-item' role='presentation' style='padding-top: 0.15rem;'>
                    <a class='nav-link' href='index.php'>
                        <div class='fas fa-virus logoNav' style='color: violet;'>
                            &nbsp;
                            <span style=\"font-family: 'Roboto Condensed', sans-serif; color: #ffffff !important;\" id='contenuto-intestazione'>
                                Progetto <em>COVID-19</em> (Informatica - Interrogazioni SQL)
                            </span>
                        </div>
                    </a>
                </li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                <li class='nav-item d-none d-xs-block d-md-block' role='presentation'></li>
                
                <li class='nav-item' role='presentation'>
                    <a class='nav-link' href='servizi/crea-db.php?chiedi'>
                        <div class='fas fa-server'>
                            &nbsp;
                            <span style=\"font-family: 'Roboto Slab', serif;\">
                                Costruzione del Database
                            </span>
                        </div>
                    </a>
                </li>
                
                <li class='nav-item' role='presentation'>
                    <a class='nav-link' href='popola.php'>
                        <div class='fas fa-database'>
                            &nbsp;
                            <span style=\"font-family: 'Roboto Slab', serif;\">
                                Inserimento dati
                            </span>
                        </div>
                    </a>
                </li>
                
                <li class='nav-item' role='presentation'>
                    <a class='nav-link' href='servizi/genera-pdf.php'>
                        <div class='fas fa-file-pdf'>
                            &nbsp;
                            <span style=\"font-family: 'Roboto Slab', serif;\">
                                Scarica riepilogo giornaliero
                            </span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>";
}

$DBServer = 'localhost';
$DBUser = 'root';
$DBPass = '';
$DBName = 'dbProgettoCOVID19';
?>