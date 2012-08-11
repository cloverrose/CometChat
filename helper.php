<?php
require_once('Smarty.class.php');
require_once('Chat.php');
require_once('User.php');

function create_smarty(){
    $smarty = new Smarty();
    $smarty->template_dir = './templates/';
    $smarty->compile_dir = './templates_c/';
    return $smarty;
}

function create_output($room){
    $chat = new Chat();
    $speaks = $chat->filter_room($room);
    $now = $chat->get_max_pk($room);
    $smarty = create_smarty();
    $smarty->assign('speaks', $speaks);
    $smarty->assign('now', $now);
    $read_response =  $smarty->fetch('display.tpl');

    $user = new User();
    $login_users = $user->get_usernames($room);
    return json_encode(array("read_response" => $read_response,
                             "login_users" => $login_users));
}

function create_index(){
    $smarty = create_smarty();
    $out =  $smarty->fetch('index.tpl');
    return $out;
}

function create_chat($room){
    $smarty = create_smarty();
    $smarty->assign('room', $room);
    $out =  $smarty->fetch('chat.tpl');
    return $out;
}

function create_roomlist(){
    $user = new User();
    $roomlist = $user->get_roomlist();
    $smarty = create_smarty();
    $smarty->assign('roomlist', $roomlist);
    $out =  $smarty->fetch('roomlist.tpl');
    return $out;
}

function comet_wait($room){
    $chat = new Chat();
    $user = new User();

    $pre_len = $chat->count();
    $pre_users = $user->get_usernames($room);
    error_log($pre_len, 3, '/home/rose/Documents/temp/pre_len.log');
    error_log($pre_users, 3, '/home/rose/Documents/temp/pre_users.log');
    while(true){
        sleep(1);
        $now_len = $chat->count();
        $now_users = $user->get_usernames($room);
        error_log($now_len, 3, '/home/rose/Documents/temp/now_len.log');
        error_log($now_users, 3, '/home/rose/Documents/temp/now_users.log');

        if($now_len != $pre_len or $now_users != $pre_users){
            break;
        }
    }
}

function comet_wait2(){
    $user = new User();

    $pre_rooms = $user->get_roomlist();
    $pre = implode(':::', $pre_rooms);
    while(true){
        sleep(1);
        $now_rooms = $user->get_roomlist();
        $now = implode(':::', $now_rooms);
        if($now != $pre){
            break;
        }
    }
}
?>