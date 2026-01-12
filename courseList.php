<?php

$html = file_get_contents("tmp.html");

preg_match_all('/<span class="text">([^<]+)<\/span/', $html, $matches);

// 2. Clean each name
$cleanCourses = array_map(function ($name) {
    // Remove "Golf Club" and number in parentheses
    $name = preg_replace("/\s*Golf Club\s*\(\d+\)/i", "", $name);
    return strtolower(trim($name));
}, $matches[1]);

echo "<pre>";
echo implode("<br>", $cleanCourses);
