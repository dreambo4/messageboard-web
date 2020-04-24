<?php
include 'DbConnection.php';
class MessageBoardModel{
    private $conn;
    function __construct(){
        $this->conn = new DbConnection();
    }
    public function show(){
        $sql = sprintf('SELECT * FROM `messages`;');
        return $this->conn->execute($sql)->fetch_all(MYSQLI_ASSOC);
    }
    public function add($user, $content){
        $sql = sprintf('INSERT INTO `messages`(`user`, `content`) VALUES ("%s", "%s");', $user, $content);
        return $this->conn->execute($sql);
    }
    public function edit($id){

    }
    public function remove($id){

    }
    public function clean(){
        $sql = sprintf('TRUNCATE TABLE `messages`;');
        return $this->conn->execute($sql);
    }
}