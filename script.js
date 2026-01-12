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
    document.getElementById("loadingDiv").innerHTML = "";

    Object.entries(allResults).forEach(([course, messages]) => {
      document.getElementById("divToPopulate").innerHTML += course + "<br />";

      messages.forEach((msg) => {
        document.getElementById("divToPopulate").innerHTML += msg + "<br />";
      });

      document.getElementById("divToPopulate").innerHTML += "<br />";
    });
  });
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
        `ajax.php?club=${selectBoxValues[x].course}&bookingSystem=${selectBoxValues[x].bookingSystem}&date=${date}&courseId=${selectBoxValues[x].courseId}`,
      ).then((res) => res.text());

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

    if (opt.selected && opt.getAttribute("data-onlineBooking") == "Yes") {
      result.push({
        course: opt.value,
        bookingSystem: opt.getAttribute("data-bookingSystem"),
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
