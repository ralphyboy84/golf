<?php

$text = file_get_contents("clubv1.txt");

$text = str_replace(["\r\n", "\r"], "\n", $text);

// 2. Split by any whitespace (space, tab, newline)
$words = preg_split("/\s+/", $text);

// 3. Remove (number) patterns like (0), (14)
$words = array_map(function ($word) {
    return preg_replace("/\(\d+\)/", "", $word);
}, $words);

echo "<pre>";

foreach ($words as $word) {
    echo '"' .
        $word .
        '" => [
        "name" => "' .
        ucfirst($word) .
        '",
        "bookingLink" => "https://' .
        $word .
        '.hub.clubv1.com/Visitors/TeeSheet",
        "onlineBooking" => "Yes",
        "greenFee" => "340",
        "image" => "",
        "bookingSystem" => "clubv1",
        "region" => "",
    ],
    ';
}
