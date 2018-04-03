<?php

/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 04/02/2018
 * Time: 19:29
 */

include_once '../utils/sql_functions.php';

class Item
{
    // database connection and table name
    private $conn;

    // object properties
    public $ID;
    public $Name;
    public $Description;
    public $AuctionStart;
    public $AuctionEnd;
    public $AuctionFinished;
    public $StartingPrice;
    public $ReservePrice;
    public $FinalPrice;
    public $PhotoURL;
    public $SellerID;
    public $BuyerID;
    public $Views;
    public $CreatedAt;
    public $SellerName; // generated through join
    public $SellerRating; // generated through join
    public $CategoryID = null; // generated through join
    public $LargestBid; // generated through join

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read products
    function read()
    {

        return p_Item_sel_all($this->conn);
    }

    // search products
    function search($search, $CategoryID)
    {

        return p_Item_search($this->conn, $search, $CategoryID);
    }

    function create()
    {

        // check reserver price is positive


        // sanitize
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->AuctionStart = htmlspecialchars(strip_tags($this->AuctionStart));
        $this->AuctionEnd = htmlspecialchars(strip_tags($this->AuctionEnd));
        $this->StartingPrice = htmlspecialchars(strip_tags($this->StartingPrice));
        $this->ReservePrice = htmlspecialchars(strip_tags($this->ReservePrice));
        $this->SellerID = htmlspecialchars(strip_tags($this->SellerID));
        $this->CategoryID = htmlspecialchars(strip_tags($this->CategoryID));

        echo $this->Name, $this->Description, $this->AuctionStart, $this->AuctionEnd, $this->StartingPrice, $this->ReservePrice, $this->PhotoURL, $this->SellerID, $this->CategoryID;

        return p_Item_ins($this->conn, $this->Name, $this->Description, $this->AuctionStart, $this->AuctionEnd, $this->StartingPrice, $this->ReservePrice, $this->PhotoURL, $this->SellerID, $this->CategoryID);

    }

    // used when filling up the update product form
    function readOne()
    {

        $stmt = p_Item_sel_id($this->conn, $this->ID);

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->ID = $row['ID'];
        $this->Name = $row['Name'];
        $this->Description = $row['Description'];
        $this->AuctionStart = $row['AuctionStart'];
        $this->AuctionEnd = $row['AuctionEnd'];
        $this->AuctionFinished = $row['AuctionFinished'];
        $this->StartingPrice = $row['StartingPrice'];
        $this->ReservePrice = $row['ReservePrice'];
        $this->FinalPrice = $row['FinalPrice'];
        $this->PhotoURL = $row['PhotoURL'];
        $this->SellerID = $row['SellerID'];
        $this->BuyerID = $row['BuyerID'];
        $this->Views = $row['Views'];
        $this->CreatedAt = $row['CreatedAt'];
        $this->SellerName = $row['SellerName'];
        $this->SellerRating = $row['SellerRating'];
        $this->CategoryID = $row['CategoryID'];
        $this->LargestBid = $row['LargestBid'];
    }

    function increment_views()
    {
        return p_Item_incr_views($this->conn, $this->ID);
    }

    function update()
    {

        // execute the query
        if (p_Item_upd($this->conn, $this->ID, $this->Name, $this->Description, $this->AuctionStart, $this->AuctionEnd, $this->AuctionFinished, $this->StartingPrice, $this->ReservePrice, $this->FinalPrice, $this->PhotoURL, $this->SellerID)) {
            return true;
        }

        return false;
    }

    // delete the Item
    function delete()
    {

        // execute query
        if (p_Item_del_id($this->conn, $this->ID)) {
            return true;
        }

        return false;

    }

//    function largest_bid() {
    // TODO
//        return p_Bid_sel_largest($this->conn, $this->ID);
//    }
}
