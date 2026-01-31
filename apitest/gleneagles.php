<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36",
    //   CURLOPT_REFERER => "https://trump-international-golf-links-scotland.book.teeitup.com/",
    CURLOPT_COOKIEJAR => __DIR__ . "/cookies.txt",
    CURLOPT_COOKIEFILE => __DIR__ . "/cookies.txt",
    CURLOPT_HTTPHEADER => [
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
        "Accept-Language: en-GB,en;q=0.9",
        "Connection: keep-alive",
        //     "x-be-alias: trump-international-scotland",
    ],
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt(
    $ch,
    CURLOPT_URL,
    "https://pursuits.gleneagles.com/reservations/template/21459/availability/?day=31&month=1&year=2026&templateId=160448&time=Anytime",
);
//   https://pursuits.gleneagles.com/reservations/template/22052/availability/?from=&day=31&month=1&year=2026&to=&templateId=160451&next=&previous=&time=Anytime&note=&_=1769808298511

$response = curl_exec($ch);
$response = preg_replace('~\A.*?\r?\n\r?\n~s', "", $response);
echo $response;
