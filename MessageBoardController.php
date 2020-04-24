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
    public function get($id){
        $result = $this->model->get($id);
        return $result;
    }
    public function add($user, $content){
        $result = $this->model->add($user, $content);
        if ($result){
            print("新增 成功!");
        }else{
            print("新增 失敗!");
        }
    }
    public function edit($id, $user, $content){
        $result = $this->model->edit($id, $user, $content);
        if ($result){
            print("修改 成功!");
        }else{
            print("修改 失敗!");
        }
    }
    public function remove($id){
        $result = $this->model->remove($id);
        if ($result){
            print("刪除 成功!");
        }else{
            print("刪除 失敗!");
        }
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