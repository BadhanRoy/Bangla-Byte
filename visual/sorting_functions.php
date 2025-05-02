<?php
// This file is included for potential server-side sorting implementations
// though our current solution is client-side with JavaScript

function bubbleSortServer($array) {
    $n = count($array);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($array[$j] > $array[$j+1]) {
                // Swap elements
                $temp = $array[$j];
                $array[$j] = $array[$j+1];
                $array[$j+1] = $temp;
            }
        }
    }
    return $array;
}

function mergeSortServer($array) {
    if (count($array) <= 1) {
        return $array;
    }
    
    $mid = (int)(count($array) / 2);
    $left = array_slice($array, 0, $mid);
    $right = array_slice($array, $mid);
    
    $left = mergeSortServer($left);
    $right = mergeSortServer($right);
    
    return mergeServer($left, $right);
}

function mergeServer($left, $right) {
    $result = [];
    $i = 0;
    $j = 0;
    
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i] <= $right[$j]) {
            $result[] = $left[$i];
            $i++;
        } else {
            $result[] = $right[$j];
            $j++;
        }
    }
    
    while ($i < count($left)) {
        $result[] = $left[$i];
        $i++;
    }
    
    while ($j < count($right)) {
        $result[] = $right[$j];
        $j++;
    }
    
    return $result;
}
?>