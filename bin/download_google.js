const Nightmare = require('nightmare')
var url = process.argv[2];
var imagepath = process.argv[3];
var verbose = process.argv[4];

var nightmare = Nightmare({ show: verbose })

Nightmare.action('removePopup', function(done) {
  this.evaluate_now(function() {
      document.querySelector('iframe').remove();
      document.querySelector('.widget-consent.widget-consent-fullscreen').remove();
  }, done)
});

nightmare
  .goto(url)
  .wait('iframe')
  .removePopup()
  .screenshot(imagepath)
  .evaluate(() => (
      document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
