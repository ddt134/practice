<?php
class FluentCalculator
{
    public static $instance;
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
    private $priorityOpt=['times','dividedBy'];
    private $optStack=[];
    private $numStack=[];
    private $result=[];
    private $count=0;
    private $lastName;
    public static function init() {
        if(!self::$instance instanceof FluentCalculator){
            self::$instance=new FluentCalculator();
        }


        return self::$instance;
    }

    public function __get($name){
        if($this->count>=8){
            throw new DigitCountOverflowException();
        }
        $this->count++;
        if(array_key_exists($name,$this->numMap)){
            if(empty($this->lastName)||in_array($this->lastName,$this->optMap)){
                array_push($this->numStack,$this->numMap[$name]);
            }else{
                array_push($this->numStack,array_pop($this->numStack)."{$this->numMap[$name]}");
            }
            return self::$instance;
        }
        if(in_array($name,$this->optMap)){
            if(empty($this->lastName)||array_key_exists($this->lastName,$this->numStack)){
                if(!empty($this->optStack)&&in_array(end($this->optStack),$this->priorityOpt)&&!in_array($name,$this->priorityOpt)){
                    $option=array_pop($this->optStack);
                    array_push($this->numStack,$option);
                }
                array_push($this->optStack,$name);
            }else{
                array_pop($this->optStack);
                array_push($this->optStack,$name);
            }
            return self::$instance;
        }
        throw new InvalidInputException();
    }

    public function __call($name,$param){
        if(array_key_exists($name,$this->numMap)){
            if(empty($this->lastName)||in_array($this->lastName,$this->optMap)){
                array_push($this->numStack,$this->numMap[$name]);
            }else{
                array_push($this->numStack,array_pop($this->numStack)."{$this->numMap[$name]}");
            }
        }
        if(in_array($name,$this->optMap)){
            if(empty($this->lastName)||array_key_exists($this->lastName,$this->numStack)){
                if(!empty($this->optStack)&&in_array(end($this->optStack),$this->priorityOpt)&&!in_array($name,$this->priorityOpt)){
                    $option=array_pop($this->optStack);
                    array_push($this->numStack,$option);
                }
                array_push($this->optStack,$name);
            }else{
                array_pop($this->optStack);
                array_push($this->optStack,$name);
            }
        }
        foreach($this->optStack as $k=>$v){
            array_push($this->numStack,$v);
        }
        foreach($this->numStack as $k=>$v){
            if(in_array($v,$this->numMap)){
                array_push($this->result,$v);
            }else{
                if(count($this->result)<2){
                    throw new InvalidInputException();
                }
                $num1=array_pop($this->result);
                $num2=array_pop($this->result);
                switch($v){
                    case 'plus':
                        $newNum=intval($num1)+intval($num2);
                        break;
                    case 'minus':
                        $newNum=intval($num1)-intval($num2);
                        break;
                    case 'times':
                        $newNum=intval($num1)*intval($num2);
                        break;
                    case 'dividedBy':
                        if($num2==0){
                            throw new DivisionByZeroException();
                        }
                        $newNum=intval($num1)/intval($num2);
                        break;
                }
                array_push($this->result,$newNum);
            }
        }
        if(strlen($this->result[0])>9){
            throw new DigitCountOverflowException();
        }
        return $this->result[0];
    }

}

var_dump(FluentCalculator::init()->one->zero());

/*public function testBasicValueTests() {
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

