<?php

class BRSProcessor
{
    public function processTeeTime($club, $json, $info)
    {
        $data = json_decode($json, true);

        if (isset($data["message"]) && !empty($data["message"])) {
            return "Something has gone wrong checking tee times for $club";
        }

        if ($data["data"]["tee_times"]) {
            $x = sizeof($data["data"]["tee_times"]);
            $start = $data["data"]["tee_times"][0]["time"];

            foreach ($data["data"]["tee_times"] as $teeTime) {
                $greenFees[] = $this->_get_green_fee($teeTime["green_fees"]);
            }

            $uniqueFees = array_unique($greenFees);
            sort($uniqueFees);

            return $club .
                " is available on " .
                $this->_format_date($data["data"]["tee_date"]) .
                " and has $x times free starting from $start starting from £{$uniqueFees[0]} - to book a tee time <a href=\"{$info["bookingLink"]}?date=2026-07-12\" target=\"_blank\">click here</a>";
        } else {
            return "No tee times available at $club on " .
                $this->_format_date($data["data"]["tee_date"]);
        }
    }

    public function checkForOpenOnDay($opens, $date)
    {
        $data = json_decode($opens, true);

        $openFlag = false;
        $greenFee = false;
        $availableDate = false;

        if ($data["data"]) {
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
                " but there is an open on this day which costs £$greenFee",
                $openFlag,
                $greenFee,
                $availableDate,
            ];
        }
    }

    public function processOpenCompetition($entryList, $availableDate)
    {
        $data = json_decode($entryList, true);

        $available = false;

        if (
            isset($data["message"]) &&
            $data["message"] == "Competition is not yet available."
        ) {
            return " but the competition is not available for booking until " .
                $this->_format_date($availableDate);
        }

        if (isset($data["data"]["tee_times"])) {
            foreach ($data["data"]["tee_times"] as $teeTime) {
                foreach ($teeTime["slots"] as $slot) {
                    if ($slot["status"] == "Available") {
                        $available = true;
                    }
                }
            }
        }

        if ($available) {
            return " and there are still slots available";
        }

        return " but unfortunately it is fully booked";
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
