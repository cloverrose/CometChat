<?php
function str2timestamp($str){
    list($Ymd, $His) = explode(' ', $str);
    list($Y, $m, $d) = explode('-', $Ymd);
    list($H, $i, $s) = explode(':', $His);
    return mktime($H, $i, $s, $m, $d, $Y);
}

function timestamp2str($timestamp){
    return date('Y-m-d H:i:s', $timestamp);
}
?>