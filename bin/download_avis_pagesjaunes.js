const Nightmare = require('nightmare')
var url = process.argv[2];
var verbose = process.argv[4];

var nightmare = Nightmare({ show: verbose })

nightmare
  .goto(url)
  .click("#didomi-notice-agree-button")
  .wait(function() {
      if(document.querySelector('#bouton-plus-contributions')) {
          document.querySelector('#bouton-plus-contributions').click();
      }
      if(document.querySelector('#ScrollAvis')) {
          document.querySelector('#ScrollAvis').click();
      }

      var nb_avis = 0;
      if(document.querySelector('#teaser-header .teaser-nombre-avis')) {
          var nb_avis = parseInt(document.querySelector('#teaser-header .teaser-nombre-avis').innerText);
      }
      return document.querySelectorAll('#liste-contributions li.avis').length >= nb_avis;
    })
  .evaluate(() => (document.documentElement.innerHTML))
  .end()
  .then(console.log)
  .catch(error => {
    console.error('Search failed:', error)
  })
