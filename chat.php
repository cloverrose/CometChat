<?php

require_once('helper.php');

if(isset($_GET['room'])){
    $room = $_GET['room'];
}else{
    $room = 'default';
}
$output = create_chat($room);
echo $output;
?>