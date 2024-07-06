<?php
session_start();

foreach (glob("modules/*.php") as $filename) {
    include $filename;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Gestione aziende ospedaliere</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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

        </header>
    </header>

    <main>
        <div class="card mt-5 border-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded container text-center">
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

                <form class=" col-8 text-start " method="POST" action="opmanager.php">
                    <!-- action = manda i file in una pagina di riferimento a cui ci si rivolge per gestiree i dati che si mandano in ingresso -->
                    <h3 class="card-title fw-bold">Accedi come <p class="cc"> PAZIENTE</p>
                    </h3>
                    <input type="hidden" name="operation" value="login_as_patient">

                    <!-- nome -->
                    <?php
                    echo buildInputText("Username", 0, 16, true);
                    ?>
                    <div class="col-auto">
        <span id="passwordHelpInline" class="form-text">
            Il tuo username è il tuo codice fiscale
        </span>
                    <!-- password -->

                <?php 
                echo buildInputPassword("Password", 0, 255, true);
                ?>
                    <a href="#" class="btn btn-1 border-2 m-4 rounded-pill fw-bold "
                        style="position: absolute; right: 0; bottom: 0; color:rgb(255, 255, 255); "> Login </a>
                </form>
            </div>
        </div>

        <div class="card mt-5 border-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded container text-center">
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
                                d="M 55.078 42.803 L 45 54.44 L 34.922 42.803 c -12.728 2.118 -22.513 13.239 -22.513 26.544 v 17.707 c 0 1.621 1.326 2.946 2.946 2.946 h 59.29 c 1.621 0 2.946 -1.326 2.946 -2.946 V 69.346 C 77.591 56.042 67.805 44.921 55.078 42.803 z M 67.204 76.875 c 0 0.667 -0.541 1.208 -1.208 1.208 h -3.877 v 3.877 c 0 0.667 -0.541 1.208 -1.208 1.208 H 56.73 c -0.667 0 -1.208 -0.541 -1.208 -1.208 v -3.877 h -3.877 c -0.667 0 -1.208 -0.541 -1.208 -1.208 v -4.179 c 0 -0.667 0.541 -1.208 1.208 -1.208 h 3.877 V 67.61 c 0 -0.667 0.541 -1.208 1.208 -1.208 h 4.179 c 0.667 0 1.208 0.541 1.208 1.208 v 3.877 h 3.877 c 0.667 0 1.208 0.541 1.208 1.208 V 76.875 z"
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                    </svg>
                </div>

                <form class=" col-8 text-start" method="POST" action="opmanager.php">
                    <h3 class="card-title fw-bold">Accedi come <p class="cc"> PERSONALE</p>
                    </h3>
                    <input type="hidden" name="operation" value="login_as_worker">
                    <!-- nome -->
                    <?php
                    echo buildInputText("Username", 0, 16, true);
                    ?>
                    <div class="col-auto">
                    <span id="passwordHelpInline" class="form-text">
                         Il tuo username è il tuo codice fiscale
                    </span>
                    <!-- password -->
                    <?php 
                    echo buildInputPassword("Password", 0, 255, true);
                    ?>

                    <a href="#" class="btn btn-1 border-2 m-4 rounded-pill fw-bold "
                        style="position: absolute; right: 0; bottom: 0; color:rgb(255, 255, 255); "> Login </a>

                </form>
            </div>
        </div>
    </main>
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