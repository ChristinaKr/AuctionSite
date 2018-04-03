<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 07/03/2018
 * Time: 18:24
 */

if( session_status() == PHP_SESSION_NONE ){
    session_start();
}

if( isset( $_SESSION['ID'] ) && $_SESSION['ID'] != ""){
    /* User is logged in */
} else {
    die('{"message":"Access denied, user not logged in"}');
}

function check_UserID($ID){
    if ($ID != $_SESSION['ID']) {
        die('{"message":"Access denied, please use the correct UserID"}');
    }
}

function get_UserID() {
    return $_SESSION['ID'];
}
