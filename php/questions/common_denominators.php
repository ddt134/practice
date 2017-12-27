<?php
function convertFrac($lst){
    // your code
    if(empty($lst)){
        return '';
    }
    $lcm=1;//最小公倍数
    $lst=array_map(function($v) use(&$lcm) {
        //先约分成最简分数
        $gcd=gcd($v[0],$v[1]);
        $numerator=$v[0]/$gcd;
        $denominator=$v[1]/$gcd;
        $gcd=gcd($lcm,$denominator);
        $lcm*=($denominator/$gcd);
        return [$numerator,$denominator];
    },$lst);
    $arr=array_map(function($v)use($lcm){
        return "(".($v[0]*$lcm/$v[1]).",$lcm)";
    },$lst);
    return implode($arr);
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
var_dump(convertFrac([[69,138],[80,1310],[30,40]]));
/*$lst = [ [1, 2], [1, 3], [1, 4] ];
$this->revTest(convertFrac($lst), "(6,12)(4,12)(3,12)");
$lst = [ [69, 130], [87, 1310], [3, 4] ];
$this->revTest(convertFrac($lst), "(18078,34060)(2262,34060)(25545,34060)");
$lst = [  ];
$this->revTest(convertFrac($lst), "");
$lst = [ [77, 130], [84, 131], [3, 4] ];
$this->revTest(convertFrac($lst), "(20174,34060)(21840,34060)(25545,34060)");
[[69,138],[80,1310],[30,40]]
array(3) {
  [0]=>
  array(2) {
    [0]=>
    int(69)
    [1]=>
    int(138)
  }
  [1]=>
  array(2) {
    [0]=>
    int(80)
    [1]=>
    int(1310)
  }
  [2]=>
  array(2) {
    [0]=>
    int(30)
    [1]=>
    int(40)
  }
}

*/