const {
  doTheHardBit,
  findDatesWhereNoAvailability,
} = require("../../js/theHardBit");

describe("add function", () => {
  test("Check one day no availability", () => {
    const allDates = ["09/04/2026", "10/04/2026", "11/04/2026"];

    const usedDates = [
      {
        date: "09/04/2026",
        course: "Elie",
      },
      {
        date: "10/04/2026",
        course: "Gullane - 1",
      },
    ];

    const returnedObject = ["11/04/2026"];

    const object = findDatesWhereNoAvailability(allDates, usedDates);
    expect(object).toStrictEqual(returnedObject);
  });
});
