<?php
include 'MessageBoardController.php';

$controller = new MessageBoardController();

if (isset($_POST['add'])) { //新增
    $user = $_POST['input-user'];
    $content = $_POST['input-content'];
    $result = $controller -> add($user, $content);
} elseif (isset($_POST['clean'])) { //清空
    $result = $controller -> clean();
} elseif (isset($_POST['edit'])) { //編輯
    $id = $_POST['id'];
    $user = $_POST['input-user'];
    $content = $_POST['input-content'];
    $result = $controller -> edit($id, $user, $content);
} elseif (isset($_GET['q'])) {
    $q = $_GET['q'];
    $q = str_replace('?', '', base64_decode($q));
    $q = explode('&', $q);
    $type = str_replace('"', '', explode('=', $q[0]));
    $id = explode('=', $q[1]);

    if ($type[1] == 'get') { //編輯前，先取得內容
        $result = $controller -> get($id[1]);
    } elseif ($type[1] == 'remove') { //刪除
        $result = $controller -> remove($id[1]);
    }
}

$messages = $controller->show();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
</head>
<body>
    <div><?= isset($result) && !is_array($result) ? $result : '' ?></div>
    <h1>留言板</h1> 
    <form action="index.php" method="post">
        <input type="submit" name="clean" value="清空"/>
    </form>
    <hr>
    <?php
    if(is_array($messages)){
        foreach($messages as $row){?>
            <div name="msg">
                <div name="user"><h3><b><?=$row['user']?></b></h3></div>
                <div name="content"><?=$row['content']?></div>
                <div name="time"><?=$row['time']?></div>
                <a href="?q=<?=base64_encode('?type="get"&id='.$row['id'])?>"><button type="submit" name="get">編輯</button></a>
                <a href="?q=<?=base64_encode('?type="remove"&id='.$row['id'])?>"><button type="submit" name="remove">刪除</button></a>
                <hr>
            </div>
            <!-- msg end -->
    <?php 
        }
    }else{
    ?>
        <div>[目前沒有留言]</div>
        <hr>
    <?php
    }
    ?>

    <div>
        <form action="index.php" method="post">
            <label for="input-user">姓名:</label>
            <input name="input-user" value="<?= (isset($type)) && ($type[1] == 'get') ? $result[0]['user'] : ''?>" />
            <label for="input-content">留言:</label>
            <textarea name="input-content"><?= (isset($type)) && ($type[1] == 'get') ? $result[0]['content'] : ''?></textarea>
            <input name="id" type="hidden" value="<?= (isset($type)) && ($type[1] == 'get') ? $result[0]['id'] : ''?>"/>
            <input type="submit" name="<?= (isset($type)) && ($type[1] == 'get') ? 'edit' : 'add'?>" value="送出"/>
            <input type="submit" name="cancle" value="取消"/>
        </form>
    </div>
    
</body>
</html>
