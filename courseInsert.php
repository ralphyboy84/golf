<?php

$mysqli = new mysqli("database", "root", "", "golf");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM clubs WHERE lat = '0.000000'";
$result = $mysqli->query($sql);

echo "<pre>";

$noInfo = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $q = urlencode($row["name"] . "");

        $ch = curl_init("https://api.geodojo.net/locate/find?q=$q&max=10");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // important to capture response
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
        $server_output = curl_exec($ch);

        $args = json_decode($server_output, true);
        $lat = "";
        $lon = "";

        print_r($args);

        if (isset($args["result"])) {
            foreach ($args["result"] as $x) {
                if (
                    $x["type"] == "golf-course" ||
                    $x["type"] == "address-centre"
                ) {
                    $latlng = explode(" ", $x["latlng"]);

                    $lat = $latlng[0];
                    $lon = $latlng[1];
                } else {
                    $noInfo[] = $row["id"];
                }
            }
        } else {
            $noInfo[] = $row["id"];
        }

        if ($lat) {
            $sql = "
            UPDATE clubs SET lat = '$lat', lon = '$lon' WHERE id = '{$row["id"]}'
            ";
            echo $sql . "<br />";
            $mysqli->query($sql);
        }
    }
} else {
    echo "Error: " . $mysqli->error;
}

print_r(array_unique($noInfo));
