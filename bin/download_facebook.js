const Nightmare = require('nightmare')
var url = process.argv[2];
var imagepath = process.argv[3];
var verbose = process.argv[4];

var nightmare = Nightmare({ show: verbose })

nightmare
    .goto(url)
    .wait('button[data-cookiebanner="accept_button"]')
    .click('button[data-cookiebanner="accept_button"]')
    .wait(function() { return !document.querySelector('button[data-cookiebanner="accept_button"]'); })
    .wait(function() { document.querySelector('#pagelet_growth_expanding_cta').remove(); return !document.querySelector('#pagelet_growth_expanding_cta'); })
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
