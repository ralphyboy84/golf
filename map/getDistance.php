<?php

// Dornoch Station
$dornochStartLat = 57.8812;
$dornochStartLon = -4.0232;

if ($_GET["from"] == "Inverness") {
    // Inverness Airport
    $startLat = 57.543796168503754;
    $startLon = -4.052575827192105;

    $url = "https://api.traveltimeapp.com/v4/time-filter?type=driving&arrival_time=2026-01-20T20:00:00Z&search_lat=$startLat&search_lng=$startLon&locations={$dornochStartLat}_{$dornochStartLon}&app_id=65f59572&api_key=48fae2082ab3ed993535eac4ff353a4d";
} else {
    $locations = [
        // Tain
        0 => [
            "lat" => 57.8144,
            "lon" => -4.03073,
        ],
        // Golspie
        1 => [
            "lat" => 57.9682,
            "lon" => -4.0181,
        ],
    ];

    foreach ($locations as $location) {
        $locationParams[] = $location["lat"] . "_" . $location["lon"];
    }

    $locationString = implode(",", $locationParams);

    $url = "https://api.traveltimeapp.com/v4/time-filter?type=driving&arrival_time=2026-01-20T20:00:00Z&search_lat=$dornochStartLat&search_lng=$dornochStartLon&locations=$locationString&app_id=65f59572&api_key=48fae2082ab3ed993535eac4ff353a4d";
}
$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die("cURL error: " . $error);
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Optional: decode JSON response
$responseData = json_decode($response, true);

if (count($responseData["results"][0]["locations"]) == 1) {
    echo "time from " .
        $_GET["from"] .
        " to " .
        $_GET["to"] .
        " " .
        gmdate(
            "H:i:s",
            $responseData["results"][0]["locations"][0]["properties"][0][
                "travel_time"
            ],
        ) .
        "<br />";
} elseif (count($responseData["results"][0]["locations"]) > 1) {
    $dests = explode(",", $_GET["to"]);

    $x = 0;

    foreach ($responseData["results"][0]["locations"] as $result) {
        echo "time from " .
            $_GET["from"] .
            " to " .
            $dests[$x] .
            " " .
            gmdate("H:i:s", $result["properties"][0]["travel_time"]) .
            "<br />";

        $x++;
    }
}
