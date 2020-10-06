const Nightmare = require('nightmare')
var search = process.argv[2];
const nightmare = Nightmare({ show: true })

nightmare
  .goto("https://www.google.com/")
  .type("input[type=text]", search)
  .click("input[type=submit]")
  .evaluate(() => (document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
