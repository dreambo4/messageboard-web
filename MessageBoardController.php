<?php
include 'MessageBoardModel.php';

/**
 * 留言板的控制器。
 * 
 * 提供顯示、取得、新增、修改、刪除、清空的函式。
 */
class MessageBoardController
{
    /** @var \MessageBoardModel 這是存取資料庫的物件。 */
    private $model;

    /**
     * 實體化 MessageBoardModel 物件。
     * 
     * @return void
     */
    public function __construct()
    {
        $this->model = new MessageBoardModel();
    }
    
    /**
     * 取得所有留言。
     * 
     * @return string[][]
     */
    public function show()
    {
        $result = $this->model->show();

        return $result;
    }

    /**
     * 以留言編號取得留言的編號、姓名與內容。
     * 
     * 若無留言編號，回傳錯誤訊息；有留言編號，回傳留言的編號、姓名與內容。
     * 
     * @param int   $id 留言編號。
     * 
     * @return string|string[][]
     */
    public function get($id)
    {
        if (empty($id)) {
            return "請填寫完整!";
        } else {
            $result = $this->model->get($id);
            
            return $result;
        }
    }

    /**
     * 新增留言。
     * 
     * 若填寫不完整，回傳錯誤訊息；填寫完整且新增成功，回傳成功訊息；新增失敗，回傳錯誤訊息。
     * 
     * @param string    $user      留言者姓名。
     * @param string    $content   留言內容。
     * 
     * @return string
     */
    public function add($user, $content)
    {
        if (empty($user) || empty($content)) {
            return "請填寫完整!";
        } else {
            $result = $this->model->add($user, $content);
            if ($result) {
                return "新增 [ $result 筆 ] 成功!";
            } else {
                return "新增 失敗!";
            }
        }
    }

    /**
     * 編輯留言。
     * 
     * 若填寫不完整，回傳錯誤訊息；填寫完整且修改成功，回傳成功訊息；修改失敗，回傳錯誤訊息。
     * 
     * @param int       $id         留言編號。
     * @param string    $user       留言者姓名。
     * @param string    $content    留言內容。
     * 
     * @return string
     */
    public function edit($id, $user, $content)
    {
        if (empty($id) || empty($user) || empty($content)) {
            return "請填寫完整!";
        } else {
            $result = $this->model->edit($id, $user, $content);
            if ($result) {
                return "修改 [ $result 筆 ] 成功!";
            } else {
                return "修改 失敗!";
            }
        }
    }

    /**
     * 刪除留言。
     * 
     * 若填寫不完整，回傳錯誤訊息；填寫完整且刪除成功，回傳成功訊息；刪除失敗，回傳錯誤訊息。
     * 
     * @param int   $id 留言編號。
     * 
     * @return string
     */
    public function remove($id)
    {
        if (empty($id)) {
            return "請填寫完整!";
        } else {
            $result = $this->model->remove($id);
            if ($result) {
                return "刪除 [ $result 筆 ] 成功!";
            } else {
                return "刪除 失敗!";
            }
        }
    }

    /**
     * 清空所有留言。
     * 
     * 清空失敗，回傳錯誤訊息；清空成功，回傳成功訊息。
     * 
     * @return string
     */
    public function clean()
    {
        $result = $this->model->clean();
        if ($result >= 0) {
            return "清空 [ $result 筆 ] 成功!";
        } else {
            return "清空 失敗!";
        }
    }
}
