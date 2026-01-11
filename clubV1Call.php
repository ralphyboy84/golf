<?php

require_once "Call.php";

class ClubV1Call extends Call
{
    public function getTeeTimesForDay($date, $club)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36",
        ]);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "https://$club.hub.clubv1.com/Visitors/TeeSheet?date=$date",
        );
        $server_output = curl_exec($ch);
        return preg_replace("/^HTTP\/2\s+200\s.*?\R\R/s", "", $server_output);
    }
}
