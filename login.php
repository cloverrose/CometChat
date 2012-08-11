<?php
require_once('helper.php');
require_once('User.php');

if(isset($_GET['username']) and isset($_GET['room'])){
    $username = $_GET['username'];
    $room = $_GET['room'];
    setcookie('username', $username, time()+60*60*24*30);
    $user = new User();
    if($user->is_login($room, $username)){
    }else{
        $dt = date('Y-m-d H:i:s');
        $user->insert($room, $username, $dt);
    }
    $output = create_output($room);
    echo $output;
}else{
    echo 'get parameter error';
}
?>