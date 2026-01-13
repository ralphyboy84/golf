<?php

class BRSProcessor
{
    public function processTeeTime($club, $json, $info)
    {
        $data = json_decode($json, true);

        if (isset($data["message"]) && !empty($data["message"])) {
            return [
                "teeTimesAvailable" => "No",
            ];
        }

        if ($data["data"]["tee_times"]) {
            $x = sizeof($data["data"]["tee_times"]);
            $start = $data["data"]["tee_times"][0]["time"];

            foreach ($data["data"]["tee_times"] as $teeTime) {
                $greenFees[] = $this->_get_green_fee($teeTime["green_fees"]);
            }

            $uniqueFees = array_unique($greenFees);
            sort($uniqueFees);

            return [
                "date" => $this->_format_date($data["data"]["tee_date"]),
                "teeTimesAvailable" => "Yes",
                "timesAvailable" => $x,
                "firstTime" => $start,
                "cheapestPrice" => $uniqueFees[0],
            ];
        } else {
            return [
                "date" => $this->_format_date($data["data"]["tee_date"]),
                "teeTimesAvailable" => "No",
            ];
        }
    }

    public function checkForOpenOnDay($opens, $date)
    {
        $data = json_decode($opens, true);

        $openFlag = false;
        $greenFee = false;
        $availableDate = false;

        if (isset($data["data"])) {
            foreach ($data["data"] as $open) {
                if ($open["date"] == $date) {
                    $openFlag = $open["competition_id"];
                    $greenFee = $open["visitor_green_fee"];
                    $availableDate = $open["available_date"];
                }
            }
        }

        if ($openFlag) {
            return [
                "competitionId" => $openFlag,
                "openGreenFee" => $greenFee,
                "bookingsOpenDate" => $availableDate,
            ];
        }

        return [];
    }

    public function processOpenCompetition($entryList, $bookingUrl)
    {
        $data = json_decode($entryList, true);

        $available = "No";

        if (isset($data["data"]["tee_times"])) {
            foreach ($data["data"]["tee_times"] as $teeTime) {
                foreach ($teeTime["slots"] as $slot) {
                    if ($slot["status"] == "Available") {
                        $available = "Yes";
                    }
                }
            }
        }

        return [
            "slotsAvailable" => $available,
            "openBookingUrl" => $bookingUrl,
        ];
    }

    public function getOpenTypes($opens, $types)
    {
        $opens = json_decode($opens, true);

        $returnArray = [];

        foreach ($opens["data"] as $open) {
            if (
                $open["type"] == "4 Player Teams" &&
                str_contains($open["name"], "Masters")
            ) {
                $returnArray[] = $open;
            }
        }

        return $returnArray;
    }

    private function _get_green_fee($fees)
    {
        return $fees[0]["green_fee1_ball"];
    }

    private function _format_date($date)
    {
        $args = explode("-", $date);
        return $args[2] . "/" . $args[1] . "/" . $args[0];
    }
}
