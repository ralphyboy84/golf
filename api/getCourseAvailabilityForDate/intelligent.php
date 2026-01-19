<?php

require_once "../call/intelligentCall.php";
require_once "../processor/intelligentProcessor.php";

$IntelligentCall = new IntelligentCall();
$IntelligentProcessor = new IntelligentProcessor();

if ($golfCourses[$_GET["club"]]["onlineBooking"]) {
    $courseId = "";

    if (isset($_GET["courseId"])) {
        $courseId = $_GET["courseId"];
    }

    $teeTimes = $IntelligentCall->getTeeTimesForDay(
        $golfCourses[$_GET["club"]]["baseUrl"],
        $_GET["date"],
        $courseId,
    );

    $teeTimeInfo = $IntelligentProcessor->processTeeTimeForDay(
        $_GET["club"],
        $teeTimes,
        $golfCourses[$_GET["club"]],
        $_GET["date"],
    );
}

if ($golfCourses[$_GET["club"]]["openBooking"]) {
    $opens = $IntelligentCall->getAllOpensForCourse(
        $golfCourses[$_GET["club"]]["baseUrl"],
        $_GET["club"],
    );
    $openOnDay = $IntelligentProcessor->checkForOpenOnDay(
        $opens,
        $_GET["date"],
    );

    if (isset($openOnDay["competitionId"])) {
        $openField = $IntelligentCall->checkOpenAvailability(
            $golfCourses[$_GET["club"]]["baseUrl"],
            $_GET["club"],
            $openOnDay["competitionId"],
        );
        $openCompetitionInfo = $IntelligentProcessor->processOpenAvailability(
            $openField,
            $_GET["club"],
            $openOnDay["competitionId"],
        );
    }
}
