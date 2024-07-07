<?php
error_reporting(E_ERROR); //Fa vedere gli errori, se commentato no

//Connection to Database
function connectToDatabase()
{
    include 'vars.php'; 
    
    $connection = pg_connect($CONNECTION_STRING);
    if (!$connection) {
        echo '<br> Connessione al database fallita. <br>';
        exit();
    }
    return $connection;
}

function executeQuery($connection, $query, $params = NULL)
{
    if (!$params) {
        $result = pg_query($connection, $query); //pg_query() executes the query on the specified database connection
    } else {
        $result = pg_query_params($connection, $query, $params); //pg_query_params() is like pg_query() with more functionalities: parameter values can be specified separately from the command string proper. 
    }
    if (!$result) {
        throw new Exception(pg_last_error($connection));
    }
    return $result;
}

