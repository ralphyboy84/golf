<?php

require_once "Processor.php";

class CarnoustieProcessor extends Processor
{
    public function processTeeTimeForDay($json, $info, $date)
    {
        $data = json_decode($json, true);
        print_r($data);
        return [];

        // if (isset($data["message"]) && !empty($data["message"])) {
        //     return [
        //         "teeTimesAvailable" => "No",
        //         "date" => $this->_format_date($date),
        //     ];
        // }

        // if ($data["data"]["tee_times"]) {
        //     $x = sizeof($data["data"]["tee_times"]);
        //     $start = $data["data"]["tee_times"][0]["time"];

        //     foreach ($data["data"]["tee_times"] as $teeTime) {
        //         $greenFees[] = $this->_get_green_fee($teeTime["green_fees"]);
        //     }

        //     $uniqueFees = array_unique($greenFees);
        //     sort($uniqueFees);

        //     return [
        //         "date" => $this->_format_date($date),
        //         "teeTimesAvailable" => "Yes",
        //         "timesAvailable" => $x,
        //         "firstTime" => $start,
        //         "cheapestPrice" => $uniqueFees[0],
        //     ];
        // } else {
        //     return [
        //         "date" => $this->_format_date($date),
        //         "teeTimesAvailable" => "No",
        //     ];
        // }
    }
}
