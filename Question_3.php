<?php

function testSummary($array=[])
{
    $output = '';
    $allowedGender = ['Male', 'Female'];

    if( count($array) != 4 || !is_numeric($array[2]) || !is_numeric($array[3]) || !in_array($array[1], $allowedGender) ) {
        return 'Invalid input format.';
    }

    $address = $array[1] == 'Male' ? 'he' : 'she';
    $averageScore = number_format(($array[2] + $array[3]) / 2, 0);
   
    // part 1
    $output = sprintf('%s has an average score of %s from this test. ', $array[0], $averageScore);

    // part 2
    if( $array[2] >= 50 && $array[3] >= 50 ) {
        $output .= sprintf('Overall, %s is performing very well in this test.', $address);
    } else {
        $failedSubjectArray = [];
        if( $array[2] < 50 ) {
            $failedSubjectArray[] = 'Mathematics';
        }
        if( $array[3] < 50 ) {
            $failedSubjectArray[] = 'Science';
        }
        $failedSubjectTxt = implode(' and ', $failedSubjectArray);
        $subjectTxt = count($failedSubjectArray) > 1 ? 'subjects' : 'subject';

        $output .= sprintf('However, %s is not doing well for %s %s.', $address, $failedSubjectTxt, $subjectTxt);
    }

    return $output;
}

echo testSummary(['Annie', 'Female', 70, 50]) . "\n";
echo testSummary(['Max', 'Male', 20, 70]) . "\n";
echo testSummary(['Tom', 'Male', 40, 30]) . "\n";
echo testSummary(['Jerry', 'Human', 40, 30]) . "\n";
echo testSummary() . "\n";


