const puppeteer = require("puppeteer");

(async () => {
  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();
  await page.goto(
    "https://www.masterscoreboard.co.uk/bookgen/ClubBookings.php?CWID=6048",
    {
      waitUntil: "networkidle2",
    },
  );

  const content = await page.content();
  console.log(content);

  await browser.close();
})();
