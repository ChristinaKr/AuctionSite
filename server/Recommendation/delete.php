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
include_once '../models/Recommendation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare Recommendation object
$recommendation = new Recommendation($db);

// get Recommendation id


// set Recommendation to be deleted
$recommendation->UserID = $_POST["UserID"];
$recommendation->ItemID = $_POST["ItemID"];

// delete the Recommendation
if($recommendation->delete()){
    echo '{';
        echo '"message": "Recommendation was deleted."';
    echo '}';
}

// if unable to delete the Recommendation
else{
    echo '{';
        echo '"message": "Unable to delete recommendation."';
    echo '}';
}
