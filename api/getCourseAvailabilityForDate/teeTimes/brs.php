<?php

require_once "../call/brsCall.php";
require_once "../processor/brsProcessor.php";

$BRSCall = new BRSCall();
$BRSProcessor = new BRSProcessor();

if ($golfCourses[$_GET["club"]]["onlineBooking"]) {
    $courseId = $_GET["courseId"];

    if ($courseId > 5) {
        $courseId = 0;
    }

    $teeTimes = $BRSCall->getTeeTimesForDay(
        $_GET["date"],
        $_GET["club"],
        $courseId,
    );

    $teeTimeInfo = $BRSProcessor->processTeeTimeForDay(
        $_GET["club"],
        $teeTimes,
        $golfCourses[$_GET["club"]],
        $_GET["date"],
    );
}
