<?php
// Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html

include_once '../utils/sql_functions.php';

class Bid
{
    // database connection and table name
    private $conn;

    // object properties
    public $ID;
    public $ItemID;
    public $BidAmount;
    public $UserID;
    public $CreatedAt;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read bids
    function read()
    {

        return p_Bid_sel_all($this->conn);
    }

    function create()
    {
        // Check that the bid is positive

        // sanitize
        $this->ItemID = htmlspecialchars(strip_tags($this->ItemID));
        $this->BidAmount = htmlspecialchars(strip_tags($this->BidAmount));
        $this->UserID = htmlspecialchars(strip_tags($this->UserID));
//        $this->created=htmlspecialchars(strip_tags($this->created));

        // execute query
        if (p_Bid_ins($this->conn, $this->ItemID, $this->UserID, $this->BidAmount)) {
            return true;
        };

        return false;

    }

    // used when filling up the update bid form
    function readOne()
    {
        // prepare query statement
        $stmt = p_Bid_sel_id($this->conn, $this->ID);

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->ItemID = $row['ItemID'];
        $this->BidAmount = $row['BidAmount'];
        $this->UserID = $row['UserID'];
        $this->CreatedAt = $row['CreatedAt'];
    }

    // delete the Bid
    function delete()
    {

        // execute query
        if (p_Bid_del_id($this->conn, $this->ID)) {
            return true;
        } else {
            return false;
        }

    }


    static function read_user($db, $UserID)
    {
        // Get the bids for a user
        // prepare query statement
        $stmt = p_Bid_sel_user($db, $UserID);

        return $stmt;
    }

    static function read_items($db, $ItemID)
    {
        // Get the bids for an item
        $stmt = p_Bid_sel_item($db, $ItemID);

        return $stmt;
    }

    static function largest_bid($db, $ItemID)
    {
        $stmt = p_Bid_sel_largest($db, $ItemID);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $BidAmount = $row['BidAmount'];

            return $BidAmount;
        } else {
            return 0;
        }


    }

}
