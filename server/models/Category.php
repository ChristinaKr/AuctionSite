<?php

/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 07/03/2018
 * Time: 12:40
 */
include_once '../utils/sql_functions.php';

class Category
{
    private $conn;

    public $ID;
    public $Name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_items()
    {
        return p_Category_sel_items($this->conn, $this->ID);
    }

    public function add_item($Item_ID)
    {
        return p_ItemCategory_ins($this->conn, $Item_ID, $this->ID);
    }

    public function remove_item($Item_ID)
    {
        return p_ItemCategory_del_id($this->conn, $Item_ID, $this->ID);
    }

    public function read()
    {
      return p_Category_sel_all($this->conn);
    }
}
