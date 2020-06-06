<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Inserimento dati - Gruppo 1 - Progetto COVID-19 (Protezione Civile)</title>
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
                padding-top: 20px;
                padding-bottom: 5vh;
            }

            .container {
                max-width: 90vw;
            }

            .table {
                margin-bottom: 0;
            }

            h4 {
                padding-top: 10px;
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
            session_start();

            include "servizi/includi.php";

            if (isset($_SESSION["sql"]) && isset($_SESSION["msg"]) && isset($_SESSION["colore"])) {
                ?>
                <h2 style="color: <?php echo $_SESSION["colore"] ?>;"><?php echo $_SESSION["msg"] ?></h2>
                <pre><code class="language-sql"><?php echo $_SESSION["sql"] ?></code></pre>
                <?php
                header("refresh: 5;url=popola.php");
                session_unset();
                session_destroy();
            } else {
                tornaNAV();
                include "servizi/includi-campi.php";

                for ($i = 0; $i < count($campi); $i++) {
                    ?>
                    <div style="text-align: center; padding-top: 50px;">
                        <h2 style="color: cornflowerblue;"><?php echo $intestazioni[$i] ?></h2>
                    </div>
                    <form name="modulo" method="POST" action="servizi/inserisci-dati.php">
                        <input type="hidden" name="ambito" value="<?php echo $identificativi[$i] ?>"/>
                        <div class="table-responsive">
                            <table border="1" class="table table-striped table-bordered table-hover"
                                   style="text-align: center;">
                                <thead>
                                    <tr>
                                        <?php
                                        for ($j = 0; $j < count($campi[$i]); $j++) {
                                            ?>
                                            <th scope="col">
                                                <label<?php echo (!empty($nomiTag[$i][$j])) ? " for='" . $nomiTag[$i][$j] . "'" : "" ?>>
                                                    <?php echo $campi[$i][$j] ?>
                                                </label>
                                            </th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php echo $form[$i] ?>
                                    </tr>
                                    <tr>
                                        <td colspan="<?php echo count($campi[$i]) ?>">
                                            <div style="text-align: center;">
                                                <input type="submit" name="submit" value="INVIA"
                                                       class="btn btn-primary"/>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <?php
                    echo "<h4>Dati attualmente presenti:</h4>";

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
                $connessione->close();
            }
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
        <script type="text/javascript">
            $.datepicker.setDefaults($.datepicker.regional["it"]);
            $(function () {
                $("#data-nascita").datepicker({
                    maxDate: "+0D",
                    "dateFormat": "dd/mm/yy",
                    "showAnim": "slideDown"
                });
            });
            $(function () {
                $("#data-inizio-mandato").datepicker({
                    maxDate: "+0D",
                    "dateFormat": "dd/mm/yy",
                    "showAnim": "slideDown"
                });
            });

            new TimePicker(['durata'], {
                theme: 'dark',
                lang: 'en',
            }).on('change', function (evt) {
                // console.info(evt);
                evt.element.value = (evt.hour || '00') + ':' + (evt.minute || '00');
            });
        </script>
    </body>
</html>