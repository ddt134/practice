<?php
class Sq2Squares
{
    public static function decompose($n) {
        // your code
        $total=pow($n,2);
        return self::tryDecompose($total,$n-1,[]);
    }

    public static function tryDecompose($total,$n,$res){
        if($n>0){
            $temp=$total-pow($n,2);
            if($temp>0){
                array_unshift($res,$n);
                $i=floor(sqrt($temp));
                if($i<$res[0]){
                    return self::tryDecompose($temp,$i,$res);
                }else{
                    $len=count($res);
                    while($res) {
                        $j=array_shift($res)-1;
                        $retryResult=self::tryDecompose($temp+pow($j+1,2)+pow($i,2),$j,$res);
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
var_dump(Sq2Squares::decompose(50));
/*$this->revTest(Sq2Squares::decompose(50), [1,3,5,8,49]);
$this->revTest(Sq2Squares::decompose(44), [2,3,5,7,43]);*/