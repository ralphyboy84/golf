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

echo "<pre>";
print_r($words);
