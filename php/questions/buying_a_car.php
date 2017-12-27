<?php
function nbMonths($startPriceOld, $startPriceNew, $savingPerMonth, $percentLossByMonth) {
    // your code
    if($startPriceOld>=$startPriceNew){
        return [0,$startPriceOld-$startPriceNew];
    }
    $i=0;
    $savingMoney=0;
    while($startPriceNew-$startPriceOld-$savingMoney>0){
        $i++;
        $savingMoney=$savingPerMonth*$i;
        $loss=1-$percentLossByMonth/100-floor($i/2)*0.005;
        $startPriceOld*=$loss;
        $startPriceNew*=$loss;
        $a=1;
    }
    return [$i,round($startPriceOld+$savingMoney-$startPriceNew)];
}
var_dump(nbMonths(8000, 12000, 500, 1));
/*$this->revTest(nbMonths(2000, 8000, 1000, 1.5), [6, 766]);
$this->revTest(nbMonths(12000, 8000, 1000, 1.5) ,[0, 4000]);
$this->revTest(nbMonths(8000, 12000, 500, 1), [8, 597]);*/