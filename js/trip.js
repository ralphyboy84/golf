async function getCoursesForLocationDropDown() {
  let courses = await fetch(`../api/getCourses.php?location=1`).then((res) =>
    res.json(),
  );

  const select = document.getElementById("whereStaying");

  let selectedValue;

  // Loop through the object and add options
  for (const key in courses) {
    if (courses.hasOwnProperty(key)) {
      const option = document.createElement("option");
      option.value = key; // key as value
      option.textContent = courses[key].name; // display name
      option.setAttribute("data-lat", courses[key].location.lat || "");
      option.setAttribute("data-lon", courses[key].location.lon || "");

      if (key == "levenlinks") {
        selectedValue = "levenlinks";
      }

      select.appendChild(option);
    }
  }

  if (selectedValue !== null) {
    select.value = selectedValue;
  }
}

getCoursesForLocationDropDown();

async function buildMyTrip() {
  const select = document.getElementById("whereStaying");
  const selectedOption = select.options[select.selectedIndex];
  const lat = selectedOption.getAttribute("data-lat");
  const lon = selectedOption.getAttribute("data-lon");

  const courseType = document.getElementById("courseType");
  const courseTypeOption = courseType.options[courseType.selectedIndex];

  const courseQuality = document.getElementById("courseQuality");
  const courseQualityOption =
    courseQuality.options[courseQuality.selectedIndex];

  const travelDistance = document.getElementById("travelDistance");
  const travelDistanceOption =
    travelDistance.options[travelDistance.selectedIndex];

  document.getElementById("resultsDiv").innerHTML =
    "Please wait.... loading....";

  let courses = await fetch(
    `../api/getCourses.php?lat=${lat}&lon=${lon}&courseTypeOption=${courseTypeOption.value}&courseQualityOption=${courseQualityOption.value}&travelDistanceOption=${travelDistanceOption.value}&onlineBooking=Yes`,
  ).then((res) => res.json());

  const results = {};

  if (Object.keys(courses).length < document.getElementById("days").value) {
    document.getElementById("resultsDiv").innerHTML =
      "Not enough courses have been returned to build your trip. Try shortening your trip or expanding your criteria";
    return;
  }

  const totalApiCalls =
    Object.keys(courses).length * document.getElementById("days").value;

  let percentage;
  let otherCount = 0;

  for (let x in courses) {
    let count = 0;
    const fetchPromises = [];
    for (let y = 0; y < document.getElementById("days").value; y++) {
      const date = addDays(document.getElementById("startDate").value, count);
      count++;
      otherCount++;
      const fetchPromise = fetch(
        `api/getCourseAvailabilityForDate.php?club=${x}&date=${date}&courseId=${courses[x].courseId}`,
      ).then((res) => res.json());
      fetchPromises.push(fetchPromise);
    }
    // Wait for all fetches for this x to complete
    results[x] = await Promise.all(fetchPromises);

    percentage = (otherCount / totalApiCalls) * 100;

    document.getElementById("resultsDiv").innerHTML =
      `Please wait.... loading.... ${percentage}% complete`;
  }

  const div = document.getElementById("resultsDiv");
  let table;
  let row;
  let cell;
  let headerAdded;

  table = document.createElement("table");

  for (x in results) {
    if (!headerAdded) {
      headerAdded = true;
      // Create table element
      table.border = "1"; // optional, for visibility

      // Create a row
      row = document.createElement("tr");

      cell = document.createElement("th");
      cell.textContent = "Course";
      row.appendChild(cell);

      // Create cells
      for (let y in results[x]) {
        cell = document.createElement("th");
        cell.style.border = "1px solid black";
        cell.textContent = results[x][y].date;
        row.appendChild(cell);
      }

      // Append row to table
      table.appendChild(row);
    }

    // Create a row
    row = document.createElement("tr");

    cell = document.createElement("td");
    cell.style.border = "1px solid black";

    cell.textContent = results[x][0].courseName;
    row.appendChild(cell);

    // Create cells
    for (let z in results[x]) {
      cell = document.createElement("td");
      cell.style.border = "1px solid black";
      cell.innerHTML = formatCell(results[x][z]);

      if (cell.innerHTML == "Availability: No") {
        cell.style.backgroundColor = "red";
      }

      row.appendChild(cell);
    }

    // Append row to table
    table.appendChild(row);
  }

  document.getElementById("resultsDiv").innerHTML = "";
  // Append table to div
  div.appendChild(table);

  const unavailable = {};

  // Loop through the data
  for (const key in results) {
    const allNo = results[key].every(
      (entry) => entry.teeTimesAvailable === "No",
    );
    if (allNo) {
      unavailable[key] = results[key]; // Move to unavailable
      delete results[key]; // Remove from original
    }
  }

  const length = Object.keys(results).length;

  if (Object.keys(results).length == document.getElementById("days").value) {
    const newResults = doTheHardBit(results);

    let resultString = "";

    for (let a in newResults) {
      resultString += `${newResults[a].date}: ${newResults[a].course}<br />`;
    }

    diaryDiv = document.createElement("div");
    diaryDiv.innerHTML = `
    Based on the information you have provided us, we have designed the following trip for you<br /><br />
    ${resultString}
    `;
    div.appendChild(diaryDiv);
  } else if (
    Object.keys(results).length > document.getElementById("days").value
  ) {
    document.getElementById("resultsDiv").innerHTML +=
      "Too many courses have been returned to build your trip. Try extending your trip or narrowing your criteria";
  } else if (
    Object.keys(results).length < document.getElementById("days").value
  ) {
    document.getElementById("resultsDiv").innerHTML +=
      "Not enough courses have been returned to build your trip. Try shortening your trip or expanding your criteria";
  }
}

function formatCell(data) {
  if (data.teeTimesAvailable == "No") {
    return `Availability: No`;
  }

  return `
  Availability: ${data.teeTimesAvailable}<br />
  First Tee Time: ${data.firstTime}<br />
  Cheapest Price: ${data.cheapestPrice}
  `;
}
