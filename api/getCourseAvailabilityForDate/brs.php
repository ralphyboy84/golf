<?php

require_once "../call/brsCall.php";
require_once "../processor/brsProcessor.php";

$BRSCall = new BRSCall();
$BRSProcessor = new BRSProcessor();

if ($golfCourses[$_GET["club"]]["onlineBooking"]) {
    $teeTimes = $BRSCall->getTeeTimesForDay(
        $_GET["date"],
        $_GET["club"],
        $_GET["courseId"],
    );

    $teeTimeInfo = $BRSProcessor->processTeeTimeForDay(
        $_GET["club"],
        $teeTimes,
        $golfCourses[$_GET["club"]],
        $_GET["date"],
    );
}

if ($golfCourses[$_GET["club"]]["openBooking"]) {
    $opens = $BRSCall->getAllOpensForCourse($_GET["club"]);

    $openOnDay = $BRSProcessor->checkForOpenOnDay($opens, $_GET["date"]);

    if (isset($openOnDay["competitionId"])) {
        $openField = $BRSCall->checkOpenAvailability(
            $_GET["club"],
            $openOnDay["competitionId"],
        );
        $openCompetitionInfo = $BRSProcessor->processOpenAvailability(
            $openField,
            $golfCourses[$_GET["club"]]["bookingLink"],
        );
    }
}
