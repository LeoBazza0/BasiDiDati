<?php
session_start();

foreach (glob("../modules/*.php") as $filename) {
    include $filename;
}

$selected = NULL;
if (isset($_POST['NumeroSostituzioni'])) {
    $selected = $_POST['NumeroSostituzioni'];
}

$connection = connectToDatabase();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Vice Primari per numero di sostituzioni | Gestore Aziende Ospedaliere
    </title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="icon" href="../img/logo.svg">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <header class=" mx-auto mt-1 py-2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-end gap-1">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="55px" height="55px" viewBox="0 0 24 24" fill="none">
                        <path xmlns="http://www.w3.org/2000/svg"
                            d="M12 3L13.9101 4.87147L16.5 4.20577L17.2184 6.78155L19.7942 7.5L19.1285 10.0899L21 12L19.1285 13.9101L19.7942 16.5L17.2184 17.2184L16.5 19.7942L13.9101 19.1285L12 21L10.0899 19.1285L7.5 19.7942L6.78155 17.2184L4.20577 16.5L4.87147 13.9101L3 12L4.87147 10.0899L4.20577 7.5L6.78155 6.78155L7.5 4.20577L10.0899 4.87147L12 3Z"
                            stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="pb-1  fw-semibold">
                    <h1 class="my-0 py-0 fw-bold">Gestione Aziende Ospedaliere</h2>
                </div>
            </div>
            <div>
                <a class="d-flex flex-columns align-items-center justify-content-center" href="../index.php" style="text-decoration: none;">
                    <button class="btn rounded-pill btn-light btn-lg">
                        <span class=" fw-bold"> Torna alla home</span>
                    </button>
                </a>
            </div>
        </header>
    </header>

    <section class="container mx-auto">
            <div class="my-5 mx-2">
                <div class="rounded-5 py-3 px-3 bg-grey shadow-accent">
                    <div class="px-3 d-flex align-items-center justify-content-between gap-1">
                        <div class="pb-1 fw-semibold">
                           <h3 class="m-0 p-0 fw-bold">
                               <span class="cc">VISUALIZZAZIONE</span> | Ricoveri per paziente
                           </h3>
                       </div>
                        <div>

                        <form action="../opmanager.php" method="POST">
                            <input type="hidden" name="operation" value="goto_view">
                            <input type="hidden" name="table" value="ricovero">
                            <button type="submit" class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg " style=" color:rgb(255, 255, 255);">
                                <span class="fw-bold"> Visualizza la tabella</span>
                            </button>
                        </form>

                    </div>  
                </div>

                <div class="m-3">
                    <form method="POST" action="viceprimarioinfo.php">
                        <?php
                        echo showForm($selected);
                        ?>
                        <input class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg " style=" color:rgb(255, 255, 255); width: 200px;" type="submit" value="Visualizza">
                    </form>

                    <div class="d-flex justify-content-center mt-3">
                        <?php
                        if ($selected) {
                            echo showTable($selected);
                        }
                        ?>
                    </div>
                </div>
            </div>

    </section>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <?php
        echo notifyNewMessages();
        ?>
    </div>
    <script src="js/activateToasts.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>

<?php 

function showForm($selected)
{
    $options = array("Zero", "Uno", "Due+");
    $visualized = array("Nemmeno una volta", "Esattamente una volta", "Almeno due volte");

    return buildInputSelect("NumeroSostituzioni", $options, true, true, $selected, $visualized);
}

function showTable($selected) 
{
    global $connection;

    switch ($selected) {
        case "Zero":
            $query = <<<QRY
                SELECT P.CF, P.Nome, P.Cognome
                FROM VicePrimario VP JOIN Personale P ON VP.CF = P.CF
                EXCEPT
                SELECT P.CF, P.Nome, P.Cognome
                FROM Sostituzione S JOIN Personale P ON S.VicePrimario = P.CF
            QRY;
            break;
        case "Uno":
            $query = <<<QRY
                SELECT P.CF, P.Nome, P.cognome
                FROM Sostituzione S JOIN Personale P ON S.VicePrimario = P.CF
                GROUP BY P.CF, P.Nome, P.cognome
                HAVING COUNT(*) = 1
            QRY;
            break;
        case "Due+":
            $query = <<<QRY
                SELECT P.CF, P.Nome, P.cognome
                FROM Sostituzione S JOIN Personale P ON S.VicePrimario = P.CF
                GROUP BY P.CF, P.Nome, P.cognome
                HAVING COUNT(*) >= 2
            QRY;
            break;
    }
    try {
        $results = executeQuery($connection, $query);
    } catch (Exception $e) {
        memorizeError("Ricerca Sostituzioni", $e->getMessage());
        header("Refresh:0");
        exit();
    }
    $columns = getColumnsByResults($results);
    $resultData = pg_fetch_all($results);

    return buildTable($resultData, $columns);
}

