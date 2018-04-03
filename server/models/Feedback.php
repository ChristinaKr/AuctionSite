<?php
// Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html

include_once '../utils/sql_functions.php';


class Feedback
{
    // database connection and table name
    private $conn;

    // object properties
    public $ID;
    public $ToUserID;
    public $FromUserID;
    public $ItemID;
    public $Comment;
    public $Rating;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read feedback
    function read()
    {

        return p_Feedback_sel_all($this->conn);
    }

    function create()
    {

        // sanitize
        $this->ToUserID = htmlspecialchars(strip_tags($this->ToUserID));
        $this->FromUserID = htmlspecialchars(strip_tags($this->FromUserID));
        $this->ItemID = htmlspecialchars(strip_tags($this->ItemID));
        $this->Comment = htmlspecialchars(strip_tags($this->Comment));
        $this->Rating = htmlspecialchars(strip_tags($this->Rating));

        // execute query
        if (p_Feedback_ins($this->conn, $this->ToUserID, $this->FromUserID, $this->ItemID, $this->Comment, $this->Rating)) {
            return true;
        };

        return false;
    }

    // used when filling up the update feedback form
    function readOne()
    {
        $stmt = p_Feedback_sel($this->conn, $this->FromUserID, $this->ItemID);

        // get retrieved row
        if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->ToUserID = $row['ToUserID'];
        $this->FromUserID = $row['FromUserID'];
        $this->ItemID = $row['ItemID'];
        $this->Comment = $row['Comment'];
        $this->Rating = $row['Rating'];
            } else {
            $this->ToUserID = null;
            $this->FromUserID = null;
        }
    }

        // delete the Feedback
    function delete(){

        // execute query
        if (p_Feedback_del_id($this->conn, $this->ID)) {
            return true;
        }
        return false;
    }

    function read_user(){
        // Feedback for a user by their id
        $stmt = p_Feedback_sel_user($this->conn, $this->UserID);

        // get retrieved rows
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;

    }

}
