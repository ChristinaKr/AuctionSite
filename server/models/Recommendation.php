<?php

include_once '../utils/sql_functions.php';

class Recommendation
{
    private $conn;

    public $UserID;
    public $ItemID;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // get Recommendations
    function read()
    {

        return p_Recommendation_sel_all($this->conn);
    }

    function create()
    {

        $this->UserID = htmlspecialchars(strip_tags($this->UserID));
        $this->ItemID = htmlspecialchars(strip_tags($this->ItemID));

        if (p_Recommendation_ins($this->conn, $this->UserID, $this->ItemID)) {
            return true;
        };

        return false;

    }


    function readOne()
    {

        $stmt = p_Recommendation_sel_id($this->conn, $this->UserID, $this->ItemID);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->UserID = $row["UserID"];
        $this->ItemID = $row["ItemID"];
    }


    // delete the Recommendation
    function delete()
    {

        // execute query
        if (p_Recommendation_del_id($this->conn, $this->UserID, $this->ItemID)) {
            return true;
        }

        return false;

    }

}
