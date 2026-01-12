<?php

class ClubV1Processor
{
    public function processTeeTime($html, $date, $club)
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//*[@class="tees"]')->item(0);

        if ($node) {
            $innerHTML = "";
            foreach ($node->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }
        }

        if (!$innerHTML) {
            return "No tee times available at $club on " .
                $this->_format_date($date);
        }

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

                        if (strlen($xx["@attributes"]["data-min-val"]) == 1) {
                            $time = "0" . $xx["@attributes"]["data-min-val"];
                        }

                        $firstTeeSet =
                            $xx["@attributes"]["data-hour-val"] . ":" . $time;
                    }

                    $greenFees[] =
                        $xx["div"][1]["div"][0]["div"]["div"][0]["div"][1];
                }
            }

            $uniqueFees = array_unique($greenFees);
            sort($uniqueFees);

            return "$club is available on " .
                $this->_format_date($date) .
                " and has $teeTimes times starting from $firstTeeSet starting from £{$uniqueFees[0]} - to book a tee time <a href=\"https://$club.hub.clubv1.com/Visitors/TeeSheet?date=$date\" target=\"_blank\">click here</a>";
        } else {
            return "No tee times available at $club on " .
                $this->_format_date($date);
        }
    }

    public function checkForOpenOnDay($opens, $date)
    {
        $opens = str_replace("<br />", "", $opens);
        $opens = str_replace('style="height: 60px"', "", $opens);
        $opens = str_replace("Booking closes", "", $opens);
        $opens = str_replace("View Competition", "<div></div>", $opens);
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($opens, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//*[@id="main-content"]')->item(0);

        if ($node) {
            $innerHTML = "";

            foreach ($node->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }
        }

        $tmp = json_encode(simplexml_load_string("$innerHTML"));
        $tmp = json_decode($tmp, true);

        $openFlag = false;
        $greenFee = false;
        $availableDate = false;
        $token = false;

        foreach ($tmp["div"]["div"]["div"] as $open) {
            if (
                trim($open["div"]["div"]["div"][1]["span"][1]) ==
                $this->_format_date($date)
            ) {
                $openFlag = $this->_format_course_id(
                    $open["div"]["div"]["div"][2]["span"][1]["a"][
                        "@attributes"
                    ]["href"],
                );
                $token = $this->_format_token(
                    $open["div"]["div"]["div"][2]["span"][1]["a"][
                        "@attributes"
                    ]["href"],
                );
                $greenFee = $open["div"]["div"]["div"][1]["span"][7];
            }
        }

        if ($openFlag) {
            return [
                " but there is an open on this day which costs $greenFee",
                $openFlag,
                $greenFee,
                $availableDate,
                $token,
            ];
        }
    }

    public function processOpenCompetition(
        $entryList,
        $availableDate,
        $openId,
        $token,
    ) {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML(
            $entryList,
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//*[@class="booking"]')->item(0);

        if ($node) {
            $innerHTML = "";

            foreach ($node->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }
        }

        $tmp = json_encode(simplexml_load_string("$innerHTML"));
        $tmp = json_decode($tmp, true);

        $available = false;

        // echo "<pre>";

        foreach ($tmp["div"] as $teeTime) {
            if ($teeTime["div"][0] == "Time") {
                continue;
            }

            if (
                isset($teeTime["div"][1]["div"]["span"]) &&
                trim($teeTime["div"][1]["div"]["span"]) == "Available"
            ) {
                $available = true;
            }

            if (
                isset($teeTime["div"][1]["div"]) &&
                is_array($teeTime["div"][1]["div"])
            ) {
                foreach ($teeTime["div"][1]["div"] as $slot) {
                    if (trim($slot["span"]) == "Available") {
                        $available = true;
                    }
                }
            }
        }

        if ($available) {
            return " and there are still slots available - <a href=\"https://howdidido-whs.clubv1.com/hdidbooking/open?token=$token&cid=$openId&rd=1\" target=\"_blank\">click here</a> to book this open";
        }

        return " but unfortunately it is fully booked";
    }

    private function _format_date($date)
    {
        $args = explode("-", $date);
        return $args[2] . "/" . $args[1] . "/" . $args[0];
    }

    private function _format_course_id($url)
    {
        preg_match("/[?&]cid=(\d+)/", $url, $matches);
        return $matches[1];
    }

    private function _format_token($url)
    {
        preg_match("/[?&]token=([^&]+)/", $url, $matches);
        return $matches[1];
    }
}
