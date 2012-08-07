<?php
require_once('helper.php');
require_once('User.php');

$user = new User();
$room = 'default';
if($_GET['username']){
    $username = $_GET['username'];
    if($user->is_login($room, $username)){
    }else{
        $dt = date('Y-m-d H:i:s');
        $user->insert($room, $username, $dt);
    }
}
$output = create_output('default');
echo $output;
?>