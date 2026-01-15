async function findTrip(idToUse) {
  var selectBoxValues = getSelectValues(document.getElementById(idToUse));

  if (!selectBoxValues.length) {
    document.getElementById("loadingDiv").innerHTML =
      "You have not selected any courses";
    return;
  }

  const tripStart = document.getElementById("start").value;

  document.getElementById("loadingDiv").innerHTML =
    "Please waiting loading.....";
  document.getElementById("divToPopulate").innerHTML = "";

  // Usage
  fetchAllResults(selectBoxValues, tripStart).then((allResults) => {
    console.log(allResults);
    document.getElementById("loadingDiv").innerHTML = "";

    Object.entries(allResults).forEach(([course, messages]) => {
      document.getElementById("divToPopulate").innerHTML += course + "<br />";

      messages.forEach((msg) => {
        document.getElementById("divToPopulate").innerHTML +=
          displayContent(msg) + "<br />";
      });

      document.getElementById("divToPopulate").innerHTML += "<br />";
    });
  });

  const info = await fetch(
    `map/getDistance.php?from=Inverness&to=Dornoch`,
  ).then((res) => res.text());

  document.getElementById("travelInfo").innerHTML = "";
  document.getElementById("travelInfo").innerHTML += info + "<br />";

  const info2 = await fetch(
    `map/getDistance.php?from=Dornoch&to=Golspie,Tain`,
  ).then((res) => res.text());

  document.getElementById("travelInfo").innerHTML += info2 + "<br />";
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
    results[selectBoxValues[x].courseName] = await Promise.all(fetchPromises);
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
      opt.selected &&
      (opt.getAttribute("data-onlineBooking") == "Yes" ||
        opt.getAttribute("data-openBooking") == "Yes")
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
