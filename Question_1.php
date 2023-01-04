<?php
session_start();

function checkDownload($memberType='member', $fileType='jpeg')
{
    $sessionName = 'download_status';
    $bufferTime = 5; // seconds
    $now = time();
    $allowDownload = true;
    $allowedMemberType = ['member', 'non_member'];

    // to prevent invalid member type input
    if( !in_array($memberType, $allowedMemberType) ) {
        return false;
    }
    
    // retrieve download status from session variable
    $downloadStatus = [
        'time' => 0, // last download time
        'jpeg_counter' => 0, // for member use only 
    ];
    if( isset($_SESSION[$sessionName]) ) {
        $downloadStatus = json_decode($_SESSION[$sessionName], true);
    }

    // checking logic
    if( ($downloadStatus['time'] + $bufferTime) > $now ) {
        if( $memberType == 'member' && $fileType == 'jpeg' && $downloadStatus['jpeg_counter'] < 2 ) {
            $downloadStatus['jpeg_counter']++;
        } else {
            $allowDownload = false;
        }
    } else {
        $downloadStatus['time'] = $now;
        $downloadStatus['jpeg_counter'] = ($memberType == 'member' && $fileType == 'jpeg') ? 1 : 0;
    }

    // update session status
    $_SESSION[$sessionName] = json_encode($downloadStatus);

    // response
    if( $allowDownload ) {
        return 'Your download is starting...';
    } else {
        return 'Too many downloads';
    }
}

echo checkDownload('member', 'jpeg');


