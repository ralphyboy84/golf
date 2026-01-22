<?php

require_once "api/courses.php";

foreach ($golfCourses as $key => $course) {
    if ($course["working"] == "No") {
        echo $key . "-" . $course["bookingSystem"];

        if (isset($course["reason"])) {
            echo " - " . $course["reason"];
        }

        echo "<br />";
    }
}
