<?php
require_once('helper.php');
require_once('util.php');
require_once('Chat.php');

$chat = new Chat();
$nick = $_GET["username"];
$words = $_GET["message"];
$pk = $_GET["pk"];
if($pk == 0){
    $pre_dt_str = '1970-01-01 00:00:01';
    $post = $chat->find_post($pre_dt_str, $pk);
    if(is_null($post)){
        $pre_dt_str = date('Y-m-d H:i:s');
        $post_dt_str =  date('Y-m-d H:i:s');
    }else{
        $post_dt_str = $post['dt'];
    }
    $pre_dt = str2timestamp($pre_dt_str);
    $post_dt = str2timestamp($post_dt_str);
    $mid_dt = ($pre_dt + $post_dt) / 2;
    $dt = timestamp2str($mid_dt);
}else{
    $pre = $chat->get_pk($pk);
    $pre_dt_str = $pre['dt'];
    $post = $chat->find_post($pre_dt_str, $pk);
    if(is_null($post)){
        $post_dt_str =  date('Y-m-d H:i:s');
    }else{
        $post_dt_str = $post['dt'];
    }
    $pre_dt = str2timestamp($pre_dt_str);
    $post_dt = str2timestamp($post_dt_str);
    $mid_dt = ($pre_dt + $post_dt) / 2;
    $dt = timestamp2str($mid_dt);
}
$chat->insert($nick, $words, $dt);
$output = create_output('default');
echo $output;
?>