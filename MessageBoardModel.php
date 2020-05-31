<?php
include 'Env.php';

/**
 * 存取留言板資料的物件。
 * 
 * 提供顯示、取得、新增、修改、刪除、清空資料庫內容的函式。
 */
class MessageBoardModel{
    
    /** @var mysqli 連接資料庫的物件。 */
    private $conn;

    /**
     * 連接資料庫。
     * 
     * 若連接錯誤，顯示錯誤訊息並中斷程式。
     * 
     * @return void
     */
    function __construct()
    {
        $env = Env::$env;
        $this->conn = mysqli_connect($env['DB_HOST'], $env['DB_USER'], $env['DB_PWD'], $env['DB_DBNAME']);
        
        if (mysqli_connect_errno($this->conn)) {
            echo "連接資料庫錯誤: " . mysqli_connect_error();
            exit();
        }

        $this->conn->set_charset($env['DB_CHARSET']);
    }
    
    /**
     * 取得資料庫中所有留言。
     * 
     * @return string[][]|bool
     */
    public function show()
    {
        $sql = sprintf('SELECT `id`, `user`, `content`, `time` FROM `messages`;');
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_affected_rows($this->conn) >= 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return false;
        }
    }

    /**
     * 以留言編號取得留言的編號、姓名與內容。
     * 
     * @return string[][]|bool
     */
    public function get($id)
    {
        $sql = sprintf('SELECT `id`, `user`, `content` FROM `messages` where `id`=%d;', $id);
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_affected_rows($this->conn) == 1) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * 新增留言。
     * 
     * @param string    $user       留言者姓名。
     * @param string    $content    留言內容。
     * 
     * @return int|bool
     */
    public function add($user, $content)
    {
        $sql = sprintf('INSERT INTO `messages`(`user`, `content`) VALUES (\'%s\', \'%s\');', $user, $content);
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_affected_rows($this->conn) == 1) {
            return mysqli_affected_rows($this->conn);
        } else {
            return false;
        }
    }

    /**
     * 編輯留言。
     * 
     * @param int       $id         留言編號。
     * @param string    $user       留言者姓名。
     * @param string    $content    留言內容。
     * 
     * @return int|bool
     */
    public function edit($id, $user, $content)
    {
        $sql = sprintf('UPDATE `messages` SET `user`=\'%s\', `content`=\'%s\' WHERE `id`=%d;', $user, $content, $id);
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_affected_rows($this->conn) == 1) {
            return mysqli_affected_rows($this->conn);
        } else {
            return false;
        }
    }

    /**
     * 刪除留言。
     * 
     * @param int   $id 留言編號。
     * 
     * @return int|bool
     */
    public function remove($id)
    {
        $sql = sprintf('DELETE FROM `messages` WHERE `id`=%d;', $id);
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_affected_rows($this->conn) == 1) {
            return mysqli_affected_rows($this->conn);
        } else {
            return false;
        }
    }

    /**
     * 清空所有留言。
     * 
     * @return int|bool
     */
    public function clean()
    {
        $sql = sprintf('DELETE FROM `messages` WHERE true;');
        $result = mysqli_query($this->conn, $sql);
        
        if (mysqli_affected_rows($this->conn) >= 0) {
            return mysqli_affected_rows($this->conn);
        } else {
            return false;
        }
    }   

    /**
     * 中斷資料庫連線。
     * 
     * @return void
     */
    function __destruct()
    {
        $this->conn->close();
    }
}
