<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $Config['title']; ?></title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="stylesheet" href="templates/default/css/style.css">
    <script src="templates/default/js/jquery-2.1.3.min.js"></script>
    <script src="templates/default/js/enter.js"></script>
    
    <link rel="icon" href="templates/<?php echo $Config['template']; ?>/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="templates/<?php echo $Config['template']; ?>/img/favicon.ico" type="image/x-icon">
</head>

<body class="index">
    <div id="proccess" class="loading hide"></div>
    <div class="chat-window">
        <div class="top-bar">
            <img src="templates/default/img/users.png"> <span><?=$Main->l('online');?></span>
        </div>
        <div class="container">
            <div class="container-body">
                <h3 class="page-header"><?=$Main->l('wellcome');?></h3>
                <p id="description"><?=$Main->l('description');?></p>
                
                <div id="login"><a class="btn" href="javascript:search_user();"><?=$Main->l('search');?></a></div>
            </div>
        </div>
    </div>
</body>
</html>
