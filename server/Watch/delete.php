<?php
// Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../models/Watch.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare watch object
$watch = new Watch($db);

// get watch id


// set watch id to be deleted
$watch->UserID = $_POST["UserID"];
$watch->ItemID = $_POST["ItemID"];

// TODO: Check that the user id is the userID;

// delete the watch
if($watch->delete()){
    echo '{';
        echo '"message": "Watch was deleted."';
    echo '}';
}

// if unable to delete the watch
else{
    echo '{';
        echo '"message": "Unable to delete watch."';
    echo '}';
}
