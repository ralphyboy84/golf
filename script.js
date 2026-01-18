async function findTrip() {
  var selectBoxValues = getSelectValues(document.getElementById("clubsSelect"));

  if (!selectBoxValues.length) {
    document.getElementById("loadingDiv").innerHTML =
      "You have not selected any courses";
    return;
  }

  document.getElementById("resultsDiv").innerHTML = "";

  for (let x in selectBoxValues) {
    const parent = document.getElementById("resultsDiv");

    // 2. Create a new child div
    const child = document.createElement("div");
    child.id = selectBoxValues[x].course;

    // 3. Set some content for the child
    child.textContent = selectBoxValues[x].courseName;

    // 4. Optionally add styles or attributes
    child.style.backgroundColor = "lightblue";
    child.style.marginTop = "10px";
    child.style.padding = "5px";

    // 5. Append the child div to the parent div
    parent.appendChild(child);
  }

  const tripStart = document.getElementById("start").value;

  // Usage
  fetchAllResults(selectBoxValues, tripStart).then((allResults) => {
    Object.entries(allResults).forEach(([course, messages]) => {
      messages.forEach((msg) => {
        document.getElementById(course).innerHTML +=
          displayContent(msg) + "<br />";
      });

      document.getElementById(course).innerHTML += "<br />";
    });
  });

  const info = await fetch(
    `map/getDistance.php?from=Inverness&to=Dornoch`,
  ).then((res) => res.text());

  // document.getElementById("travelInfo").innerHTML = "";
  // document.getElementById("travelInfo").innerHTML += info + "<br />";

  // const info2 = await fetch(
  //   `map/getDistance.php?from=Dornoch&to=Golspie,Tain`,
  // ).then((res) => res.text());

  // document.getElementById("travelInfo").innerHTML += info2 + "<br />";
}

async function fetchAllResults(selectBoxValues, tripStart) {
  const results = {};

  for (let x in selectBoxValues) {
    let count = 0;
    const fetchPromises = [];

    for (let y = 0; y < document.getElementById("days").value; y++) {
      const date = addDays(tripStart, count);
      count++;

      const fetchPromise = fetch(
        `api/getCourseAvailabilityForDate.php?club=${selectBoxValues[x].course}&date=${date}&courseId=${selectBoxValues[x].courseId}`,
      ).then((res) => res.json());

      fetchPromises.push(fetchPromise);
    }

    // Wait for all fetches for this x to complete
    results[selectBoxValues[x].course] = await Promise.all(fetchPromises);
  }

  return results;
}

function getSelectValues(select) {
  var result = [];
  var options = select && select.options;
  var opt;

  for (var i = 0, iLen = options.length; i < iLen; i++) {
    opt = options[i];

    if (
      opt.selected
      // &&
      // (opt.getAttribute("data-onlineBooking") == "Yes" ||
      //   opt.getAttribute("data-openBooking") == "Yes")
    ) {
      result.push({
        course: opt.value,
        courseName: opt.text,
        courseId: opt.getAttribute("data-courseId") || 1,
      });
    }
  }

  return result;
}

function addDays(date, days) {
  var result = new Date(date).getTime() + 86400000 * days;
  const tomorrow = new Date(result);
  let month = tomorrow.getMonth() + 1;

  if (month < 10) {
    month = "0" + month;
  }

  let day = tomorrow.getDate();

  if (day < 10) {
    day = "0" + day;
  }

  return tomorrow.getFullYear() + "-" + month + "-" + day;
}

function displayContent(msg) {
  let string = "";

  for (const [key, value] of Object.entries(msg)) {
    string += `${key}: ${value}<br />`;
  }

  return string;
}

function findOpens(openType) {
  const selectVals = getSelectValues(
    document.getElementById("dropDownGolfinScotlandMastersTexasScramble"),
  );

  findOpenForDropDown(selectVals);
}

async function findOpenForDropDown(selectBoxValues) {
  const results = {};

  document.getElementById("divToPopulate").innerHTML = "";
  document.getElementById("loadingDiv").innerHTML =
    "Please waiting loading.....";

  for (let x in selectBoxValues) {
    let temp = await fetch(
      `../api/getOpen.php?club=${selectBoxValues[x].course}&courseId=${selectBoxValues[x].courseId}&openType=MastersTexasScramble`,
    ).then((res) => res.json());

    for (let x in temp) {
      document.getElementById("divToPopulate").innerHTML +=
        selectBoxValues[x].course + "<br />";
      document.getElementById("divToPopulate").innerHTML += //temp;
        displayContent(temp[x]) + "<br />";
    }
  }

  document.getElementById("loadingDiv").innerHTML = "";

  return results;
}

async function getCoursesForDropDown() {
  // document.getElementById("dropDownDiv").innerHTML =
  //   "Please wait whilst we load your courses...";

  let courses = await fetch(`../api/getCourses.php?region=highlands`).then(
    (res) => res.json(),
  );

  const select = document.getElementById("clubsSelect");

  // Loop through the object and add options
  for (const key in courses) {
    if (courses.hasOwnProperty(key)) {
      const option = document.createElement("option");
      option.value = key; // key as value
      option.textContent = courses[key].name; // display name
      option.setAttribute("data-courseId", courses[key].courseId || "");
      select.appendChild(option);
    }
  }
}

getCoursesForDropDown();
