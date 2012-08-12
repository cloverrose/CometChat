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

function microtime2str($mt){
    $splits = explode(' ', $mt);
    $rm_dot = str_replace('.', '', $splits[0]);
    $ret = bcadd(bcmul($splits[1], '1000000000'), $rm_dot);
    return $ret;
}

function microtime2timestamp($mt){
    $len = strlen($mt);
    $index = $len - 9; // 9 is length of micro second
    $timestamp = substr($mt, 0, $index);
    return $timestamp;
}

function timestamp2microtime($timestamp){
    $rm_dot = str_replace('.', '', '0.00000000');
    $ret = bcadd(bcmul($timestamp, '1000000000'), $rm_dot);
    return $ret;
}

$epoch = '0.00000000 -32399';
?>