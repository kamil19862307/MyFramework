<?php

$array = [1,1,2,2,3,3,4,4,5,5,6,6,42,59,102];

$maxVariable = 0;
$maxVariable2 = 0;

foreach ($array as $item) {
    if ($item > $maxVariable){
        $maxVariable2 = $maxVariable;
        $maxVariable = $item;
    }
}

echo $maxVariable2;