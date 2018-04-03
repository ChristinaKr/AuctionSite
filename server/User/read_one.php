<?php

/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 14/02/2018
 * Time: 14:48
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../models/User.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare User object
$user = new User($db);

// set ID property of User to be edited
$user->ID = isset($_GET['ID']) ? $_GET['ID'] : die('{"message": "Please enter a User ID."}');

// read the details of User to be edited
$user->readOne();

if ($user->ID) {
    // create array
    $user_arr = array(
        "ID" => $user->ID,
        "Email" => $user->Email,
        "FirstName" => $user->FirstName,
        "LastName" => $user->LastName
    );

    echo(json_encode($user_arr));
} else {
    echo '"Unable to find user"';
}
