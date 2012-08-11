<?php
require_once('helper.php');
require_once('User.php');

$user = new User();
if($_GET['username'] && $_GET['room']){
    $username = $_GET['username'];
    $room = $_GET['room'];
    if($user->is_login($room, $username)){
    }else{
        $dt = date('Y-m-d H:i:s');
        $user->insert($room, $username, $dt);
    }
}
$output = create_output($room);
echo $output;
?>