<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 存取留言板資料的物件
 */
class MessageBoardModel extends CI_Model {

    /** @var \mysqli 連接資料庫的物件 */
    private $conn;

    /**
     * 連接資料庫
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 取得資料庫中所有留言
     *
     * @return array|bool
     */
    public function show()
    {
        $this->db->select('id, user, content, time');
        $result = $this->db->get('messages');

        return $result->result_array();
    }

    /**
     * 以留言編號取得留言的編號、姓名與內容
     *
     * @return array|bool
     */
    public function get($id)
    {
        $this->db->select('id, user, content');
        $this->db->where('id', $id);
        $result = $this->db->get('messages');

        return $result->result_array();
    }

    /**
     * 新增留言
     *
     * @param string $user 留言者姓名
     * @param string $content 留言內容
     *
     * @return int|bool
     */
    public function add($user, $content)
    {
        $this->db->set('user', $user);
        $this->db->set('content', $content);
        $result = $this->db->insert('messages');

        return $this->db->affected_rows();
    }

    /**
     * 編輯留言
     *
     * @param int $id 留言編號
     * @param string $user 留言者姓名
     * @param string $content 留言內容
     *
     * @return int|bool
     */
    public function edit($id, $user, $content)
    {
        $this->db->set('user', $user);
        $this->db->set('content', $content);
        $this->db->where('id', $id);
        $result = $this->db->update('messages');

        return $this->db->affected_rows();
    }

    /**
     * 刪除留言
     *
     * @param int $id 留言編號
     *
     * @return int|bool
     */
    public function remove($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('messages');

        return $this->db->affected_rows();
    }

    /**
     * 清空所有留言
     *
     * @return int|bool
     */
    public function clean()
    {
        $result = $this->db->empty_table('messages');

        return $this->db->affected_rows();
    }
}
