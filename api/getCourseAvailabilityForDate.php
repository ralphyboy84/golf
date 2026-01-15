<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../courses.php";

$teeTimeInfo = [];
$openOnDay = [];
$openCompetitionInfo = [];
$additionalArray = [];

require_once "getCourseAvailabilityForDate/{$golfCourses[$_GET["club"]]["bookingSystem"]}.php";

$additionalArray = [
    "bookingUrl" =>
        $golfCourses[$_GET["club"]]["bookingLink"] . "?date=" . $_GET["date"],
];

echo json_encode(
    array_merge(
        $teeTimeInfo,
        $openOnDay,
        $openCompetitionInfo,
        $additionalArray,
    ),
);
