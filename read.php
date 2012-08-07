<?php
require_once('helper.php');

if($_GET['option']){
    $option = $_GET['option'];
    if($option == 'wait'){
        comet_wait('default');
    }
    $output = create_output('default');
    echo $output;
}
?>