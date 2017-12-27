<?php
function sqInRect($lng, $wdth) {
    // your code
    if($lng==$wdth){
        return null;
    }
    return cutSquares($lng, $wdth);
}

function cutSquares($a,$b){
    $res=[];
    $max=max($a,$b);
    $min=min($a,$b);
    $difference=$max-$min;
    $res[]=$min;
    if($difference>0){
        $res=array_merge($res,cutSquares($min,$difference));
    }
    return $res;
}
var_dump(cutSquares(5,3));
/*$this->revTest(sqInRect(5, 5), null);
$this->revTest(sqInRect(5, 3), [3, 2, 1, 1]);
$this->revTest(sqInRect(3, 5), [3, 2, 1, 1]);
$this->revTest(sqInRect(20, 14), [14, 6, 6, 2, 2, 2]);*/