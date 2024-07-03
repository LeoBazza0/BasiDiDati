<?php
session_start();
ob_start();

foreach (glob("modules/*.php") as $filename) {
    include $filename;
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Profilo | Gestione aziende ospedaliere</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/certificate-svgrepo-com.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
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
                <form action="opmanager.php" method="POST">
                    <input type="hidden" name="operation" value="logout">
                    <button type="submit" class="btn rounded-pill btn-light btn-lg">
                        <span class=" fw-bold"> Disconnettiti</span>
                    </button>
                </form>
            </div>
        </header>
    </header>
    <section class="container mx-auto">
        <?php

        if (!isset($_SESSION['logged_user'])) {
            memorizeError("Accesso", "Accedi per poter accedere alla Home Page");
            header("Location: {$DEFAULT_DIR}/login.php");
            exit();
        }

        $loggedUser = $_SESSION['logged_user'];

        switch ($loggedUser['type']) {
            case 'patient':
                echo loadPatientHomePage();
                break;
            case 'worker':
                echo loadWorkerHomePage();
                break;
        }

        ?>
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

function loadPatientHomePage()
{
    global $loggedUser;

    $connection = connectToDatabase();

    $userData = getPatientInfo($connection, $loggedUser['username']);
    $userAppointments = getPatientFutureAppointments($connection, $loggedUser['username']);
    $latestHospitalization = getPatientLatestHospitalization($connection, $loggedUser['username']);
    $diagnosis = getDiagnosis($connection, $latestHospitalization['codice']);


    $userTimeline = buildAppointmentsTimeline($userAppointments);
    $dataFine = $latestHospitalization['ospedale'] or "IN CORSO";

    echo <<<EOD 
    <div class="card mt-2 border-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded container text-center">
                <div class="row">
                    <div class=" align-items-center justify-content-center col-3">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                            width="150" height="150" viewBox="0 0 256 256" xml:space="preserve">
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                <path
                                    d="M 45 40.375 L 45 40.375 c -9.415 0 -17.118 -7.703 -17.118 -17.118 v -6.139 C 27.882 7.703 35.585 0 45 0 h 0 c 9.415 0 17.118 7.703 17.118 17.118 v 6.139 C 62.118 32.672 54.415 40.375 45 40.375 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                <path
                                    d="M 54.639 42.727 C 51.743 44.226 48.47 45.09 45 45.09 s -6.743 -0.863 -9.639 -2.363 c -12.942 1.931 -22.952 13.162 -22.952 26.619 v 17.707 c 0 1.621 1.326 2.946 2.946 2.946 h 59.29 c 1.621 0 2.946 -1.326 2.946 -2.946 V 69.347 C 77.591 55.889 67.581 44.659 54.639 42.727 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>

                    <div class=" col-8 text-start ">
                        <h3 class="card-title fw-bold border-bottom border-5"> <span class="cc">BUONGIORNO</span> {$userData['nome']} {$userData['cognome']} <span class="cc">!</span></h3>
                        <div class="row g-3 align-items-center py-2 fw-bold">
                            <table class="ps-5">
                                <tr>
                                    <th class="text-uppercase fw-bold cc py-2"> Codice Fiscale </th>
                                    <td class="my-1"> {$userData['cf']} </td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase fw-bold cc py-2"> Data di Nascita </th>
                                    <td class="my-1">  {$userData['datanascita']} (Età {$userData['eta']} anni) </td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase fw-bold cc py-2"> Indirizzo </th>
                                    <td class="my-1"> ({$userData['cap']}) Via {$userData['via']}, {$userData['nciv']} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card mt-2 border-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded container "
                        style="min-height: 300px;">
                        <h3 class="card-title fw-bold border-5"> Ultimo <span class="cc">RICOVERO </span> :</h3>
                        <div class="row ps-4">
                            <table class="ps-5">
                                <tr> <th style="max-width:70px" class="text-uppercase fw-semibold"> Ospedale </th><td class="my-1"> {$latestHospitalization['ospedale']} </td> </tr>
                                <tr> <th style="max-width:70px" class="text-uppercase fw-semibold"> Reparto </th><td class="my-1"> {$latestHospitalization['reparto']} </td> </tr>
                                <tr> <th style="max-width:70px" class="text-uppercase fw-semibold"> Stanza </th><td class="my-1"> {$latestHospitalization['stanza']} </td> </tr>
                                <tr> <th style="max-width:70px" class="text-uppercase fw-semibold"> Data di Accettazione </th><td class="my-1"> {$latestHospitalization['datainizio']} </td> </tr>
                                <tr> <th style="max-width:70px" class="text-uppercase fw-semibold"> Data di Dimissione </th><td class="my-1"> {$dataFine} </td> </tr>
                                <tr> <th style="max-width:70px" class="text-uppercase fw-semibold"> Diagnosi </th><td class="my-1">  {$diagnosis}  </td> </tr>
                            </table>
                        </div>               
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <form method="POST" action="opmanager.php">
                            <input type="hidden" name="operation" value="view_hospitalizations">
                            <button class="btn btn-1 border-2 m-4 rounded-pill fw-bold" type="submit">
                                Visualizza tutti i Ricoveri
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col position-relative">
                    <form method="POST" action="opmanager.php">
                        <input type="hidden" name="operation" value="request_appointment">
                        <button class="btn btn-1 border-2 m-4 rounded-pill fw-bold btn-lg " type="submit" style=" color:rgb(255, 255, 255); width: 90%;">
                            Fai una nuova prenotazione
                        </button>
                    </form>
                    <p class="text-secondary text-center pt-3 mb-0"> Per prenotare per un Esame è necessario effettuare una Richiesta. <br>


                    <div class="card mt-2 border-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded container "
                        style="min-height: 200px">
                        <h3 class="card-title fw-bold border-5"> Prossimi <span class="cc">EVENTI </span> :</h3>
                        <div class="timeline p-3 block mb-4"> 
                            {$userTimeline}
                        </div>

                        <form method="POST" action="opmanager.php">
                            <input type="hidden" name="operation" value="view_appointments">
                            <button class="btn btn-1 border-2 m-4 rounded-pill fw-bold" type="submit" style=" color:rgb(255, 255, 255); position: relative; right: 0; bottom: 0;" >
                                Visualizza tutte le Prenotazioni
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </main>
        EOD;
}

function loadWorkerHomePage()
{
    global $loggedUser;

    $connection = connectToDatabase();

    $userData = getWorkerInfo($connection, $loggedUser['username']);

    $appointmentRequests = getAppointmentRequests($connection);
    $countRequests = count($appointmentRequests);

    $appointmentsTable = buildAppointmentRequestsTable($appointmentRequests);

    $tables = array_map(fn ($el) => $el['table'], getAllTables($connection));
    $tablesSelection = buildInputSelect("Tabella", array_map('ucfirst', $tables), true);

    echo <<<EOD
        <div class="card mt-2 border-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded container text-center">
            <div class="row">
                <div class=" align-items-center justify-content-center col-3">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        width="150" height="150" viewBox="0 0 256 256" xml:space="preserve">
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                            transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                            <path
                                d="M 45 40.375 L 45 40.375 c -9.415 0 -17.118 -7.703 -17.118 -17.118 v -6.139 C 27.882 7.703 35.585 0 45 0 h 0 c 9.415 0 17.118 7.703 17.118 17.118 v 6.139 C 62.118 32.672 54.415 40.375 45 40.375 z"
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path
                                d="M 54.639 42.727 C 51.743 44.226 48.47 45.09 45 45.09 s -6.743 -0.863 -9.639 -2.363 c -12.942 1.931 -22.952 13.162 -22.952 26.619 v 17.707 c 0 1.621 1.326 2.946 2.946 2.946 h 59.29 c 1.621 0 2.946 -1.326 2.946 -2.946 V 69.347 C 77.591 55.889 67.581 44.659 54.639 42.727 z"
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                    </svg>
                </div>

                <div class=" col-8 text-start ">
                    <h3 class="card-title fw-bold border-bottom border-5"> <span class="cc">BUONGIORNO</span> {$userData['nome']} {$userData['cognome']} <span class="cc">!</span></h3>
                    <div class="row g-3 align-items-center py-2 fw-bold">
                        <table class="ps-5">
                            <tr>
                                <th class="text-uppercase fw-bold cc py-2"> Codice fiscale </th>
                                <td class="my-1"> {$userData['cf']} </td>
                            </tr>
                            <tr>
                                <th class="text-uppercase fw-bold cc py-2"> Data di nascita </th>
                                <td class="my-1"> {$userData['datanascita']} (Età {$userData['eta']} anni) </td>
                            </tr>
                            <tr>
                                <th class="text-uppercase fw-bold cc py-2"> Indirizzo </th>
                                <td class="my-1"> ({$userData['cap']}) Via {$userData['via']}, {$userData['nciv']} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card mt-2 border-5 shadow-lg p-3  bg-body-tertiary rounded container "
                    style="min-height: 300px;">
                    <h3 class="card-title fw-bold "> Ci sono <span class="cc"> {$countRequests} </span> richieste di prenotaizione</h3> 
                    <div class="mt-3 fs-5 ms-2">
                        {$appointmentsTable}
                    </div>
                </div>
            </div>

            <div class="col position-relative">
                <h3 class="card-title fw-bold mt-4 mb-1 "> Visualizza: </h3>
                <a href="pages/personalereparto.php" class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg "
                    style=" color:rgb(255, 255, 255); width: 90%;"> Personale reparto </a>
                <a href="pages/ricoveripaziente.php" class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg "
                    style=" color:rgb(255, 255, 255); width: 90%;"> Ricovero per paziente </a>
                <a href="pages/viceprimariinfo.php" class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg "
                    style=" color:rgb(255, 255, 255); width: 90%;"> Sostituzione primari per numero </a>
            </div>
        </div>
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <h3 class="card-title fw-bold mt-2 "> Visualizza una tabella nel database</h3>
                    <form method="POST" action="opmanager.php">
                        <input type="hidden" name="operation" value="view_table_by_select">
                        {$tablesSelection}
                        <button class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg" type="submit"
                            style=" color:rgb(255, 255, 255); inline-size: 40%;">
                            Visualizza
                        </button>
                    </form>
                </div>
                <div class="col">
                    <h3 class="card-title fw-bold m-1 "> Modifica una tabella nel database </h3>
                    <form method="POST" action="opmanager.php">
                        <input type="hidden" name="operation" value="insert_by_select">
                        {$tablesSelection}
                        <button class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg" type="submit"
                            style=" color:rgb(255, 255, 255); inline-size: 40%;">
                            Modifica
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
        EOD;
}

?>
