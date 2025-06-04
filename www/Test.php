<?php

$line = "1 2 3 4 5 6 7 8 9";

$line = trim($line);

$array = explode(' ', $line);

foreach ($array as $item){
    if ($item % 2 === 0){
        echo $item . ' ';
    }
}
