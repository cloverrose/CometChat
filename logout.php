<?php
require_once('helper.php');
require_once('User.php');

$user = new User();
$room = 'default';
if($_GET['username']){
    $username = $_GET['username'];
    if($user->is_login($room, $username)){
        $user->delete($room, $username);    
    }else{
    }
}
$output = create_output('default');
echo $output;
?>