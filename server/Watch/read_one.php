<?php

/**
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../models/Watch.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare watch object
$watch = new Watch($db);

// set ID property of watch to be edited
$watch->UserID = isset($_GET['UserID']) ? $_GET['UserID'] : die('{"message": "Please enter a UserID."}');
$watch->ItemID = isset($_GET['ItemID']) ? $_GET['ItemID'] : die('{"message": "Please enter an ItemID."}');

// check that watch is valid
$watch->readOne();

if ($watch->ItemID) {
    // create array
    $watch_arr = array(
        "UserID" => $watch->UserID,
        "ItemID" => $watch->ItemID,
    );

    echo(json_encode($watch_arr));
} else {
    echo '{"message": "Please enter an ItemID."}';
}
