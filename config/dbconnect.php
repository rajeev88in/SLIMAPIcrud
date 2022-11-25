<?php
class DB{
    // private server="localhost";
    // private $user="root";
    // private $pass="";
    // private $dbname="slimapitest";

    public function connect_db()
    {
        $server = 'localhost'; // this may be an ip address instead
        $user = 'root';
        $pass = '';
        $database = 'slimapitest';
        $conn = new mysqli($server, $user, $pass, $database);
        return $conn;
    }
}
?>