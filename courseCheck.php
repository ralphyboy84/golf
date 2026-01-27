<?php

$SERVERNAME = "database";
$USERNAME = "root";
$PASSWORD = "";
$DATABASE = "golf";

$mysqli = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE);

$content = file_get_contents("bookingsystems/courselist.txt");
$lines = preg_split("/\r\n|\n|\r/", $content);

foreach ($lines as $course) {
    $sql = "
    SELECT *
    FROM clubs
    WHERE id LIKE '%$course%'
    ";

    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        echo $course . "<br />";
    }
}
