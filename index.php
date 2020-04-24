<?php
include 'MessageBoardController.php';

$controller = new MessageBoardController();

if(isset($_POST['add'])){ //新增
    $user = $_POST['input-user'];
    $content = $_POST['input-content'];
    $controller -> add($user, $content);
}else if(isset($_POST['clean'])){ //清空
    $controller -> clean();
}else if(isset($_POST['get'])){ //編輯前，先取得內容
    $id = $_GET['id'];
    $editMsg = $controller -> get($id);
}else if(isset($_POST['edit'])){ //編輯
    $id = $_POST['id'];
    $user = $_POST['input-user'];
    $content = $_POST['input-content'];
    $controller -> edit($id, $user, $content);
}else if(isset($_POST['remove'])){ //刪除
    $id = $_GET['id'];
    $controller -> remove($id);
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
    <h1>留言板</h1> 
    <form action="index.php" method="post">
        <input type="submit" name="clean" value="清空"/>
    </form>
    <hr>
    <?php 
    foreach($messages as $row){?>
        <div name="msg">
            <div name="user"><h3><b><?=$row['user']?></b></h3></div>
            <div name="content"><?=$row['content']?></div>
            <div name="time"><?=$row['time']?></div>
            <form action="?id=<?=$row['id']?>" method="post">
                <input type="submit" name="get" value="編輯"/>
            </form>
            <form action="?id=<?=$row['id']?>" method="post">
                <input type="submit" name="remove" value="刪除"/>
            </form>
            <hr>
        </div>
        <!-- msg end -->
    <?php }?>

    <div>
        <form action="index.php" method="post">
            <label for="input-user">名稱:</label><br>
            <input name="input-user" value="<?= isset($_POST['get'])? $editMsg[0]['user'] : ''?>" /><br>
            <label for="input-content">留言:</label><br>
            <textarea name="input-content"><?= isset($_POST['get'])? $editMsg[0]['content'] : ''?></textarea><br>
            <input name="id" type="hidden" value="<?= isset($_POST['get'])? $editMsg[0]['id'] : ''?>"/><br>
            <input type="submit" name="<?= isset($_POST['get'])? 'edit' : 'add'?>" value="送出"/>
            <input type="submit" name="cancle" value="取消"/>
        </form>
    </div>
    
</body>
</html>

