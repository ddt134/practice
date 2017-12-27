<?php
class FluentCalculator
{
    private $numMap=[
        'zero'=>0,
        'one'=>1,
        'two'=>2,
        'three'=>3,
        'four'=>4,
        'five'=>5,
        'six'=>6,
        'seven'=>7,
        'eight'=>8,
        'nine'=>9,
    ];
    private $optMap=['plus','minus','times','dividedBy'];
    private $temp=[];
    private $lastName=null;
    public static function init() {
        return new FluentCalculator();
    }

    public function __get($name){
        if(array_key_exists($name,$this->numMap)){
            if($this->lastName!==null&&in_array($this->lastName,$this->numMap,true)){
                array_push($this->temp,intval(array_pop($this->temp)."{$this->numMap[$name]}"));
            }else{
                array_push($this->temp,$this->numMap[$name]);
            }
            $this->lastName=$this->numMap[$name];
            return $this;
        }
        if(in_array($name,$this->optMap)){
            if($this->lastName===null){
                array_push($this->temp,0);
                array_push($this->temp,$name);
            }else{
                if(in_array($this->lastName,$this->optMap,true)){
                    array_pop($this->temp);
                }
                array_push($this->temp,$name);
            }
            $this->lastName=$name;
            return $this;
        }
        throw new InvalidInputException();
    }

    public function __call($name,$param){
        $this->__get($name);
        if(in_array(end($this->temp),$this->optMap,true)){
            array_pop($this->temp);
        }
        $limit=count($this->temp);
        if($limit>=3){
            $num1=$this->temp[0];
            for($i=2;$i<=$limit;$i+=2){
                $option=$this->temp[$i-1];
                $num2=$this->temp[$i];
                if(strlen(abs($num1))>9||strlen(abs($num2))>9){
                    throw new DigitCountOverflowException();
                }
                switch($option){
                    case 'plus':
                        $num1=intval($num1)+intval($num2);
                        break;
                    case 'minus':
                        $num1=intval($num1)-intval($num2);
                        break;
                    case 'times':
                        $num1=intval($num1)*intval($num2);
                        break;
                    case 'dividedBy':
                        if($num2==0){
                            throw new DivisionByZeroException();
                        }
                        $quotient=intval($num1)/intval($num2);
                        $num1=($quotient>0)?intval(floor($quotient)):intval(ceil($quotient));
                        break;
                }
            }
            $res=$num1;
        }else{
            $res=$this->temp[0];
        }
        if(strlen(abs($res))>9){
            throw new DigitCountOverflowException();
        }
        return $res;
    }
}
/*
 * intval(in_array($name,['times','dividedBy']))
 * if(!array_key_exists($name,$this->numMap)&&!in_array($name,$this->optMap)){
           throw new InvalidInputException();
       }
       if(array_key_exists($name,$this->numMap)){
           if($this->lastName!==null&&in_array($this->lastName,$this->numMap,true)){
               array_push($this->temp,intval(array_pop($this->temp)."{$this->numMap[$name]}"));
           }else{
               array_push($this->temp,$this->numMap[$name]);
           }
       }
       if(in_array($name,$this->optMap)) {
           if ($this->lastName === null) {
               array_push($this->temp, intval(in_array($name, ['times', 'dividedBy'])));
               array_push($this->temp, $name);
           }
       }*/
/*var_dump(ceil(-0.01));
var_dump(ceil(-1.55));
var_dump(ceil(-0.5));*/
var_dump(FluentCalculator::init()->minus->four->zero->times->minus->eight->five->two->three->times->zero->eight->two->two->seven->five());
/*
 public function testShouldThrowDigitCountOverflowException1() {
		$this->expectException(DigitCountOverflowException::class);
		FluentCalculator::init()->one->two->three->four->five->six->seven->eight->nine->zero();
	}
	public function testShouldThrowDigitCountOverflowException2() {
		$this->expectException(DigitCountOverflowException::class);
		FluentCalculator::init()->one->two->three->four->five->six->seven->eight->nine->times->one->two();
	}
	public function testShouldThrowDigitCountOverflowException3() {
		$this->expectException(DigitCountOverflowException::class);
		FluentCalculator::init()->nine->nine->nine->nine->nine->nine->nine->nine->nine->plus->one();
	}
	public function testShouldThrowDigitCountOverflowException4() {
		$this->expectException(DigitCountOverflowException::class);
		FluentCalculator::init()->one->zero->zero->zero->zero->zero->times->one->zero->zero->zero->zero->zero();
	}
 public function testBasicValueTests() {
    $this->assertSame(FluentCalculator::init()->zero(), 0);
    $this->assertSame(FluentCalculator::init()->one(), 1);
    $this->assertSame(FluentCalculator::init()->two(), 2);
    $this->assertSame(FluentCalculator::init()->three(), 3);
    $this->assertSame(FluentCalculator::init()->four(), 4);
    $this->assertSame(FluentCalculator::init()->five(), 5);
    $this->assertSame(FluentCalculator::init()->six(), 6);
    $this->assertSame(FluentCalculator::init()->seven(), 7);
    $this->assertSame(FluentCalculator::init()->eight(), 8);
    $this->assertSame(FluentCalculator::init()->nine(), 9);
    $this->assertSame(FluentCalculator::init()->one->zero(), 10);
    $this->assertSame(FluentCalculator::init()->minus->three->zero(), -30);
    $this->assertSame(FluentCalculator::init()->nine->nine->nine->nine->nine->nine->nine->nine->nine(), 999999999);
}
public function testBasicOperationTests() {
    $this->assertSame(FluentCalculator::init()->two->one->plus->three(), 24);
    $this->assertSame(FluentCalculator::init()->one->minus->three(), -2);
    $this->assertSame(FluentCalculator::init()->two->times->four->five(), 90);
    $this->assertSame(FluentCalculator::init()->three->three->dividedBy->six(), 5);
    $this->assertSame(FluentCalculator::init()->two->one->plus->three->times(), 24);
    $this->assertSame(FluentCalculator::init()->one->minus->three->times(), -2);
    $this->assertSame(FluentCalculator::init()->two->times->four->five->minus(), 90);
    $this->assertSame(FluentCalculator::init()->three->three->dividedBy->six->dividedBy(), 5);
    $this->assertSame(FluentCalculator::init()->two->one->plus->dividedBy->three(), 7);
    $this->assertSame(FluentCalculator::init()->one->zero->times->minus->three->three(), -23);
    $this->assertSame(FluentCalculator::init()->two->times->minus->four->five->seven(), -455);
}
public function testMoreThanOneOperations() {
    $this->assertSame(55, FluentCalculator::init()->one->zero->plus->seven->plus->four->plus->one->plus->zero->plus->two->plus->nine->plus->five->plus->eight->plus->six->plus->three());
    $this->assertSame(-35, FluentCalculator::init()->five->minus->one->minus->nine->minus->two->minus->eight->minus->seven->minus->three->minus->one->zero->minus->zero());
    $this->assertSame(362880, FluentCalculator::init()->seven->times->three->times->two->times->nine->times->one->times->eight->times->four->times->six->times->five());
    $this->assertSame(0, FluentCalculator::init()->one->zero->dividedBy->one->dividedBy->two->dividedBy->five->dividedBy->six->dividedBy->seven->dividedBy->four());
    $this->assertSame(4, FluentCalculator::init()->zero->plus->three->plus->one());
    $this->assertSame(14, FluentCalculator::init()->one->minus->one->zero->dividedBy->nine->plus->three->times->seven());
    $this->assertSame(15, FluentCalculator::init()->one->plus->two->dividedBy->three->times->one->zero->minus->three->plus->eight());
    $this->assertSame(-4, FluentCalculator::init()->three->dividedBy->six->times->one->zero->plus->three->minus->seven());
}*/