<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Gruppo 1 - Progetto COVID-19 (Protezione Civile)</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../rsc/css/bootstrap.min.css"/>
        <style type="text/css">
            body {
                padding-top: 5vh;
            }

            h3 {
                padding-bottom: 10px;
            }
        </style>
        <link rel="stylesheet" href="../rsc/css/prism.css"/>
    </head>
    <body>
        <main role="main" class="container">
            <?php
            if (isset($_GET["chiedi"])) {
                ?>
                <script type="text/javascript">
                    if (confirm("Continuando, il Database verrà eliminato e ricostruito. Confermi di voler proseguire?"))
                        window.location = "crea-db.php?lancia";
                    else
                        window.location = "../index.php";
                </script>
                <?php
            }
            if (isset($_GET["lancia"])) {
                header("refresh: 20;../index.php");

                include "includi.php";

                $connessione = new mysqli($DBServer, $DBUser, $DBPass);

                if ($connessione->connect_error) {
                    echo "<p style='color: red;'>Errore di connessione al database: " . htmlspecialchars($connessione->connect_error) . "</p>";
                    return;
                }

                $sql = file_get_contents("../sql/crea-db.sql");
                $ris = $connessione->multi_query($sql);
                if ($ris == false) {
                    echo "<p style='color: red;'>Non &egrave; stato possibile continuare: " . htmlspecialchars($connessione->error) . "</p>";
                    return;
                }
                ?>
                <h3 style="color: darkseagreen;">
                    Creazione database completata correttamente!&nbsp;
                    <span style="color: cornflowerblue;">
                        Redirezione alla pagina iniziale in corso...
                    </span>
                </h3>
                <pre><code class="language-sql"><?php echo $sql; ?></code></pre>
                <?php
                $connessione->close();
            } else {
                ?>
                <h4 style="color: orangered;">
                    La pagina &egrave; stata richiamata in modo inopportuno. Verificare la correttezza della richiesta
                    prodotta.
                </h4>
                <?php
            }
            ?>
        </main>
        <script type="text/javascript" src="../rsc/js/prism.js"></script>
    </body>
</html>