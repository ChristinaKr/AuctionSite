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

// instantiate recommendation object
include_once '../models/Recommendation.php';

$database = new Database();
$db = $database->getConnection();

$recommendation = new Recommendation($db);




// set recommendation property values
$recommendation->UserID = $_POST["UserID"];
$recommendation->ItemID = $_POST["ItemID"];

//$recommendation->created = date('Y-m-d H:i:s');

//echo json_encode($recommendation);

// create the recommendation
if($recommendation->create()){
    echo '{';
    echo '"message": "Recommendation was created."';
    echo '}';
}

// if unable to create the recommendation, tell the recommendation
else{
    echo '{';
    echo '"message": "Unable to create recommendation."';
    echo '}';
}
