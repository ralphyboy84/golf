<?php

function build_select_box($region, $label)
{
    $options = "";

    $count = 0;

    foreach ($region as $key => $properties) {
        //if (isset($properties["bookingSystem"])) {
        $count++;

        if (isset($properties["courses"])) {
            foreach ($properties["courses"] as $name => $course) {
                $options .= "<option value='{$key}' data-onlineBooking={$properties["onlineBooking"]} data-bookingSystem={$properties["bookingSystem"]} data-courseId={$course["courseId"]} data-openBooking={$properties["openBooking"]}>{$properties["name"]} - $name</option>";
            }
        } else {
            $courseId = "";

            if (isset($properties["courseId"])) {
                $courseId = " data-courseId={$properties["courseId"]}";
            }

            $options .= "<option value='{$key}' data-onlineBooking={$properties["onlineBooking"]} data-bookingSystem={$properties["bookingSystem"]}$courseId data-openBooking={$properties["openBooking"]}>{$properties["name"]}</option>";
        }
        //}
    }

    echo "$count <br />";

    return "<select multiple='multiple' id='dropDown" .
        str_replace(" ", "", $label) .
        "' style='height:300px'>$options</select>";
}

$masters = [
    "strathmore",
    "harburn",
    "golspie",
    "lanark",
    "stonehaven",
    "burntisland",
    "largs",
    "broomieknowe",
    "inverurie",
    "pumpherston",
    "cameronhouse",
    "elgin",
    "ralston",
    "kirriemuir",
    "kirkhill",
    "longniddry",
    "dunfermline",
    "buchanancastle",
    "muckhart",
    "dumfriesandgalloway",
    "cawder",
    "levenlinks",
    "elderslie",
    "royalmusselburgh",
    "brechin",
    "bishopbriggs",
    "erskine",
    "roxburghe",
    "speybay",
    "carnwath",
    "ballochmyle",
    "southerness",
    "clober",
    "nairn",
    "dunblanenew",
    "peterhead",
    "crudenbay",
    "newmachar",
    "turnhouse",
    "alyth",
    "downfield",
    "auchterarder",
    "haggscastle",
    "deeside",
    "eastren",
    "baberton",
];
