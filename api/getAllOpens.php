<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../database/database.php";
require_once "../opens/opens.php";

$database = new database();

$opens = new opens();
$allOpens = $opens->getAllOpens($database->getDatabaseConnection());

echo json_encode($allOpens);
