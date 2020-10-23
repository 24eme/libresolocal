const Nightmare = require('nightmare')
var url = process.argv[2];
var verbose = process.argv[3];

var nightmare = Nightmare({ show: verbose, waitTimeout: 300000 })

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
  .click('.allxGeDnJMl__button.allxGeDnJMl__button-text')
  .wait('.ozj7Vb3wnYq__title.gm2-headline-6')
  .wait(function() { document.querySelector('.section-layout.section-scrollbox.scrollable-y.scrollable-show').scrollTop = 100000000; return !document.querySelector('.section-loading'); })
  .evaluate(() => (
      document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
