<?php

require_once "courses.php";

$count = 1;
foreach ($golfCourses as $key => $course) {
    if (isset($course["courses"])) {
        foreach ($course["courses"] as $individualCourse => $values) {
            echo $course["name"] . " $individualCourse - $count<br />";
            $count++;
        }
    } else {
        echo $course["name"] . " - $count<br />";
        $count++;
    }
}
