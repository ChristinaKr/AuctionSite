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

// logout the user
session_start();
$_SESSION = array();
session_destroy();

echo '{';
echo '"message": "User logged out."';
echo '}';
