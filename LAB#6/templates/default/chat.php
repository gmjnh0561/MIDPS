<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $Config['title']; ?></title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="stylesheet" href="templates/default/css/style.css">
    <script src="templates/default/js/jquery-2.1.3.min.js"></script>
    <script src="templates/default/js/jquery.titlealert.min.js"></script>
    <script src="templates/default/js/chat.js"></script>
    
    <link rel="icon" href="templates/<?php echo $Config['template']; ?>/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="templates/<?php echo $Config['template']; ?>/img/favicon.ico" type="image/x-icon">
</head>

<body class="chat">
    <a class="change" href="javascript:quit();"><?=$Room->l('change');?></a>
    <div class="chat-window">
        <div class="top-bar">
            <img src="templates/default/img/users.png"> <span><?=$Room->l('online');?></span>
        </div>
        <div id="box" class="message-board">
            <div id="html"></div>
        </div>
        
        <div class="chat-bar">
            <div class="smiles">
                <?php echo $Room->get_list_of_smiles(); ?>
            </div>
            <form id="message">
                <div><textarea id="text"></textarea></div>
                <input onclick="javascript:send_text('');" type="button" value="<?=$Room->l('send');?>">
            </form>
        </div>
        
    </div>
</body>
</html>