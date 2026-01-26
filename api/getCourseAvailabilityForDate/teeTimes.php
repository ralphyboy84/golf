<?php

require_once "../database/database.php";
require_once "../opens/opens.php";

if (
    isset($golfCourses[$_GET["club"]]["bookingSystem"]) &&
    !empty($golfCourses[$_GET["club"]]["bookingSystem"])
) {
    require_once "getCourseAvailabilityForDate/teeTimes/{$golfCourses[$_GET["club"]]["bookingSystem"]}.php";
}

if (
    isset($golfCourses[$_GET["club"]]["openBookingSystem"]) &&
    !empty($golfCourses[$_GET["club"]]["openBookingSystem"])
) {
    require_once "getCourseAvailabilityForDate/opens/{$golfCourses[$_GET["club"]]["openBookingSystem"]}.php";
}
