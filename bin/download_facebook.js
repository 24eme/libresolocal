const Nightmare = require('nightmare')
var url = process.argv[2];
var imagepath = process.argv[3];

var nightmare = Nightmare({ show: true })
nightmare
    .goto(url)
    .screenshot(imagepath)
    .evaluate(() => (document.documentElement.innerHTML))
    .end()
    .then(console.log)
    .catch(error => {
    console.error('Search failed:', error)
    });

var nightmare = Nightmare({ show: true })
nightmare
    .goto(url+"about/")
    .click('.uiPopover ._5jau')
    .evaluate(() => (document.documentElement.innerHTML))
    .end()
    .then(console.log)
    .catch(error => {
    console.error('Search failed:', error)
    });

var nightmare = Nightmare({ show: true })
nightmare
    .goto(url+"reviews/")
    .evaluate(() => (document.documentElement.innerHTML))
    .end()
    .then(console.log)
    .catch(error => {
      console.error('Search failed:', error)
  });
