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

  var calendar = new FullCalendar.Calendar(calendarEl, {
    themeSystem: "bootstrap5",
    initialView,
    height: "auto", // lets it fill the parent, but can cause tiny height if empty
    contentHeight: "auto", // similar
    dayMaxEventRows: true, // optional
    // Add a minHeight
    viewDidMount: function (info) {
      // set a min height for the listWeek container
      info.el.style.minHeight = "400px"; // adjust as needed
    },
    events: "../api/getAllOpens.php",
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
  });
  calendar.render();
});
