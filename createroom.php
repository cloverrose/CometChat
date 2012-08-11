<?php
require_once('helper.php');
require_once('User.php');

$user = new User();
if($_GET['room']){
    $room = $_GET['room'];
    $username = 'dummy';
    if($user->is_login($room, $username)){
    }else{
        $dt = date('Y-m-d H:i:s');
        $user->insert($room, $username, $dt);
    }
}
$output = create_roomlist();
echo $output;
?>