<?php

function analyzeMsg($input='', $output='')
{
    $return = 'I have no idea how Mike encrypt his message.';
    $input = trim($input);
    $output = trim($output);

    // validate input and output variable
    if( $input == '' || $output == '' || strlen($input) != strlen($output) || !preg_match("/^[0-9]+$/", $input) || !preg_match("/^[0-9]+$/", $output) ) {
        return $return;
    }

    $solution = [
        1 => 0, // Each original and encrypted characters sum up to 10
        2 => 0, // Each original and encrypted characters add -1
        3 => 0, // Each original and encrypted characters add 3
    ];
    $inputArr = str_split($input);
    $outputArr = str_split($output);
    foreach( $inputArr as $k => $v ) {
        if( $v + $outputArr[$k] == 10 ) {
            $solution[1]++;
        }
        if( ($v - 1) == $outputArr[$k] ) {
            $solution[2]++;
        }
        if( ($v + 3) == $outputArr[$k] ) {
            $solution[3]++;
        }
    }

    if( max($solution) != strlen($input) ) {
        return $return;
    }
    
    $maxs = array_keys($solution, max($solution));
    switch( $maxs[0] ) {
        case 1: 
            $return = 'Mike encrypts his message by summing up to 10 to each original character.';
            break;
        case 2: 
            $return = 'Mike encrypts his message by adding -1 to each original character.';
            break;
        case 3: 
            $return = 'Mike encrypts his message by adding 3 to each original character.';
            break;
    }

    return $return;
}

echo analyzeMsg('123456', '987654') . "\n";
echo analyzeMsg('98642', '87531') . "\n";
echo analyzeMsg('31625', '64958') . "\n";
echo analyzeMsg('98188', '15555') . "\n";





