<?php

$text = file_get_contents("list.txt");

$text = str_replace(["\r\n", "\r"], "\n", $text);

// 2. Split by any whitespace (space, tab, newline)
$words = preg_split("/\s+/", $text);

// 3. Remove (number) patterns like (0), (14)
$words = array_map(function ($word) {
    return preg_replace("/\(\d+\)/", "", $word);
}, $words);

// 4. Remove empty strings that may have been left behind
$words = array_filter($words, fn($word) => $word !== "");

// 5. Reindex array
$words = array_values($words);

require_once "call/BRSCall.php";

$count = 0;

$oks = [];
$errors = [];

foreach ($words as $course) {
    $BRSCall = new BRSCall();
    $teeTimes = $BRSCall->getTeeTimesForDay(
        "2026-02-02",
        str_replace(" ", "", $course),
        1,
    );

    if ($teeTimes == '{"message":"Could not get tee sheet","code":8}') {
        $errors[] = $course;
    } else {
        $oks[] = $course;
    }

    $count++;

    if ($count == 10) {
        break;
    }
}

if ($oks) {
    echo "oks";
    echo "<br />";
    echo implode("<br />", $oks);
}

echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";

if ($errors) {
    echo "errors";
    echo "<br />";
    echo implode("<br />", $errors);
}
