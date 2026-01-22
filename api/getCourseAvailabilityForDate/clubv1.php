<?php

require_once "../call/clubV1Call.php";
require_once "../processor/clubv1Processor.php";

$ClubV1Call = new ClubV1Call();
$ClubV1Processor = new ClubV1Processor();

if ($golfCourses[$_GET["club"]]["onlineBooking"]) {
    $response = $ClubV1Call->getTeeTimesForDay($_GET["date"], $_GET["club"]);

    $teeTimeInfo = $ClubV1Processor->processTeeTimeForDay(
        $response,
        $_GET["date"],
        $_GET["club"],
    );
}

if ($golfCourses[$_GET["club"]]["openBooking"]) {
    $opens = $ClubV1Call->getAllOpensForCourse($_GET["courseId"]);
    $openOnDay = $ClubV1Processor->checkForOpenOnDay(
        $opens,
        $_GET["date"],
        $_GET["courseId"],
    );

    if (
        isset($openOnDay["bookingOpen"]) &&
        $openOnDay["bookingOpen"] == "Yes"
    ) {
        $openField = false;
        $openField = $ClubV1Call->checkOpenAvailability(
            $openOnDay["token"],
            $openOnDay["competitionId"],
        );
        $openCompetitionInfo = $ClubV1Processor->processOpenAvailability(
            $openField,
            $openOnDay["competitionId"],
            $openOnDay["token"],
        );
    }
}
