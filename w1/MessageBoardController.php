<?php
include 'MessageBoardModel.php';
class MessageBoardController{
    private $model;
    function __construct(){
        $this->model = new MessageBoardModel();
    }
    public function show(){
        $result = $this->model->show();
        return $result;
        // var_dump($result);
    }
    public function add($user, $content){
        $result = $this->model->add($user, $content);
        if ($result){
            print("新增 成功!");
        }else{
            print("新增 失敗!");
        }
    }
    public function edit($id){

    }
    public function remove($id){

    }
    public function clean(){
        $result = $this->model->clean();
        if ($result){
            print("清空 成功!");
        }else{
            print("清空 失敗!");
        }
    }
}