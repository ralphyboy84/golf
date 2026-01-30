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

      if (key == "carnoustie") {
        selectedValue = "carnoustie";
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

  document.getElementById("resultsDiv").innerHTML =
    "Please wait.... loading....";

  let courses = await fetch(`../api/getCourses.php?lat=${lat}&lon=${lon}`).then(
    (res) => res.json(),
  );

  const results = {};

  for (let x in courses) {
    let count = 0;
    const fetchPromises = [];
    for (let y = 0; y < document.getElementById("days").value; y++) {
      const date = addDays(document.getElementById("startDate").value, count);
      console.log(date);
      count++;
      const fetchPromise = fetch(
        `api/getCourseAvailabilityForDate.php?club=${x}&date=${date}&courseId=${courses[x].courseId}`,
      ).then((res) => res.json());
      fetchPromises.push(fetchPromise);
    }
    // Wait for all fetches for this x to complete
    results[x] = await Promise.all(fetchPromises);
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
      row.appendChild(cell);
    }

    // Append row to table
    table.appendChild(row);

    console.log(results[x]);
  }

  document.getElementById("resultsDiv").innerHTML = "";
  // Append table to div
  div.appendChild(table);
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
