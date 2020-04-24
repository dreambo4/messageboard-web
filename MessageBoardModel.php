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
    public function get($id){
        $sql = sprintf('SELECT * FROM `messages` where `id`="%s";', $id);
        return $this->conn->execute($sql)->fetch_all(MYSQLI_ASSOC);
    }
    public function add($user, $content){
        $sql = sprintf('INSERT INTO `messages`(`user`, `content`) VALUES ("%s", "%s");', $user, $content);
        return $this->conn->execute($sql);
    }
    public function edit($id, $user, $content){
        $sql = sprintf('UPDATE `messages` SET `user`="%s", `content`="%s" WHERE `id`=%d;', $user, $content, $id);
        return $this->conn->execute($sql);
    }
    public function remove($id){
        $sql = sprintf('DELETE FROM `messages` WHERE `id`=%d;', $id);
        return $this->conn->execute($sql);
    }
    public function clean(){
        $sql = sprintf('TRUNCATE TABLE `messages`;');
        return $this->conn->execute($sql);
    }
}