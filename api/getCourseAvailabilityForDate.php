<?php

header("Content-Type: application/json; charset=utf-8");

require_once "courses.php";

$teeTimeInfo = [];
$openOnDay = [];
$openCompetitionInfo = [];
$additionalArray = [];

if (
    isset($golfCourses[$_GET["club"]]["bookingSystem"]) &&
    !empty($golfCourses[$_GET["club"]]["bookingSystem"])
) {
    require_once "getCourseAvailabilityForDate/{$golfCourses[$_GET["club"]]["bookingSystem"]}.php";

    $additionalArray = [
        "bookingUrl" =>
            $golfCourses[$_GET["club"]]["bookingLink"] .
            "?date=" .
            $_GET["date"],
    ];
} else {
    $day = strtolower(date("D", strtotime($_GET["date"])));

    if (in_array($day, $golfCourses[$_GET["club"]]["availabilityDays"])) {
        $additionalArray = [
            "onlineBooking" => "No",
            "visitorsAvailable" => "Yes",
            "date" => $_GET["date"],
            "bookingInfo" => $golfCourses[$_GET["club"]]["bookingLink"],
        ];
    } else {
        $additionalArray = [
            "onlineBooking" => "No",
            "visitorsAvailable" => "No",
            "date" => $_GET["date"],
            "bookingInfo" => $golfCourses[$_GET["club"]]["bookingLink"],
        ];
    }
}

echo json_encode(
    array_merge(
        $teeTimeInfo,
        $openOnDay,
        $openCompetitionInfo,
        $additionalArray,
    ),
);
