<?php
session_start();

foreach (glob("modules/*.php") as $filename) {
    include $filename;
}

$table = $_SESSION['table'];
$actions = $_SESSION['logged_user']['type'] == 'worker';


?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Inserisci | Gestione aziende ospedaliere</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="icon" href="img/logo.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
          <a class="d-flex flex-columns align-items-center justify-content-center" href="index.php" style="text-decoration: none;">
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
                               <span class="cc">INSERISCI</span> |<?php echo ucfirst($table) ?>
                           </h3>
                       </div>
          <?php 
                if ($table && $actions) {
                  echo <<<EOD
                    <div>
                        <form action="opmanager.php" method="POST">
                            <input type="hidden" name="operation" value="goto_view">
                            <input type="hidden" name="table" value="$table">
                            <button type="submit" class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg " style=" color:rgb(255, 255, 255);">                               
                             <span class=" fw-bold"> visualizza la tabella</span>
                            </button>
                        </form>
                    </div>
                  EOD;
                };
            ?>
        </div>
        <div class="m-3" >
          <form method="POST" action="opmanager.php">
            <input type="hidden" name="operation" value="insert">
            <input type="hidden" name="table" value="<?php echo $table ?>">
            <?php echo buildInsertForm(); ?>
            <input class="btn btn-1 border-2 m-2 rounded-pill fw-bold btn-lg " style=" color:rgb(255, 255, 255); width: 200px;" type="submit" value="Inserisci">
          </form>
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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>

<?php

function buildInsertForm() 
{
  global $table;
  $formFields = array();
  $connection = connectToDatabase();
  $columns = getColumnsInformation($connection, $table);
  $foreignKeys = getForeignKeyConstraints($connection, $table);

  if (isset($_SESSION['inserted_data'])) {
    $alreadyInsertedValues = $_SESSION['inserted_data'];
    $alreadyInsertedValues = array_change_key_case($alreadyInsertedValues, CASE_LOWER);
    unset($_SESSION['inserted_data']);
  } else {
    $alreadyInsertedValues = NULL;
  }

  if (isset($_SESSION['disabled_fields'])) {
    $disabledFields = $_SESSION['disabled_fields'];
    unset($_SESSION['disabled_fields']);
  } else {
    $disabledFields = NULL;
  }

  $formFields += getReferentialInputFields($connection, $columns, $foreignKeys, $disabledFields, $alreadyInsertedValues);
  $formFields += getStandardInputFields($connection, $columns, $disabledFields, $alreadyInsertedValues);

  ksort($formFields);


  return implode('', $formFields);

}

?>
