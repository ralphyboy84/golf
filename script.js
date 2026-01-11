async function findTrip(idToUse) {
  var e = getSelectValues(document.getElementById(idToUse));

  console.log(e);

  if (!e.length) {
    document.getElementById("loadingDiv").innerHTML =
      "You have not selected any courses";
    return;
  }

  const tripStart = document.getElementById("start").value;

  document.getElementById("loadingDiv").innerHTML =
    "Please waiting loading.....";
  document.getElementById("divToPopulate").innerHTML = "";

  let count = 0;

  for (let x in e) {
    let date = addDays(tripStart, count);
    let content = await fetch("ajax.php?club=" + e[x] + "&date=" + date).then(
      (result) => {
        return result.text();
      },
    );

    document.getElementById("loadingDiv").innerHTML = "";
    document.getElementById("divToPopulate").innerHTML += content + "<br />";
    count++;
  }
}

function getSelectValues(select) {
  var result = [];
  var options = select && select.options;
  var opt;

  for (var i = 0, iLen = options.length; i < iLen; i++) {
    opt = options[i];

    if (opt.selected) {
      result.push(opt.value || opt.text);
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
