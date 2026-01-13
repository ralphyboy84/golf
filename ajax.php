<?php

header("Content-Type: application/json; charset=utf-8");

require_once "courses.php";

$teeTimeInfo = [];
$openOnDay = [];
$openCompetitionInfo = [];

if ($_GET["bookingSystem"] == "clubv1") {
    require_once "call/clubV1Call.php";
    require_once "processor/clubV1Processor.php";

    $ClubV1Call = new ClubV1Call();
    $ClubV1Processor = new ClubV1Processor();

    if ($_GET["onlineBooking"]) {
        $response = $ClubV1Call->getTeeTimesForDay(
            $_GET["date"],
            $_GET["club"],
        );

        $teeTimeInfo = $ClubV1Processor->processTeeTime(
            $response,
            $_GET["date"],
            $_GET["club"],
        );
    }

    if ($_GET["openBooking"]) {
        $opens = $ClubV1Call->getOpens($_GET["courseId"]);
        $openOnDay = $ClubV1Processor->checkForOpenOnDay($opens, $_GET["date"]);

        if ($openOnDay) {
            $openField = false;
            $openField = $ClubV1Call->checkOpenAvailability(
                $openOnDay["token"],
                $openOnDay["competitionId"],
            );
            $openCompetitionInfo = $ClubV1Processor->processOpenCompetition(
                $openField,
                $openOnDay["competitionId"],
                $openOnDay["token"],
            );
        }
    }
} elseif ($_GET["bookingSystem"] == "brs") {
    require_once "call/brsCall.php";
    require_once "processor/brsProcessor.php";

    $BRSCall = new BRSCall();
    $BRSProcessor = new BRSProcessor();

    if ($_GET["onlineBooking"]) {
        $teeTimes = $BRSCall->getTeeTimesForDay(
            $_GET["date"],
            $_GET["club"],
            $_GET["courseId"],
        );

        $teeTimeInfo = $BRSProcessor->processTeeTime(
            $_GET["club"],
            $teeTimes,
            $golfCourses[$_GET["club"]],
        );
    }

    if ($_GET["openBooking"]) {
        $opens = $BRSCall->getOpens($_GET["club"]);

        $openOnDay = $BRSProcessor->checkForOpenOnDay($opens, $_GET["date"]);

        if ($openOnDay) {
            $openField = $BRSCall->checkOpenAvailability(
                $_GET["club"],
                $openOnDay["competitionId"],
            );
            $openCompetitionInfo = $BRSProcessor->processOpenCompetition(
                $openField,
            );
        }
    }
}

echo json_encode(array_merge($teeTimeInfo, $openOnDay, $openCompetitionInfo));
