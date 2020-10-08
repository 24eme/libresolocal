const Nightmare = require('nightmare')
var url = process.argv[2];
var imagepath = process.argv[3];
const nightmare = Nightmare({ show: true })

Nightmare.action('removePopup', function(done) {
  this.evaluate_now(function() {
      document.querySelector('iframe').remove();
      document.querySelector('.widget-consent.widget-consent-fullscreen').remove();
  }, done)
})

nightmare
  .goto(url)
  .removePopup()
  .screenshot(imagepath)
  .click('.allxGeDnJMl__button.allxGeDnJMl__button-text')
  .wait('.ozj7Vb3wnYq__title.gm2-headline-6')
  .evaluate(() => (
      document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
