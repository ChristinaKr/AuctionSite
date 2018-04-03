<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 13/03/2018
 * Time: 10:51
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';

include_once '../models/User.php';

// check that the user is logged in and set session id
include_once '../utils/auth.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->ID = get_UserID();

if ($user->isAdmin()) {
    echo '{"message": "welcome to the admin panel", "admin":true}';
} else {
    echo '{"message": "Access denied, you are not an admin", "admin":false}';
}