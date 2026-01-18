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


<select id='clubsSelect' multiple='multiple' style='height:300px'></select>
<button onclick='findTrip()'>Check Availability</button>
<div id='resultsDiv'></div>
<script src="script.js"></script>