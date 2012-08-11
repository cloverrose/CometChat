<?php
require_once('helper.php');

if(isset($_GET['option']) and isset($_GET['room'])){
    $option = $_GET['option'];
    $room = $_GET['room'];
    if($option == 'wait'){
        comet_wait($room);
    }
    $output = create_output($room);
    echo $output;
}else{
    echo 'get parameter error';
}
?>