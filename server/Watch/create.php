<?php
/**
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate watch object
include_once '../models/Watch.php';

$database = new Database();
$db = $database->getConnection();

$watch = new Watch($db);

// TODO: Auth everywhere

// set watch property values
$watch->UserID = $_POST["UserID"];
$watch->ItemID = $_POST["ItemID"];

//$watch->created = date('Y-m-d H:i:s');

//echo json_encode($watch);

// TODO: Check that the user id is the userID;

// create the watch
if($watch->create()){
    echo '{';
    echo '"message": "Watch-item was created."';
    echo '}';
}

// if unable to create the watch, tell the watch
else{
    echo '{';
    echo '"message": "Unable to create watch-item."';
    echo '}';
}
