async function findTrip() {
  var selectBoxValues = getSelectValues(document.getElementById("clubsSelect"));

  if (!selectBoxValues.length) {
    document.getElementById("loadingDiv").innerHTML =
      "You have not selected any courses";
    return;
  }

  const courseLimit = 5;

  if (selectBoxValues.length > courseLimit) {
    alert(
      `Sorry you can only search for a maximum of ${courseLimit} courses just now`,
    );
    return;
  }

  document.getElementById("resultsDiv").innerHTML = "";

  for (let x in selectBoxValues) {
    const parent = document.getElementById("resultsDiv");

    // 2. Create a new child div
    const child = document.createElement("div");
    child.id = selectBoxValues[x].course;

    // 3. Set some content for the child
    child.textContent = "Please wait.... loading.....";

    // 4. Optionally add styles or attributes
    child.classList.add("col-sm-12");
    child.classList.add("col-md-4");
    // child.style.marginTop = "10px";
    // child.style.padding = "5px";

    // 5. Append the child div to the parent div
    parent.appendChild(child);
  }

  const tripStart = document.getElementById("start").value;

  // Usage
  // fetchAllResults(selectBoxValues, tripStart).then((allResults) => {
  //   Object.entries(allResults).forEach(([course, messages]) => {
  //     messages.forEach((msg) => {
  //       document.getElementById(course).innerHTML +=
  //         displayContent(msg) + "<br />";
  //     });

  //     document.getElementById(course).innerHTML += "<br />";
  //   });
  // });

  let coruseList = [];

  for (let x in selectBoxValues) {
    coruseList.push(selectBoxValues[x].course);
  }

  const whereStaying = await getWhereStayingLatLong();
  const info = await fetch(
    `map/getDistance.php?from=${whereStaying}&to=${coruseList}`,
  ).then((res) => res.json());

  fetchAllResults2(selectBoxValues, tripStart, info);

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

async function fetchAllResults2(selectBoxValues, tripStart, travelInfo) {
  const results = {};

  for (let x in selectBoxValues) {
    let count = 0;

    for (let y = 0; y < document.getElementById("days").value; y++) {
      const date = addDays(tripStart, count);
      count++;

      fetch(
        `api/getCourseAvailabilityForDate.php?club=${selectBoxValues[x].course}&date=${date}&courseId=${selectBoxValues[x].courseId}`,
      )
        .then((res) => res.json())
        .then(
          (fetchPromise) =>
            (document.getElementById(selectBoxValues[x].course).innerHTML =
              displayContent(
                fetchPromise,
                travelInfo,
                selectBoxValues[x].course,
              )) + "<br />",
        );
    }
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

function displayContent(msg, travelInfo, courseId) {
  let temp = "";
  let timesAvailable = "";
  let openText = "";
  let openTimesAvailable = "";

  if (msg.onlineBooking == "No") {
    temp = `Unfortunately, Online Booking is not available but they do allow visitors on this day`;
  }

  if (msg.teeTimesAvailable == "Yes") {
    temp = "Good news! There are tee times available on this day";

    timesAvailable = returnCardList(
      msg.cheapestPrice,
      "Prices Starting From",
      "bi-currency-pound",
    );
    timesAvailable += returnCardList(
      msg.firstTime,
      "First Tee Time",
      "bi-alarm",
    );
    timesAvailable += returnCardList(
      msg.timesAvailable,
      "Available Slots",
      "bi-balloon",
    );

    let driveTime = "Currently Unavailable";

    if (travelInfo[courseId]) {
      driveTime = travelInfo[courseId];
    }

    timesAvailable += returnCardList(
      driveTime,
      "Drive to Course",
      "bi-car-front",
    );

    if (msg.openBookingUrl) {
      openText = `
      <br /><br /><p class="card-text">There is also an Open Competition on this day</p>
      `;

      openText += returnCardList(
        msg.openGreenFee,
        "Open Entry Fee",
        "bi-currency-pound",
      );

      openText += returnCardList(
        msg.slotsAvailable,
        "Available Slots",
        "bi-balloon",
      );

      openText += `<a href="${msg.openBookingUrl}" class="btn btn-primary" target="_blank">Click here for more info</a>`;
    }
  } else if (!temp) {
    temp = "Sorry - there are no tee times available on this day";
  }

  return `
    <div class="card">
      <div class="card-header">
      ${msg.date}
      </div>
      <div class="card-body">
        <h5 class="card-title">${msg.courseName}</h5>
        <p class="card-text">${temp}</p>
        ${timesAvailable}
        <a href="${msg.bookingUrl}" class="btn btn-primary" target="_blank">Click here for more info</a>
        ${openText}
      </div>
    </div>
    <br />
  `;
}

function returnCardList(title, message, icon) {
  return `
    <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true"> 

      <i class="bi ${icon}"></i>
      <div class="d-flex gap-2 w-100 justify-content-between"> 
        <div> 
          <h6 class="mb-0">${title}</h6> 
          <p class="mb-0 opacity-75">${message}</p> 
        </div> 
      </div> 
    </a>
    `;
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

async function getCoursesForDropDown(region) {
  let courses = await fetch(`../api/getCourses.php?region=${region}`).then(
    (res) => res.json(),
  );

  document.getElementById("clubsSelect").innerHTML = "";

  const select = document.getElementById("clubsSelect");

  console.log(Object.keys(courses).length);

  // Loop through the object and add options
  for (const key in courses) {
    if (courses.hasOwnProperty(key)) {
      if (courses[key].courses) {
        for (const [key2, value] of Object.entries(courses[key].courses)) {
          const option = document.createElement("option");
          option.value = key; // key as value
          option.textContent = courses[key].name + " - " + key2; // display name
          option.setAttribute("data-courseId", value.courseId || "");
          select.appendChild(option);
        }
      } else {
        const option = document.createElement("option");
        option.value = key; // key as value
        option.textContent = courses[key].name; // display name
        option.setAttribute("data-courseId", courses[key].courseId || "");
        select.appendChild(option);
      }
    }
  }
}

async function getRegionsForDropDrown() {
  let courses = await fetch(`../api/getRegions.php`).then((res) => res.json());

  console.log(courses);

  const select = document.getElementById("regionSelect");

  // Loop through the object and add options
  for (let key in courses) {
    const option = document.createElement("option");
    option.value = courses[key]; // key as value
    option.textContent = capitalizeFirstChar(courses[key]); // display name
    select.appendChild(option);
  }
}

async function loadPage() {
  await getRegionsForDropDrown();
  await getCoursesForDropDown();
  loadSelectBoxes();
}

loadPage();

async function getWhereStayingLatLong() {
  return;
  const params = new URLSearchParams({
    q: document.getElementById("staying").value,
    max: 10,
  });

  return await fetch("https://api.geodojo.net/locate/find?" + params)
    .then((response) => response.json())
    .then((data) => data.result[0].latlng);
}

function capitalizeFirstChar(str) {
  if (!str) return ""; // handle empty string
  return str.charAt(0).toUpperCase() + str.slice(1);
}

async function updateCourseList() {
  var region = getSelectValues(document.getElementById("regionSelect"));

  let regionArray = [];

  for (let x in region) {
    regionArray.push(region[x].course);
  }

  await getCoursesForDropDown(regionArray);
  $("#multiple-checkboxes, #regionSelect, #clubsSelect").multiselect("destroy");
  loadSelectBoxes();
}
