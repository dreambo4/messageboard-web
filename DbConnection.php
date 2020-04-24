<?php
class DbConnection{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "webtrain_messageboard";

    private $conn;

    // 建構子
    function __construct(){
        // Create connection
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if (mysqli_connect_errno($this->conn)) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // echo "Connected successfully";
    }
    
    public function execute($sql){
        $result = mysqli_query($this->conn, $sql);
        if($result){
            return $result;
        }else{
            print("execute fail: " . mysqli_connect_error($this->conn));
            return false;
        }
    }

    function __destruct(){
        $this->conn->close();
    }
}
?> 