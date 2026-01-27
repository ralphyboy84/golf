<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36",
    CURLOPT_REFERER => "https://www.masterscoreboard.co.uk/",
    CURLOPT_COOKIEJAR => __DIR__ . "/cookies.txt",
    CURLOPT_COOKIEFILE => __DIR__ . "/cookies.txt",
    CURLOPT_HTTPHEADER => [
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
        "Accept-Language: en-GB,en;q=0.9",
        "Connection: keep-alive",
    ],
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt(
    $ch,
    CURLOPT_URL,
    "https://www.masterscoreboard.co.uk/bookgen/ClubBookings.php?CWID=6048",
);
$server_output = curl_exec($ch);
echo $server_output;
echo preg_replace("/^HTTP\/2\s+200\s.*?\R\R/s", "", $server_output);

// echo file_get_contents(
//     "https://www.masterscoreboard.co.uk/bookgen/ClubBookings.php?CWID=6048",
// );
