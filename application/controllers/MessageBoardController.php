<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 留言板的控制器
 *
 * 提供顯示、取得、新增、修改、刪除、清空的函式
 */
class MessageBoardController extends CI_Controller
{

    /**
     * 載入 MessageBoardModel
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MessageBoardModel');
    }

    /**
     * 顯示畫面
     *
     * @return void
     */
    public function index()
	{
		$this->load->view('message_board.php');
    }

    /**
     * 列出所有留言
     *
     * @return void
     */
    public function list () {
        $alertMsg = "";
        $messages = $this->show();
        $success = count($messages) > 0 ? 1 : -1;
        $formContent = [
            'user' => '',
            'content' => '',
            'id' => '',
            'action' => 'add',
        ];
        $data = [
            'alertMsg' => $alertMsg,
            'messages' => $messages,
            'formContent' => $formContent,
            'success' => $success,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * 取得所有留言
     *
     * @return array
     */
    private function show()
    {
        $result = $this->MessageBoardModel->show();

        return $result;
    }

    /**
     * 以留言編號取得留言的編號、姓名與內容
     *
     * @return void
     */
    public function get()
    {
        $id = base64_decode($this->input->get('q'));
        if (empty($id)) {
            $alertMsg = "請填寫完整!";
            $success = -2;
        } else {
            $alertMsg = "修改完，記得送出！";
            $success = 1;
            $result = $this->MessageBoardModel->get($id);
            if (count($result)) {
                $formContent = [
                    'user' => $result[0]['user'],
                    'content' => $result[0]['content'],
                    'id' => $result[0]['id'],
                    'action' => 'edit',
                ];
            } else {
                $alertMsg = "留言不存在！";
                $success = -1;
            }
        }

        $data = [
            'success' => $success,
            'alertMsg' => $alertMsg,
            'formContent' => isset($formContent) ? $formContent : [],
        ];
		$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * 新增留言
     *
     * @return void
     */
    public function add()
    {
        $user = $this->input->post('input-user');
        $content = $this->input->post('input-content');
        if (empty($user) || empty($content)) {
            $alertMsg = "請填寫完整! $user $content";
            $success = -2;
        } else {
            $messageId = $this->MessageBoardModel->add($user, $content);
            if ($messageId > 0) {
                $alertMsg = "新增 [ 1 筆 ] 成功!";
                $success = 1;
                $result = $this->MessageBoardModel->get($messageId);
            } else {
                $alertMsg = "新增 失敗!";
                $success = -1;
            }
        }
        $data = [
            'alertMsg' => $alertMsg,
            'message_by_id' => (isset($result) ? $result : []),
            'success' => $success,
        ];
		$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * 編輯留言
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->input->post('id');
        $user = $this->input->post('input-user');
        $content = $this->input->post('input-content');
        if (empty($id) || empty($user) || empty($content)) {
            $alertMsg = "請填寫完整!";
            $success = -2;
        } else {
            $result = $this->MessageBoardModel->edit($id, $user, $content);
            if ($result > 0) {
                $alertMsg = "修改 [ $result 筆 ] 成功!";
                $success = 1;
                $editedMsg = $this->MessageBoardModel->get($id);
            } else {
                $alertMsg = "修改 失敗!";
                $success = -1;
            }
        }
        $data = [
            'success' => $success,
            'message_by_id' => (isset($editedMsg) ? $editedMsg : []),
            'alertMsg' => $alertMsg,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * 刪除留言
     *
     * @return void
     */
    public function remove()
    {
        $id = base64_decode($this->input->get('q'));
        if (empty($id)) {
            $alertMsg = "請填寫完整!";
            $success = -2;
        } else {
            $result = $this->MessageBoardModel->remove($id);
            if ($result > 0) {
                $alertMsg = "刪除 [ $result 筆 ] 成功!";
                $success = 1;
            } else {
                $alertMsg = "刪除 失敗!";
                $success = -1;
            }
        }

        $data = [
            'success' => $success,
            'alertMsg' => $alertMsg,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * 清空所有留言
     *
     * @return void
     */
    public function clean()
    {
        $result = $this->MessageBoardModel->clean();
        if ($result >= 0) {
            $alertMsg = "清空 [ $result 筆 ] 成功!";
            $success = 1;
        } else {
            $alertMsg = "清空 失敗!";
            $success = -1;
        }
        $data = [
            'alertMsg' => $alertMsg,
            'success' => $success,
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
