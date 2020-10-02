const Nightmare = require('nightmare')
var url = process.argv[2];
const nightmare = Nightmare({ show: true })

nightmare
  .goto(url)
  .click("#didomi-notice-agree-button")
  .screenshot("data/pagesjaunes.jpg")
  .evaluate(() => (document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
