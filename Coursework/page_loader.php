<?php

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'ask':
        include 'template/questions/questions.html.php';
        break;
    case 'my_question':
        include 'template/my_question/my_question.html.php';
        break;
    case 'modules':
        include 'template/modules/modules.html.php';
        break;
    case 'community':
        include 'template/community/community.html.php';
        break;
    case 'create_module':
        include 'template/manage_module/manage_module.html.php';
        break;
    case 'manage_user':
        include 'template/manage_user/manage_user.php';
        break;
    case 'message':
        include 'template/messages/message.html.php';
        break;
    default:
        include 'template/home_content.html.php';
        break;
}
