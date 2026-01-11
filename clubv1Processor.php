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
                " and has $teeTimes starting from $firstTeeSet starting from £{$uniqueFees[0]} - to book a tee time <a href=\"https://$club.hub.clubv1.com/Visitors/TeeSheet?date=$date\" target=\"_blank\">click here</a>";
        } else {
            return "No tee times available at $club on " .
                $this->_format_date($date);
        }
    }

    private function _format_date($date)
    {
        $args = explode("-", $date);
        return $args[2] . "/" . $args[1] . "/" . $args[0];
    }
}
