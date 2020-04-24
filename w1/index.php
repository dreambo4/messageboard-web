<?php
include 'MessageBoardController.php';

$controller = new MessageBoardController();

if(isset($_POST['add'])){
    $user = $_POST['input-user'];
    $content = $_POST['input-content'];
    $controller -> add($user, $content);
}else if(isset($_POST['clean'])){
    $controller -> clean();
}
$_POST = [];

$messages = $controller->show();
var_dump($messages);
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

    <?php 
    foreach($messages as $row){?>
        <div name="msg">
            <div name="user"><h3><b><?=$row['user']?></b></h3></div>
            <div name="content"><?=$row['content']?></div>
            <div name="time"><?=$row['time']?></div>
            <form action="index.php/?id<?=$row['id']?>" method="get">
                <input type="submit" name="edit" value="編輯"/>
            </form>
            <form action="index.php/?id<?=$row['id']?>" method="get">
                <input type="submit" name="remove" value="刪除"/>
            </form>
            <hr>
        </div>
        <!-- msg end -->
    <?php }?>

    <div>
        <form action="index.php" method="post">
            <label for="input-user">名稱:</label><br>
            <input name="input-user" /><br>
            <label for="input-content">留言:</label><br>
            <textarea name="input-content"></textarea><br>
            <input type="submit" name="add" value="送出"/>
        </form>
    </div>
    
</body>
</html>
