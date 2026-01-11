Set trip start date:
<input
  type="date"
  id="start"
  value="2026-06-13"
  min="2026-01-01"
  max="2028-07-22" /><br /><br />
  <table>
    <tr>
        <td>
<?php
$files = [
    "shiskine",
    "pitlochry",

    "gullane",
    "machrihanishdunes",
    "machrihanish",

    "lundingc",
    "levenlinks",
    "ladybank",
    "dumbarnie",

    "prestwickstnicholas",
    "westkilbride",
    "dundonald",
    "irvine",
    "glasgow",
    "prestwick",
    "royaltroon",

    "monifieth",
    "panmure",
    "montrosegolflinks",
    "downfield",

    "nairngc",
    "fortrose",
    "moray",
    "nairndunbargolf",
    "golspie",
    "tain",

    "peterhead",
    "murcarlinks",
    "crudenbay",

    "eastrenfrewshire",
    "lanark",
];

$angus = ["monifieth", "panmure", "montrosegolflinks", "downfield"];
$fife = ["lundingc", "levenlinks", "ladybank", "dumbarnie"];
$highlands = [
    "nairngc",
    "fortrose",
    "moray",
    "nairndunbargolf",
    "golspie",
    "tain",
];
$ayrshire = [
    "prestwickstnicholas",
    "westkilbride",
    "dundonald",
    "irvine",
    "glasgow",
    "prestwick",
    "royaltroon",
];
$islands = ["shiskine", "machrihanishdunes", "machrihanish"];
$aberdeen = ["peterhead", "murcarlinks", "crudenbay"];

echo "Scotland Golf Trip<br /><select multiple='multiple' id='dropDownScotland' style='height:200px'>";

foreach ($files as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownScotland\")'>Find Scotland Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td>Angus Golf Trip<br /><select multiple='multiple' id='dropDownAngus' style='height:200px'>";

foreach ($angus as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownAngus\")'>Find Angus Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td>Fife Golf Trip<br /><select multiple='multiple' id='dropDownFife' style='height:200px'>";

foreach ($fife as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownFife\")'>Find Fife Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td>Highlands Golf Trip<br /><select multiple='multiple' id='dropDownHighlands' style='height:200px'>";

foreach ($highlands as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownHighlands\")'>Find Highlands Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td>Ayrshire Golf Trip<br /><select multiple='multiple' id='dropDownAyrshire' style='height:200px'>";

foreach ($ayrshire as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownAyrshire\")'>Find Ayrshire Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td>Western Islands Golf Trip<br /><select multiple='multiple' id='dropDownWesternIslands' style='height:200px'>";

foreach ($islands as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownWesternIslands\")'>Find Western Islands Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td>Aberdeen Golf Trip<br /><select multiple='multiple' id='dropDownAberdeen' style='height:200px'>";

foreach ($aberdeen as $file) {
    echo "<option value='$file'>$file</optino>";
}

echo "</select><br /><br />
<button onclick='findTrip(\"dropDownAberdeen\")'>Find Aberdeen Trip</button></td>";
?></tr></table>


<script src="script.js"></script>
    <br /><br />
    <div id='loadingDiv'></div>
    <div id='divToPopulate'>
</div>