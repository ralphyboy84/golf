let calendar;
let endpoint = "../api/getAllOpens.php";
let eventsCache = []; // will store events after first fetch
let eventsFetched = false;

document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");

  const myEvents = [
    { title: "Club Meeting", start: "2026-02-27" },
    {
      title: "Pro Golf Lesson",
      start: "2026-02-28T14:00:00",
      end: "2026-02-28T15:30:00",
    },
  ];

  let initialView = "dayGridMonth";

  if (window.innerWidth < 600) {
    initialView = "listWeek";
  }

  calendar = new FullCalendar.Calendar(calendarEl, {
    themeSystem: "bootstrap5",
    initialView,
    height: "auto", // lets it fill the parent, but can cause tiny height if empty
    contentHeight: "auto", // similar
    dayMaxEventRows: true, // optional
    lazyFetching: true,
    // Add a minHeight
    viewDidMount: function (info) {
      // set a min height for the listWeek container
      info.el.style.minHeight = "400px"; // adjust as needed
    },
    // events(fetchInfo, success, failure) {
    //   fetch(endpoint)
    //     .then((r) => r.json())
    //     .then(success)
    //     .catch(failure);
    // },
    events: function (fetchInfo, successCallback, failureCallback) {
      if (!eventsFetched) {
        // fetch events from server only once
        fetch(endpoint)
          .then((res) => res.json())
          .then((data) => {
            eventsCache = data; // store them
            eventsFetched = true; // prevent future fetches
            successCallback(eventsCache);
          })
          .catch((err) => failureCallback(err));
      } else {
        // return cached events
        successCallback(eventsCache);
      }
    },
    windowResize: function (view) {
      if (window.innerWidth < 600) {
        calendar.changeView("listWeek"); // switch to list view on mobile
        calendar.setOption("height", "auto");
      } else {
        calendar.changeView("dayGridMonth"); // back to month on desktop
      }
    },
    eventClick: function (info) {
      // If event has a URL
      if (info.event.url) {
        window.open(info.event.url, "_blank"); // opens in new tab
        info.jsEvent.preventDefault(); // prevents default FullCalendar behavior
      }
    },
    loading: function (isLoading) {
      // isLoading is true when fetching starts, false when finished
      var loadingEl = document.getElementById("loading");
      if (isLoading) {
        loadingEl.style.display = "block";
      } else {
        loadingEl.style.display = "none";
      }
    },
  });
  calendar.render();
});

function filterByRegion() {
  let selectBoxValues = getSelectValues(
    document.getElementById("regionSelect"),
  );
  let regions = [];

  for (let x in selectBoxValues) {
    regions.push(selectBoxValues[x].course);
  }

  eventsFetched = false;
  endpoint = `../api/getAllOpens.php?regions=${regions}`;
  calendar.refetchEvents();
}

function filterByCourse() {
  let selectBoxValues = getSelectValues(document.getElementById("clubsSelect"));
  let courses = [];

  for (let x in selectBoxValues) {
    courses.push(selectBoxValues[x].course);
  }

  eventsFetched = false;
  endpoint = `../api/getAllOpens.php?courses=${courses}`;
  calendar.refetchEvents();
}

function filterByTop100() {
  eventsFetched = false;
  endpoint = `../api/getAllOpens.php?top100=1`;
  calendar.refetchEvents();
}
