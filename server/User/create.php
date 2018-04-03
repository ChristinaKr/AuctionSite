<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 14/02/2018
 * Time: 14:35
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

include_once '../models/User.php';

//

$database = new Database();
$db = $database->getConnection();

$user = new User($db);




// set user property values
$user->FirstName = trim($_POST["FirstName"]);
$user->LastName = trim($_POST["LastName"]);
$user->Email = strtolower(trim($_POST["Email"]));

// validate password
if (!trim($_POST["Password"]) || strlen(trim($_POST["Password"])) == 0) {
    die('{"message":"invalid password"}');
}
$user->hashPassword(trim($_POST["Password"]));

// validate email
if (!filter_var($user->Email, FILTER_VALIDATE_EMAIL)) {
    die('{"message":"Invalid email"}');
}

//validate first name
if (!(strlen($user->FirstName) > 0)) {
    die('{"message":"Invalid first name"}');
}

// validate last name
if (!(strlen($user->LastName) > 0)) {
    die('{"message":"Invalid last name"}');
}

// create the user
if($user->create()){
    // TODO: Logout first
    $user->login();
    session_start();

    $_SESSION["ID"] = $user->ID;
    echo '{';
    echo '"message": "User was created.",';
    echo '"ID": "' . $user->ID .'",';
    echo '"valid": true';
    echo '}';
}
// if unable to create the user, tell the user
else{
    echo '{';
    echo '"message": "Unable to create user."';
    echo '}';
}
