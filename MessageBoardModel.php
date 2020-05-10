<?php
include 'Env.php';
class MessageBoardModel{
    
    private $conn;

    function __construct(){
        $env = Env::$env;
        $this->conn = mysqli_connect($env['DB_HOST'], $env['DB_USER'], $env['DB_PWD'], $env['DB_DBNAME']);
        
        if (mysqli_connect_errno($this->conn)) {
            echo "連接資料庫錯誤: " . mysqli_connect_error();
            exit();
        }

        $this->conn -> set_charset($env['DB_CHARSET']);
    }
    public function show(){
        $sql = sprintf('SELECT `id`, `user`, `content`, `time` FROM `messages`;');
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_affected_rows($this->conn) >= 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return false;
        }
    }
    public function get($id){
        $sql = sprintf('SELECT `id`, `user`, `content` FROM `messages` where `id`="%s";', $id);
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_affected_rows($this->conn) == 1){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return false;
        }
    }
    public function add($user, $content){
        $sql = sprintf('INSERT INTO `messages`(`user`, `content`) VALUES ("%s", "%s");', $user, $content);
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_affected_rows($this->conn) == 1){
            return mysqli_affected_rows($this->conn);
        }else{
            return false;
        }
    }
    public function edit($id, $user, $content){
        $sql = sprintf('UPDATE `messages` SET `user`="%s", `content`="%s" WHERE `id`=%d;', $user, $content, $id);
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_affected_rows($this->conn) == 1){
            return mysqli_affected_rows($this->conn);
        }else{
            return false;
        }
    }
    public function remove($id){
        $sql = sprintf('DELETE FROM `messages` WHERE `id`=%d;', $id);
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_affected_rows($this->conn) == 1){
            return mysqli_affected_rows($this->conn);
        }else{
            return false;
        }
    }
    public function clean(){
        $sql = sprintf('DELETE FROM `messages` WHERE true;');
        $result = mysqli_query($this->conn, $sql);
        
        if(mysqli_affected_rows($this->conn) >= 0){
            return mysqli_affected_rows($this->conn);
        }else{
            return false;
        }
    }   

    function __destruct(){
        $this->conn->close();
    }
}
