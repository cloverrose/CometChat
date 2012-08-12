<?php
require_once('helper.php');
require_once('util.php');
require_once('Chat.php');

$chat = new Chat();

if(isset($_GET['username']) and isset($_GET['message'])
   and isset($_GET['pk']) and isset($_GET['room'])){

    $nick = $_GET["username"];
    $words = $_GET["message"];
    $pk = $_GET["pk"];
    $room = $_GET["room"];

    if($pk == 0){
        $pre_mt_str = $epoch;
        $post = $chat->find_post($pre_mt_str, $pk, $room);
        if(is_null($post)){
            $pre_mt_str = microtime2str(microtime()); // now
            $post_mt_str = microtime2str(microtime()); // now
        }else{
            $post_mt_str = $post['mt'];
        }
    }else{
        $pre = $chat->get_pk($pk);
        $pre_mt_str = $pre['mt'];
        $post = $chat->find_post($pre_mt_str, $pk, $room);
        if(is_null($post)){
            $post_mt_str = microtime2str(microtime()); // now
        }else{
            $post_mt_str = $post['mt'];
        }
    }
    $pre_mt = $pre_mt_str;
    $post_mt = $post_mt_str;
    $mid_mt = bcdiv(bcadd($pre_mt, $post_mt), 2);
    $mt = $mid_mt;
    $dt = timestamp2str(microtime2timestamp($mt));

    $chat->insert($nick, $words, $dt, $room, $mt);
    $output = create_output($room);
    echo $output;
}else{
    echo 'get parameter error';
}
?>