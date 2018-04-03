<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 10/03/2018
 * Time: 15:46
 */
include_once '../models/User.php';

//if (User::getUserId()) {
//    echo ('{"message":"Logged in", "ID":"'. User::getUserId() .'"}');
//} else {
//    echo ('{"message":"Not logged in"}');
//}

if( !isset( $_SESSION ) ){
    session_start();
}

if( isset( $_SESSION['ID'] ) && $_SESSION['ID'] != ""){
    /* User is logged in */
    echo $_SESSION['ID'];
} else {
    die('{"message":"Not logged in"}');
}