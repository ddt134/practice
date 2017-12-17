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
    private $stack=[];
    private $result=[];
    private $count=0;
    public static function init() {
        if(!self::$instance instanceof FluentCalculator){
            self::$instance=new FluentCalculator();
        }


        return self::$instance;
    }

    public function __call($name,$param){
        if($this->count>=9){
            throw new DigitCountOverflowException();
        }
        $this->count++;
        if(array_key_exists($name,$this->numMap)){

            if(in_array(end($this->stack),$this->numMap)){
array_pop($this->stack)
            }
        }
                array_push($this->stack,1);

        return self::$instance;
    }
    // you can define 2 (two) more methods

}

FluentCalculator::init()->a();

