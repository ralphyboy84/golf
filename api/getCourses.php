<?php

header("Content-Type: application/json; charset=utf-8");

require_once "courses.php";

function get_courses_for_area($region, $courseList)
{
    foreach ($courseList as $courseName => $courseInfo) {
        if (isset($courseInfo["region"]) && $courseInfo["region"] == $region) {
            $newArray[$courseName] = $courseInfo;
        }
    }

    return $newArray;
}

function get_courses_from_array($coursesToFind, $courseList)
{
    foreach ($courseList as $courseName => $courseInfo) {
        if (in_array($courseName, $coursesToFind)) {
            $newArray[$courseName] = $courseInfo;
        }
    }

    return $newArray;
}

if (isset($_GET["region"]) && !empty($_GET["region"])) {
    $golfCourses = get_courses_for_area($_GET["region"], $golfCourses);
}

echo json_encode($golfCourses);
