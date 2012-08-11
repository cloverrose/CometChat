<?php
require_once('helper.php');

if($_GET['option']){
    $option = $_GET['option'];
    if($option == 'wait'){
        comet_wait2();
    }
    $output = create_roomlist();
    echo $output;
}
?>