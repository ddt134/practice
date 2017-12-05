<?php
function sumFracts($l) {
// your code
    $numerator=0;
    $denominator=1;//最小公倍数
    foreach($l as $k=>$v){
        $max=max($denominator,$v[1]);
        $min=min($denominator,$v[1]);
        if($max%$min){
            $denominator*=$v[1];
        }else{
            if($denominator==$min){
                $denominator=$v[1];
            }
        }
    }
    foreach($l as $k=>$v){
        $numerator+=$denominator/$v[1]*$v[0];
    }
    if(!$temp=$numerator%$denominator){
        return $numerator/$denominator;
    }
    $gcd=gcd($numerator,$denominator);//最大公约数
    return [$numerator/$gcd,$denominator/$gcd];
}

function gcd($a,$b){
    if($a<=0||$b<=0){
        return 0;
    }
    $max=max($a,$b);
    $min=min($a,$b);
    $temp=$max%$min;
    if($temp==0){
        return $min;
    }else{
        return gcd($min,$temp);
    }
}
//$a=[[1, 2], [1, 3], [1, 4]];
$a=[[1, 3], [5, 3]];
var_dump(sumFracts($a));
