const Nightmare = require('nightmare')
var url = process.argv[2];
var imagepath = process.argv[3];
const nightmare = Nightmare({ show: true })

nightmare
  .goto(url)
  .click('#didomi-notice-agree-button')
  .screenshot(imagepath)
  .evaluate(() => (document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
