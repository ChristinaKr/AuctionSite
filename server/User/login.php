<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 07/03/2018
 * Time: 17:59
 * Tutorial: https://phppot.com/php/php-login-script-with-session/
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);


// set user property values
$user->Email = strtolower(trim($_POST["Email"]));

if (!isset($_POST["Email"])) {
    die('{"message":"email required"}');
}

if (!$_POST["Password"]) {
    die('{"message":"invalid password"}');
}
$user->hashPassword(trim($_POST["Password"]));

// create the user
if ($user->login()) {
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    session_start();
    $_SESSION["ID"] = $user->ID;
//    setcookie('userID', $user->ID);
    echo '{';
    echo '"message": "User logged in.",';
    echo '"ID": "' . $user->ID . '",';
    if ($user->isAdmin()) {
        echo '"admin":true}';
    } else {
            echo '"admin":false}';
    }
} // if unable to create the user, tell the user
else {
    echo '{';
    echo '"message": "Unable to login user."';
    echo '}';
}
