<?php

/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 04/02/2018
 * Time: 19:29
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */

include_once '../utils/sql_functions.php';
include_once '../utils/email/email.php';

class User
{
    private $conn;

    public $ID;
    public $Email;
    public $FirstName;
    public $LastName;
    public $PasswordHash;
    public $IsAdmin; // generated on the fly

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // get users
    function read()
    {

        return p_User_sel_all($this->conn);
    }

    function create()
    {
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
        $this->LastName = htmlspecialchars(strip_tags($this->LastName));

        if (p_User_ins($this->conn, $this->FirstName, $this->LastName, $this->Email, $this->PasswordHash)) {
            return true;
        };

        return false;

    }


    function readOne()
    {

        $stmt = p_User_sel_id($this->conn, $this->ID);


        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Email = $row['Email'];
        $this->FirstName = $row['FirstName'];
        $this->LastName = $row['LastName'];
    }

    function hashPassword($password)
    {
        $this->PasswordHash = md5($password);
    }

    // login the users
    function login()
    {

        $stmt = p_User_login($this->conn, $this->Email, $this->PasswordHash);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Email = $row['Email'];
        $this->ID = $row['ID'];
        $this->FirstName = $row['FirstName'];
        $this->LastName = $row['LastName'];
        return isset($this->ID);
    }

    // update the User
    function update()
    {


        // execute the query
        if (p_User_upd($this->conn, $this->ID, $this->FirstName, $this->LastName, $this->Email)) {
            return true;
        }

        return false;
    }

    // delete the User
    function delete()
    {

        // execute query
        if (p_User_del_id($this->conn, $this->ID)) {
            return true;
        }

        return false;

    }

    static function getUserID()
    {
        if (!isset($_SESSION)) {
            session_start();
            return false;
        }

        if (isset($_SESSION['ID']) && $_SESSION['ID'] != "") {
            /* User is logged in */
            return $_SESSION['ID'];
        } else {
            return false;
        }
    }

    function getSellingItems()
    {
        return p_Item_seller_id($this->conn, $this->ID);
    }

    function isAdmin()
    {
        $stmt = p_Admin_sel_user_id($this->conn, $this->ID);

        return $stmt->rowCount() > 0;
    }

    function sendEmail($subject, $text)
    {
        send_email($this->Email, $subject, $text);
    }

    function items_bidded_on()
    {
        return p_Items_bidded_on($this->conn, $this->ID);
    }

}
