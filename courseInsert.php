<?php

require_once "api/oldcourses.php";

$mysqli = new mysqli("database", "root", "", "golf");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// echo "Connected successfully<br /><br />";

foreach ($golfCourses as $key => $course) {
    if ($course["bookingSystem"] == "intelligent") {
        $sql = "
        UPDATE clubs SET baseUrl = '{$course["baseUrl"]}' WHERE id = '$key';
        ";

        echo $sql . "<br />";
        $mysqli->query($sql);
    }
}
