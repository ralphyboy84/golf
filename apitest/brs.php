<?php

require_once "../call/brsCall.php";
require_once "../processor/brsProcessor.php";

$BRSCall = new BRSCall();
$BRSProcessor = new BRSProcessor();

$opens = $BRSCall->getAllOpensForCourse("lundingc");
$openOnDay = $BRSProcessor->checkForOpenOnDay($opens, "2026-05-23");

echo "<pre>";

print_r(json_decode($opens, true));
print_r($openOnDay);

$openField = $BRSCall->checkOpenAvailability(
    "lundingc",
    $openOnDay["competitionId"],
);
print_r(json_decode($openField, true));
