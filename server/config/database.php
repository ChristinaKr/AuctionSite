<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 04/02/2018
 * Time: 19:26
 * Tutorial: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
 */
class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "ebay";
    private $username = "root";
    private $password = "ilovegermanebay";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
