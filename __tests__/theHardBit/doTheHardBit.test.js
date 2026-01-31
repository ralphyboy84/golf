// tests/myFunction.test.js
const {
  doTheHardBit,
  findDatesWhereNoAvailability,
} = require("../../js/theHardBit");

// import { doTheHardBit } from "../../js/theHardBit.js";

describe("add function", () => {
  test("3 course validation", () => {
    const available = {
      elie: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "No",
          courseName: "Elie",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "No",
          courseName: "Elie",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Elie",
        },
      ],
      levenlinks: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
      ],
      lundingc: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "Yes",
          courseName: "Lundin Links",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "No",
          courseName: "Lundin Links",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Lundin Links",
        },
      ],
    };

    const returnedObject = [
      {
        date: "2026-04-09",
        course: "Lundin Links",
      },
      {
        date: "2026-04-10",
        course: "Leven",
      },
      {
        date: "2026-04-11",
        course: "Elie",
      },
    ];

    const object = doTheHardBit(available);
    expect(object).toStrictEqual(returnedObject);
  });

  test("Check one day no availability", () => {
    const available = {
      elie: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "No",
          courseName: "Elie",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "No",
          courseName: "Elie",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Elie",
        },
      ],
      levenlinks: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "No",
          courseName: "Leven",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
      ],
      lundingc: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "Yes",
          courseName: "Lundin Links",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "No",
          courseName: "Lundin Links",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Lundin Links",
        },
      ],
    };

    const returnedObject = [
      {
        date: "2026-04-09",
        course: "Leven",
      },
      {
        date: "2026-04-11",
        course: "Elie",
      },
    ];

    const object = doTheHardBit(available);
    expect(object).toStrictEqual(
      "no availability for any of your courses: 2026-04-10",
    );
  });

  test("3 course validation - interested to see what happens", () => {
    const available = {
      elie: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "No",
          courseName: "Elie",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "Yes",
          courseName: "Elie",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Elie",
        },
      ],
      levenlinks: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Leven",
        },
      ],
      lundingc: [
        {
          date: "2026-04-09",
          teeTimesAvailable: "Yes",
          courseName: "Lundin Links",
        },
        {
          date: "2026-04-10",
          teeTimesAvailable: "No",
          courseName: "Lundin Links",
        },
        {
          date: "2026-04-11",
          teeTimesAvailable: "Yes",
          courseName: "Lundin Links",
        },
      ],
    };

    const returnedObject = [
      {
        date: "2026-04-09",
        course: "Lundin Links",
      },
      {
        date: "2026-04-10",
        course: "Elie",
      },
      {
        date: "2026-04-11",
        course: "Leven",
      },
    ];

    const object = doTheHardBit(available);
    expect(object).toStrictEqual(returnedObject);
  });
});
