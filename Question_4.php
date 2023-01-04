<?php

// define item and vip listing
$item_rarity = [1,2,3,4,5,6,7,8];
$vip_ranks = ['vip1', 'vip2', 'vip3', 'vip4'];

// looping as per requested
for( $i=0; $i<100; $i++ ) {
    $data = [];
    foreach( $vip_ranks as $vip_rank ) {
        $data[$vip_rank] = roll_item($vip_rank);
    }
    print_r($data);
}

function roll_item($vip_rank)
{
    global $vip_ranks, $item_rarity;
    $data = [];

    $base = 20; // percentage of minimum rarity that lowest rank can roll
    $cap = 80; // percentage of maximum rarity that highest rank can roll
    $legendaryTotalPercentage = rand(2,5); // total percentage of legendary item

    $currentRankIndex = array_search($vip_rank, $vip_ranks);
    $higherChancesPercentage = $base + (($currentRankIndex+1)/count($vip_ranks)*($cap-$base));

    
    $lastHigherChanceItem = $item_rarity[floor(count($item_rarity)*$higherChancesPercentage/100)-1];
    $accumulatedHigher = 0;
    $accumulatedLower = 0;
    $remainingLowerItemCount = round(count($item_rarity)*(100-$higherChancesPercentage)/100);
    foreach( $item_rarity as $k => $v ) {
        $tmp = ($k+1)/count($item_rarity)*100;
        if( $tmp <= $higherChancesPercentage ) {
            if( $v == $lastHigherChanceItem ) {
                $item_chance = 100 - $legendaryTotalPercentage - $accumulatedHigher;
            } else {
                $item_chance = rand_item_higher((100-$legendaryTotalPercentage), (count($item_rarity)*$higherChancesPercentage/100));
                $accumulatedHigher += $item_chance;
            }
        } else {
            if( $remainingLowerItemCount == 1 && $accumulatedLower < $legendaryTotalPercentage ) {
                $item_chance = $legendaryTotalPercentage - $accumulatedLower;
            } else {
                $item_chance = rand_item_lower($legendaryTotalPercentage-$accumulatedLower, $remainingLowerItemCount);
            }
            $accumulatedLower += $item_chance;
            $remainingLowerItemCount--;
        }
        $data[$v] = $item_chance;
    }
    return $data;
}

function rand_item_higher($total, $higherItemCount)
{
    $floating = 0.3;
    $average = $total/$higherItemCount;
    $min = floor( ($total/$higherItemCount) - ($average*$floating) );
    $max = round( ($total/$higherItemCount) + ($average*$floating) );
    $rand = rand($min, $max);
    return $rand;
}

function rand_item_lower($total, $count)
{
    $values = [];
    $weights = [];
    for($i=0; $i <= $total; $i++) {
        $values[] = $i;
        if( $i == 0 ) {
            $weights[] = $count;
        } else {
            $weights[] = 1;
        }
    }
    $rand = weighted_random($values, $weights);
    return $rand;
}

function weighted_random($values, $weights){ 
    $count = count($values); 
    $i = 0; 
    $n = 0; 
    $num = mt_rand(0, array_sum($weights)); 
    while($i < $count){
        $n += $weights[$i]; 
        if($n >= $num){
            break; 
        }
        $i++; 
    } 
    return $values[$i]; 
}










