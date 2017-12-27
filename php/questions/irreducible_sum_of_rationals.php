<?php
function sumFracts($l) {
// your code
    $numerator=0;
    $lcm=1;//最小公倍数
    foreach($l as $k=>$v){
        $max=max($lcm,$v[1]);
        $min=min($lcm,$v[1]);
        if($max%$min){
            $lcm*=$v[1];
        }else{
            if($lcm==$min){
                $lcm=$v[1];
            }
        }
    }
    foreach($l as $k=>$v){
        $numerator+=$lcm/$v[1]*$v[0];
    }
    if(!$temp=$numerator%$lcm){
        return $numerator/$lcm;
    }
    $gcd=gcd($numerator,$lcm);//最大公约数
    return [$numerator/$gcd,$lcm/$gcd];
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
