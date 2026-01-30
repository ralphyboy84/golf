<?php

header("Content-Type: application/json; charset=utf-8");

require_once "courses.php";

echo json_encode($golfCourses);
