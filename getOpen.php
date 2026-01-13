<?php

header("Content-Type: application/json; charset=utf-8");

require_once "courses.php";

$openCompetitionInfo = [];

if ($golfCourses[$_GET["club"]]["bookingSystem"] == "clubv1") {
} elseif ($golfCourses[$_GET["club"]]["bookingSystem"] == "brs") {
    require_once "call/brsCall.php";
    require_once "processor/brsProcessor.php";

    $BRSCall = new BRSCall();
    $BRSProcessor = new BRSProcessor();

    $opens = $BRSCall->getOpens($_GET["club"]);
    $opensOfType = $BRSProcessor->getOpenTypes($opens, false);

    $openField = $BRSCall->checkOpenAvailability(
        $_GET["club"],
        $opensOfType[0]["competition_id"],
    );

    $openCompetitionInfo = $BRSProcessor->processOpenCompetition(
        $openField,
        $golfCourses[$_GET["club"]]["bookingLink"],
    );
}

echo json_encode($openCompetitionInfo);
