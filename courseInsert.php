<?php

require_once "api/courses.php";

$mysqli = new mysqli("database", "root", "", "golf");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "Connected successfully<br /><br />";

foreach ($golfCourses as $key => $course) {
    if ($course["bookingSystem"] == "dotgolf") {
        $sql = "
        UPDATE clubs SET clubId = {$course["clubId"]} WHERE id = '$key'
        ";

        echo $sql . "<br />";
        //$mysqli->query($sql);
    }
}
