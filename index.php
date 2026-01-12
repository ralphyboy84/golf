Set trip start date:
<input
  type="date"
  id="start"
  value="2026-03-28"
  min="2026-01-01"
  max="2028-07-22" /><br /><br />

 Number of days:
  <input type='number' id='days' name='days' min='1'  value='1' /><br /><br />
  <table>
    <tr>
        <td>
<?php
require_once "courses.php";

$regions = ["angus", "fife", "highlands", "ayrshire", "islands", "aberdeen"];

foreach ($regions as $region) {
    $$region = get_courses_for_area($region, $golfCourses);
}

$scotlandSelect = build_select_box($golfCourses, "Scotland");

echo "Scotland Golf Trip<br />$scotlandSelect<br /><br /><button onclick='findTrip(\"dropDownScotland\")'>Find Scotland Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$angusSelect = build_select_box($angus, "Angus");

echo "<td>Angus Golf Trip<br />$angusSelect<br /><br /><button onclick='findTrip(\"dropDownAngus\")'>Find Angus Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$fifeSelect = build_select_box($fife, "Fife");

echo "<td>Fife Golf Trip<br />$fifeSelect<br /><br /><button onclick='findTrip(\"dropDownFife\")'>Find Fife Trip</button></td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$highlandsSelect = build_select_box($highlands, "Highlands");

echo "<td>Highlands Golf Trip<br />$highlandsSelect<br /><br /><button onclick='findTrip(\"dropDownHighlands\")'>Find Highlands Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$ayrshireSelect = build_select_box($ayrshire, "Ayrshire");

echo "<td>Ayrshire Golf Trip<br />$ayrshireSelect<br /><br /><button onclick='findTrip(\"dropDownAyrshire\")'>Find Ayrshire Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$islandsSelect = build_select_box($islands, "WesternIslands");

echo "<td>Western Islands Golf Trip<br />$islandsSelect<br /><br /><button onclick='findTrip(\"dropDownWesternIslands\")'>Find Western Islands Trip</button></td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

$aberdeenSelect = build_select_box($aberdeen, "Aberdeen");

echo "<td>Aberdeen Golf Trip<br />$aberdeenSelect<br /><br /><button onclick='findTrip(\"dropDownAberdeen\")'>Find Aberdeen Trip</button></td>";
?></tr></table>


<script src="script.js"></script>
    <br /><br />
    <div id='loadingDiv'></div>
    <div id='divToPopulate'>
</div>