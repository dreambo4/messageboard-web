<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
</head>
<body>
    <div><?= $alertMsg ?></div>
    <h1>留言板</h1>
    <button type="submit" form="inputForm" formmethod="post" formaction="<?= base_url('index.php/MessageBoardController/clean') ?>">清空</button>
    <hr>
    <?php
    if (count($messages)) {
        foreach ($messages as $row) {?>
            <div name="msg">
                <div name="user"><h3><b><?= $row['user'] ?></b></h3></div>
                <div name="content"><?= $row['content'] ?></div>
                <div name="time"><?= $row['time'] ?></div>
                <a href="<?= base_url('index.php/MessageBoardController/get/?q=') . base64_encode($row['id']) ?>"><button type="submit" name="get">編輯</button></a>
                <a href="<?= base_url('index.php/MessageBoardController/remove/?q=') . base64_encode($row['id']) ?>"><button type="submit" name="remove">刪除</button></a>
                <hr>
            </div>
            <!-- msg end -->
    <?php
        }
    } else {
    ?>
        <div>[目前沒有留言]</div>
        <hr>
    <?php
    }
    ?>

    <div>
        <form action="#" method="post" id="inputForm">
            <label for="input-user">姓名:</label>
            <input name="input-user" value="<?= $formContent['user'] ?>" />
            <label for="input-content">留言:</label>
            <textarea name="input-content"><?= $formContent['content'] ?></textarea>
            <input name="id" type="hidden" value="<?= $formContent['id'] ?>"/>
        </form>
        <button type="submit" form="inputForm" formmethod="post" formaction="<?= base_url('index.php/MessageBoardController/' . $formContent['action']) ?>">送出</button>
        <button type="submit" form="inputForm" formmethod="post" formaction="<?= base_url('index.php/MessageBoardController/index') ?>">取消</button>
    </div>
</body>
</html>
