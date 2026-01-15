<?php

require_once "Processor.php";

class ClubV1Processor extends Processor
{
    public function processTeeTimeForDay($html, $date, $club)
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//*[@class="tees"]')->item(0);

        $innerHTML = "";

        if ($node) {
            foreach ($node->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }
        }

        if ($innerHTML) {
            $tmp = json_encode(simplexml_load_string("<div>$innerHTML</div>"));
            $tmp = json_decode($tmp, true);

            $teeTimes = 0;
            $firstTeeSet = "";

            if (isset($tmp["div"]) && is_array($tmp["div"])) {
                foreach ($tmp["div"] as $xx) {
                    if (
                        isset($xx["@attributes"]["class"]) &&
                        $xx["@attributes"]["class"] == "tee available"
                    ) {
                        $teeTimes++;

                        if (!$firstTeeSet) {
                            $time = $xx["@attributes"]["data-min-val"];

                            if (
                                strlen($xx["@attributes"]["data-min-val"]) == 1
                            ) {
                                $time =
                                    "0" . $xx["@attributes"]["data-min-val"];
                            }

                            $firstTeeSet =
                                $xx["@attributes"]["data-hour-val"] .
                                ":" .
                                $time;
                        }

                        $greenFees[] = str_replace(
                            "£",
                            "",
                            $xx["div"][1]["div"][0]["div"]["div"][0]["div"][1],
                        );
                    }
                }

                $uniqueFees = array_unique($greenFees);
                sort($uniqueFees);

                return [
                    "date" => $this->_format_date($date),
                    "teeTimesAvailable" => "Yes",
                    "timesAvailable" => $teeTimes,
                    "firstTime" => $firstTeeSet,
                    "cheapestPrice" => $uniqueFees[0],
                ];
            }
        }

        return [
            "date" => $this->_format_date($date),
            "teeTimesAvailable" => "No",
        ];
    }

    public function checkForOpenOnDay($opens, $date)
    {
        $competition_id = "";

        if ($opens) {
            foreach ($opens as $open) {
                if ($open["date"] == $this->_format_date($date)) {
                    $competition_id = $open["competition_id"];
                    $greenFee = $open["visitor_green_fee"];
                    $token = $open["token"];
                }
            }
        }

        if ($competition_id) {
            return [
                "competitionId" => $competition_id,
                "openGreenFee" => $greenFee,
                "bookingsOpenDate" => "TBC",
                "token" => $token,
            ];
        }

        return [];
    }

    public function processOpenAvailability($entryList, $openId, $token)
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML(
            $entryList,
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//*[@class="booking"]')->item(0);

        $innerHTML = "";

        if ($node) {
            foreach ($node->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }
        }

        $tmp = json_encode(simplexml_load_string("$innerHTML"));
        $tmp = json_decode($tmp, true);

        $available = "No";

        foreach ($tmp["div"] as $teeTime) {
            if ($teeTime["div"][0] == "Time") {
                continue;
            }

            if (
                isset($teeTime["div"][1]["div"]["span"]) &&
                trim($teeTime["div"][1]["div"]["span"]) == "Available"
            ) {
                $available = "Yes";
            }

            if (
                isset($teeTime["div"][1]["div"][0]) &&
                isset($teeTime["div"][1]["div"]) &&
                is_array($teeTime["div"][1]["div"])
            ) {
                foreach ($teeTime["div"][1]["div"] as $slot) {
                    if (trim($slot["span"]) == "Available") {
                        $available = "Yes";
                    }
                }
            }
        }

        return [
            "slotsAvailable" => $available,
            "openBookingUrl" => "https://howdidido-whs.clubv1.com/hdidbooking/open?token=$token&cid=$openId&rd=1",
        ];
    }

    public function getOpenOfType($opens, $type)
    {
        $returnArray = [];
        $typeArray = [
            "MastersTexasScramble" => [
                "Masters",
                "Masters Texas Scramble",
                "Golf in Scotland Texas Scramble",
            ],
        ];

        foreach ($opens as $open) {
            if (
                $this->_string_contains_array_value(
                    $open["name"],
                    $typeArray[$type],
                )
            ) {
                $returnArray[] = $open;
            }
        }

        return $returnArray;
    }
}
