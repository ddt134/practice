<?php
class Sq2Squares
{
    public static function decompose($n) {
        // your code
        $total=pow($n,2);
        return self::tryDecompose($total,intval($n-1),[]);
    }

    public static function tryDecompose($total,$n,$res){
        if($n>0){
            $temp=$total-pow($n,2);
            if($temp>0){
                array_unshift($res,$n);
                $i=intval(floor(sqrt($temp)));
                if($i<$res[0]){
                    return self::tryDecompose($temp,$i,$res);
                }else{
                    $j=array_shift($res);
                    if($j==$i){
                        $total+pow($j,2);
                    }
                    while($res) {
                        $j=array_shift($res)-1;
                        $retryResult=self::tryDecompose($total+pow($j+1,2),$j,$res);//$temp+pow($j+1,2)+pow($n,2)
                        if($retryResult){
                            return $retryResult;
                        }
                    }
                    return false;
                }
            }else if($temp==0){
                array_unshift($res,$n);
                return $res;
            }else{
                return self::tryDecompose($total,$n-1,$res);
            }
        }else{
            return false;
        }
    }

}
/*
 * 牛人的解法
 class Sq2Squares
{
    private static $list;

    private static function divide($remain, $last) {
        if ($remain <= 0) return $remain == 0;
        for ($i = $last - 1; $i > 0; $i--)
            if (self::divide($remain - ($i * $i), $i)) {
                array_push(self::$list, $i);
                return true;
            }
        return false;
    }
    public static function decompose($n) {
        self::$list = array();
        if (self::divide($n * $n, $n)) return self::$list;
        return null;
    }
}*/
var_dump(Sq2Squares::decompose(50));
/*$this->revTest(Sq2Squares::decompose(50), [1,3,5,8,49]);
$this->revTest(Sq2Squares::decompose(44), [2,3,5,7,43]);
7654321 Array (
    0 => 6
    1 => 10
    2 => 69
    3 => 3912
    4 => 7654320
)

31346   Array (
    0 => 1
    1 => 2
    2 => 4
    3 => 7
    4 => 11
    5 => 250
    6 => 31345
)
*/

