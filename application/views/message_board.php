<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://yckart.github.io/jquery.base64.js/jquery.base64.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/messageBoard.js') ?>" charset="utf-8"></script>
    <title>留言板</title>
</head>
<body>
    <div id="alert_message"></div>
    <h1>留言板</h1>
    <button type="submit" id="clean">清空</button>
    <hr>
    <div id="messages">
    </div>
    <!-- messages end -->

    <div>
        <form action="#" method="post" id="inputForm">
            <label for="input-user">姓名:</label>
            <input id="input-user" value=""/>
            <label for="input-content">留言:</label>
            <textarea id="input-content"></textarea>
            <input id="id" type="hidden" value=""/>
        </form>
        <button id="submit_button" name="">送出</button>
        <button id="cancle" type="submit" onclick="initInput()">取消</button>
    </div>
</body>
</html>
