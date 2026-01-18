Set trip start date:
<input
  type="date"
  id="start"
  value="2026-01-17"
  min="2026-01-01"
  max="2028-07-22" /><br /><br />

 Number of days:
  <input type='number' id='days' name='days' min='1'  value='1' /><br /><br />
   Where are you staying?
  <input type='text' id='staying' name='staying'  value='Dornoch' /><br /><br />
   Where are you flying in from?
  <input type='text' id='flying' name='days' value='Inverness' /><br /><br />
  <table>
    <tr>
        <td style='vertical-align:top'>
<?php
require_once "courses.php";
require_once "index-lib.php";

$regions = [
    "angus",
    "fife",
    "highlands",
    "ayrshire",
    "islands",
    "aberdeen",
    "eastlothian",
];

foreach ($regions as $region) {
    $$region = get_courses_for_area($region, $golfCourses);
}

$scotlandSelect = build_select_box($golfCourses, "Scotland");

echo "Scotland Golf Trip<br />$scotlandSelect<br /><br /><button onclick='findTrip(\"dropDownScotland\")'>Find Scotland Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

// $angusSelect = build_select_box($angus, "Angus");

// echo "<td>Angus Golf Trip<br />$angusSelect<br /><br /><button onclick='findTrip(\"dropDownAngus\")'>Find Angus Trip</button></td>";
// echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

// $fifeSelect = build_select_box($fife, "Fife");

// echo "<td>Fife Golf Trip<br />$fifeSelect<br /><br /><button onclick='findTrip(\"dropDownFife\")'>Find Fife Trip</button></td>";

// echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

// $highlandsSelect = build_select_box($highlands, "Highlands");

// echo "<td style='vertical-align:top'>Highlands Golf Trip<br />$highlandsSelect<br /><br /><button onclick='findTrip(\"dropDownHighlands\")'>Find Highlands Trip</button></td>";
// echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$highlandsSelect = build_select_box($eastlothian, "EastLothian");

echo "<td style='vertical-align:top'>East Lothian Golf Trip<br />$highlandsSelect<br /><br /><button onclick='findTrip(\"dropDownEastLothian\")'>Find East Lothian Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

// $ayrshireSelect = build_select_box($ayrshire, "Ayrshire");

// echo "<td>Ayrshire Golf Trip<br />$ayrshireSelect<br /><br /><button onclick='findTrip(\"dropDownAyrshire\")'>Find Ayrshire Trip</button></td>";
// echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

// $islandsSelect = build_select_box($islands, "WesternIslands");

// echo "<td>Western Islands Golf Trip<br />$islandsSelect<br /><br /><button onclick='findTrip(\"dropDownWesternIslands\")'>Find Western Islands Trip</button></td>";
// echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

// $aberdeenSelect = build_select_box($aberdeen, "Aberdeen");

// echo "<td>Aberdeen Golf Trip<br />$aberdeenSelect<br /><br /><button onclick='findTrip(\"dropDownAberdeen\")'>Find Aberdeen Trip</button></td>";
//

// $masters = get_courses_from_array($masters, $golfCourses);

// $mastersSelect = build_select_box(
//     $masters,
//     "Golf in Scotland Masters Texas Scramble",
// );

// echo "<td colspan='3'><br />Golf in Scotland Masters Texas Scramble<br />$mastersSelect<br /><br /><button onclick='findOpens(\"texasScramble\")'>Find Masters Scramble</button></td>";
?></td><td style='vertical-align:top'>

    <div id='loadingDiv'></div>
    <div id='divToPopulate'></div>

</td><td style='vertical-align:top' id='travelInfo'>


</td></tr></table>


<script src="script.js"></script>