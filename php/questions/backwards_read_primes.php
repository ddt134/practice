<?php
function backwardsPrime($start, $stop){
    // your code
    $st = max($start % 2 == 1 ? $start : $start + 1, 13);
    $res=[];
    for($i=$st;$i<=$stop;$i+=2){
        if(isPrime($i)){
            $reverseString=strrev($i);
            if($i!=$reverseString&&isPrime($reverseString)){
                $res[]=$i;
            }
        }
    }
    return $res;
}

function isPrime($num){
    if($num<=1){
        return false;
    }
    $limit=sqrt($num);
    for($i=2;$i<=$limit;$i++){
        if(!($num%$i)){
            return false;
        }
    }
    return true;
}

/*function reverse($string){
    $arr=str_split($string);
    $arr=array_reverse($arr);
    return implode('',$arr);
}*/
//var_dump(reverse('abcde'));

$a = [7027, 7043, 7057];
var_dump(backwardsPrime(7000, 7100));
