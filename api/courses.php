<?php

if ($_SERVER["HTTP_HOST"] == "localhost") {
    //dev settings
    $SERVERNAME = "database";
    $USERNAME = "root";
    $PASSWORD = "";
    $DATABASE = "golf";
} else {
    $SERVERNAME = "localhost";
    $USERNAME = "ralphwar";
    $PASSWORD = "Rdubz1984";
    $DATABASE = "ralphwar_golf";
}

$mysqli = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE);

$sql = "
SELECT *
FROM clubs
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $golfCourses[$row["id"]] = [
            "name" => $row["name"],
            "bookingLink" => $row["bookingLink"],
            "openBookingLink" => $row["openBookingLink"],
            "onlineBooking" => $row["onlineBooking"],
            "openBooking" => $row["openBooking"],
            "bookingSystem" => $row["bookingSystem"],
            "openBookingSystem" => $row["openBookingSystem"],
            "availabilityDays" => format_availability_days(
                $row["availabilityDays"],
            ),
            "region" => $row["region"],
            "working" => $row["working"],
            "location" => [
                "lat" => $row["lat"],
                "lon" => $row["lon"],
            ],
            "courseId" => $row["courseId"],
            "clubId" => $row["clubId"],
            "reason" => $row["reason"],
            "baseUrl" => $row["baseUrl"],
            "clubv1hub" => $row["clubv1hub"],
            "clubv1opencourseid" => $row["clubv1opencourseid"],
            "brsDomain" => $row["brsDomain"],
            "brsCourseId" => $row["brsCourseId"],
        ];

        unset($coursesArray);
    }
}

function format_availability_days($days)
{
    $days = explode(",", $days);

    if ($days && !empty($days[0])) {
        return $days;
    }

    return;
}

uksort($golfCourses, function ($a, $b) {
    return strcasecmp($a, $b); // Compare keys ignoring case
});

function get_course_name($course, $golfCourses, $courseId = false)
{
    if (
        isset($golfCourses[$course]["courses"]) &&
        !empty($golfCourses[$course]["courses"])
    ) {
        foreach ($golfCourses[$course]["courses"] as $name => $data) {
            if ($data["courseId"] == $courseId) {
                $courseName = $name;
                break;
            }
        }

        return $golfCourses[$course]["name"] . " " . $courseName;
    }

    return $golfCourses[$course]["name"];
}

function get_booking_url($courseInfo, $date, $courseId)
{
    if ($courseInfo["bookingSystem"] == "clubv1") {
        return $courseInfo["bookingLink"] . "?date={$date}&courseId=$courseId";
    }

    if ($courseInfo["bookingSystem"] != "dotgolf") {
        return $courseInfo["bookingLink"] . "?date=" . $date;
    }

    return $courseInfo["bookingLink"] .
        "?date=$date&ClubId={$courseInfo["clubId"]}&CourseId=$courseId";
}
