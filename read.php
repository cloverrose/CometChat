<?php
require_once('helper.php');

if($_GET['option']){
    $option = $_GET['option'];
    $room = $_GET['room'];
    if($option == 'wait'){
        comet_wait($room);
    }
    $output = create_output($room);
    echo $output;
}
?>