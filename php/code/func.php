<?php
//验证手机号
function checkMobile($mobile){
    return preg_match('/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/',$mobile);
}
//过滤多维数组
function arrayFilter($arr){
    return (is_array($arr))?array_map('arrayFilter',$arr):addslashes(trim($arr));
}