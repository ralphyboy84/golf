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
        "bookingUrl" => get_booking_url(
            $golfCourses[$_GET["club"]],
            $_GET["date"],
            $_GET["courseId"],
        ),
        "courseName" => get_course_name(
            $_GET["club"],
            $golfCourses,
            $_GET["courseId"],
        ),
    ];
} else {
    $day = strtolower(date("D", strtotime($_GET["date"])));

    $df = explode("-", $_GET["date"]);

    if (in_array($day, $golfCourses[$_GET["club"]]["availabilityDays"])) {
        $additionalArray = [
            "courseName" => get_course_name(
                $_GET["club"],
                $golfCourses,
                $_GET["courseId"],
            ),
            "onlineBooking" => "No",
            "visitorsAvailable" => "Yes",
            "date" => $df[2] . "/" . $df[1] . "/" . $df[0],
            "bookingUrl" => $golfCourses[$_GET["club"]]["bookingLink"],
        ];
    } else {
        $additionalArray = [
            "courseName" => get_course_name(
                $_GET["club"],
                $golfCourses,
                $_GET["courseId"],
            ),
            "onlineBooking" => "No",
            "visitorsAvailable" => "No",
            "date" => $df[2] . "/" . $df[1] . "/" . $df[0],
            "bookingUrl" => $golfCourses[$_GET["club"]]["bookingLink"],
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
