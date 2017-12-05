<?php
function game($n) {
    // your code
    $foo=$n*$n;
    return ($foo%2)?[$foo,2]:[$foo/2];
}
var_dump(game(3));
//game(2)==2
//game(3)==9/2