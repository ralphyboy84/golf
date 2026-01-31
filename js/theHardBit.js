if (typeof exports !== "undefined") {
  module.exports = doTheHardBit;
}

// src/myFunction.js
function sortAvailabilityByCount(availabilityObject) {
  const availabilityCounts = Object.entries(availabilityObject).map(
    ([courseKey, teeTimes]) => {
      // Use a Set to store unique dates with teeTimesAvailable === "Yes"
      const availableDates = new Set();

      teeTimes.forEach((tt) => {
        if (tt.teeTimesAvailable === "Yes") {
          availableDates.add(tt.date);
        }
      });

      // Return an object with courseName and count of available dates
      return {
        courseName: courseKey,
        availableDatesCount: availableDates.size,
      };
    },
  );

  // Sort ascending by availableDatesCount
  availabilityCounts.sort(
    (a, b) => a.availableDatesCount - b.availableDatesCount,
  );

  return availabilityCounts;
}

function getUniqueDates(golfData) {
  const allDates = Object.values(golfData)
    .flat() // combine all arrays
    .map((tt) => tt.date); // extract the date

  // Remove duplicates using a Set and sort ascending
  return (uniqueSortedDates = [...new Set(allDates)].sort());
}

function doTheHardBit(availabilityObject) {
  const availabilityCounts = sortAvailabilityByCount(availabilityObject);
  const allDates = getUniqueDates(availabilityObject);

  // Make a deep copy so we can safely mutate
  const remainingAvailable = JSON.parse(JSON.stringify(availabilityObject));

  const returnedObject = [];
  const usedDates = new Set();
  let totalDays;

  availabilityCounts.forEach(({ courseName }) => {
    const teeTimes = remainingAvailable[courseName];
    totalDays = remainingAvailable[courseName].length;

    // Find the first available date that hasn't been used yet
    const firstAvailable = teeTimes.find(
      (tt) => tt.teeTimesAvailable === "Yes" && !usedDates.has(tt.date),
    );

    if (firstAvailable) {
      // Add to returned array
      returnedObject.push({
        date: firstAvailable.date,
        course: firstAvailable.courseName,
      });

      // Mark this date as used
      usedDates.add(firstAvailable.date);

      // Remove the selected date from this course's array
      const index = teeTimes.findIndex((tt) => tt.date === firstAvailable.date);
      if (index !== -1) {
        teeTimes.splice(index, 1);
      }
    }

    // Optionally, remove the course entirely
    delete remainingAvailable[courseName];
  });

  if (totalDays == returnedObject.length) {
    return returnedObject.sort((a, b) => (a.date > b.date ? 1 : -1));
  } else {
    const datesNoAvailability = findDatesWhereNoAvailability(
      allDates,
      returnedObject,
    );
    return (
      "no availability for any of your courses: " +
      datesNoAvailability.join(", ")
    );
  }
}

function findDatesWhereNoAvailability(allDates, usedDates) {
  const usedDatesOnly = usedDates.map((d) => d.date);

  // Filter the first array to only include dates NOT in the second array
  return allDates.filter((d) => !usedDatesOnly.includes(d));
}
