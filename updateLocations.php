<?php

$SERVERNAME = "database";
$USERNAME = "root";
$PASSWORD = "";
$DATABASE = "golf";

$mysqli = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE);

$content = file_get_contents("locations.txt");
$lines = preg_split("/\r\n|\n|\r/", $content);

foreach ($lines as $course) {
    $args = explode(",", $course);

    $sql = "
    UPDATE clubs SET
    lat = '{$args[2]}',
    lon = '{$args[3]}'
    WHERE id = '{$args[0]}'
    ";

    $mysqli->query($sql);

    echo $sql . "<br />";
}
