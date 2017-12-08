<?php
function mix($s1, $s2) {
    // your code
    $arr1=getLowercaseLetterCount($s1);
    $arr2=getLowercaseLetterCount($s2);
    //diff,undiff,toString,找位置,删除小的,不能删多余字符位置会变
    $intersect=array_intersect_assoc($arr1,$arr2);

    var_dump($arr1);
    var_dump($arr2);
}

function getLowercaseLetterCount($string){
    $arr=str_split(preg_replace('/[^a-z]/','',$string));
    sort($arr);
    return array_count_values($arr);
}
mix("Are they here", "yes, they are here");

/*$this->revTest(mix("Are they here", "yes, they are here"), "2:eeeee/2:yy/=:hh/=:rr");
$this->revTest(mix("looping is fun but dangerous", "less dangerous than coding"), "1:ooo/1:uuu/2:sss/=:nnn/1:ii/2:aa/2:dd/2:ee/=:gg");
$this->revTest(mix(" In many languages", " there's a pair of functions"), "1:aaa/1:nnn/1:gg/2:ee/2:ff/2:ii/2:oo/2:rr/2:ss/2:tt");*/
