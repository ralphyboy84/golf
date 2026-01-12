<?php

require_once "courses.php";

if ($_GET["bookingSystem"] == "clubv1") {
    require_once "call/clubV1Call.php";
    require_once "processor/clubV1Processor.php";

    $ClubV1Call = new ClubV1Call();
    $response = $ClubV1Call->getTeeTimesForDay($_GET["date"], $_GET["club"]);
    $opens = $ClubV1Call->getOpens(753);

    $ClubV1Processor = new ClubV1Processor();
    echo $ClubV1Processor->processTeeTime(
        $response,
        $_GET["date"],
        $_GET["club"],
    );

    [
        $openInfo,
        $openId,
        $greenFee,
        $availableDate,
        $token,
    ] = $ClubV1Processor->checkForOpenOnDay($opens, $_GET["date"]);
    echo $openInfo;

    if ($openId) {
        $openField = false;
        $openField = $ClubV1Call->checkOpenAvailability($token, $openId);
        echo $ClubV1Processor->processOpenCompetition(
            $openField,
            $availableDate,
            $openId,
            $token,
        );
    }
} elseif ($_GET["bookingSystem"] == "brs") {
    require_once "call/brsCall.php";
    require_once "processor/brsProcessor.php";

    $BRSCall = new BRSCall();
    $teeTimes = $BRSCall->getTeeTimesForDay(
        $_GET["date"],
        $_GET["club"],
        $_GET["courseId"],
    );
    $opens = $BRSCall->getOpens($_GET["club"]);

    $BRSProcessor = new BRSProcessor();
    echo $BRSProcessor->processTeeTime(
        $_GET["club"],
        $teeTimes,
        $golfCourses[$_GET["club"]],
    );

    [
        $openInfo,
        $openId,
        $greenFee,
        $availableDate,
    ] = $BRSProcessor->checkForOpenOnDay($opens, $_GET["date"]);
    echo $openInfo;

    if ($openId) {
        $openField = $BRSCall->checkOpenAvailability($_GET["club"], $openId);
        echo $BRSProcessor->processOpenCompetition($openField, $availableDate);
    }
}
