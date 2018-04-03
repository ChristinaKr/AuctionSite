<?php
// Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html

include_once '../utils/sql_functions.php';

class Watch
{
    // database connection and table name
    private $conn;

    // object properties
    public $UserID;
    public $ItemID;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // // read watch-item
    // function read()
    // {
    //
    //   return p_Watch_sel_all($this->conn);
    // }

    function readOne()
    {
        // reads one watch-item
        $stmt = p_Watch_sel_id($this->conn, $this->UserID, $this->ItemID);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->UserID = $row["UserID"];
        $this->ItemID = $row["ItemID"];
    }

    static function readOneUser($db, $UserID)
    {
        $stmt = p_Watch_sel_all_userid($db, $UserID);

        return $stmt;
    }


    function create()
    {

        // sanitize
        $this->UserID = htmlspecialchars(strip_tags($this->UserID));
        $this->ItemID = htmlspecialchars(strip_tags($this->ItemID));

        // execute query
        if (p_Watch_ins($this->conn, $this->UserID, $this->ItemID)) {
            return true;
        }

        return false;
    }

    // delete the watch-item
    function delete()
    {

        // execute query
        if (p_Watch_del_id($this->conn, $this->UserID, $this->ItemID)) {
            return true;
        }

        return false;

    }


    static function readItem($db, $ItemID)
    {
        // reads all users that watch an item
        $stmt = p_Watch_sel_all_from_item($db, $ItemID);

        return $stmt;

    }

}
