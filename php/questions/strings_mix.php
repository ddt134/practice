<?php
function mix($s1, $s2) {
    // your code
    $arr1=getLowercaseLetterCount($s1);
    $arr2=getLowercaseLetterCount($s2);
    $res=[];
    array_walk($arr1,function($v,$k)use(&$res){
        if($v>1){
            $res[$k]['letter']=$k;
            $res[$k]['count']=$v;
            $res[$k]['from']=1;
        }
    });
    array_walk($arr2,function($v,$k)use(&$res){
        if(array_key_exists($k,$res)){
            if($v>$res[$k]['count']){
                $res[$k]['count']=$v;
                $res[$k]['from']=2;
            }else if($v==$res[$k]['count']){
                $res[$k]['from']='=';
            }
        }else if($v>1){
            $res[$k]['letter']=$k;
            $res[$k]['count']=$v;
            $res[$k]['from']=2;
        }
    });
    usort($res,function($a,$b){
        if($a['count']>$b['count']){
            return -1;
        }else if($a['count']==$b['count']){
            if($a['from']!=$b['from']){
                return strcasecmp($a['from'],$b['from']);
            }
            return strcasecmp($a['letter'],$b['letter']);
        }else{
            return 1;
        }
    });
    $res=array_reduce($res, function($carry,$item){
        return "$carry{$item['from']}:".(str_pad($item['letter'],$item['count'],$item['letter']))."/";
    },'');
    return rtrim($res,'/');
}


function getLowercaseLetterCount($string){
    $arr=str_split(preg_replace('/[^a-z]/','',$string));
    return array_count_values($arr);
}


var_dump(mix("4?'YTjxrNvXoe.EmaGgr7rkQ&Afvb4", "SDtzwdJn-4Y2zC(rrwnk=q7hlP;q,l"));
/*$this->revTest(mix("Are they here", "yes, they are here"), "2:eeeee/2:yy/=:hh/=:rr");
$this->revTest(mix("looping is fun but dangerous", "less dangerous than coding"), "1:ooo/1:uuu/2:sss/=:nnn/1:ii/2:aa/2:dd/2:ee/=:gg");
$this->revTest(mix(" In many languages", " there's a pair of functions"), "1:aaa/1:nnn/1:gg/2:ee/2:ff/2:ii/2:oo/2:rr/2:ss/2:tt");*/
