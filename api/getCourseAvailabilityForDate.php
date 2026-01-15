<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../courses.php";

$teeTimeInfo = [];
$openOnDay = [];
$openCompetitionInfo = [];
$additionalArray = [];

if ($golfCourses[$_GET["club"]]["bookingSystem"] == "clubv1") {
    require_once "../call/clubV1Call.php";
    require_once "../processor/clubV1Processor.php";

    $ClubV1Call = new ClubV1Call();
    $ClubV1Processor = new ClubV1Processor();

    if ($golfCourses[$_GET["club"]]["onlineBooking"]) {
        $response = $ClubV1Call->getTeeTimesForDay(
            $_GET["date"],
            $_GET["club"],
        );

        $teeTimeInfo = $ClubV1Processor->processTeeTimeForDay(
            $response,
            $_GET["date"],
            $_GET["club"],
        );
    }

    if ($golfCourses[$_GET["club"]]["openBooking"]) {
        $opens = $ClubV1Call->getAllOpensForCourse($_GET["courseId"]);
        $openOnDay = $ClubV1Processor->checkForOpenOnDay($opens, $_GET["date"]);

        if (isset($openOnDay["competitionId"])) {
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
} elseif ($golfCourses[$_GET["club"]]["bookingSystem"] == "brs") {
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
} elseif ($golfCourses[$_GET["club"]]["bookingSystem"] == "intelligent") {
    require_once "../call/intelligentCall.php";
    require_once "../processor/intelligentProcessor.php";

    $IntelligentCall = new IntelligentCall();
    $IntelligentProcessor = new IntelligentProcessor();

    if ($golfCourses[$_GET["club"]]["onlineBooking"]) {
        $teeTimes = $IntelligentCall->getTeeTimesForDay(
            $golfCourses[$_GET["club"]]["baseUrl"],
            $_GET["date"],
        );

        $teeTimeInfo = $IntelligentProcessor->processTeeTimeForDay(
            $_GET["club"],
            $teeTimes,
            $golfCourses[$_GET["club"]],
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
}

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
