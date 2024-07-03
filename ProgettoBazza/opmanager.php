<?php
session_start();

foreach (glob("modules/*.php") as $filename) {
    include $filename;
}

$connection = connectToDatabase();

//Get POST Data
$table = strtolower($_POST['table']); 
$operation = strtolower($_POST['operation']);
$attributes = parsePostValues();

//Clear SESSOIN
$loggedUser = $_SESSION['logged_user'];
session_unset();
$_SESSION['logged_user'] = $loggedUser;

//Do OPERATIONS 
switch ($operation) {
    case 'login_as_patient':
        loginAsPatient($connection);
        header("Location: {$DEFAULT_DIR}/index.php");
        exit();
    case 'login_as_worker':
        loginAsWorker($connection);
        header("Location: {$DEFAULT_DIR}/index.php");
        exit();

    }


