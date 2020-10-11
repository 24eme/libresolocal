const Nightmare = require('nightmare')
var url = process.argv[2];
var imagepath = process.argv[3];

var nightmare = Nightmare({ show: true })
nightmare
    .goto(url+"reviews/")
    .wait('button[data-cookiebanner="accept_button"]')
    .click('button[data-cookiebanner="accept_button"]')
    .wait(function() { return !document.querySelector('button[data-cookiebanner="accept_button"]'); })
    .wait(function() { document.querySelector('#pagelet_growth_expanding_cta').remove(); return !document.querySelector('#pagelet_growth_expanding_cta'); })
    .wait(function() { window.scrollTo(0, 100000000); return !document.querySelector('.uiMorePagerPrimary'); })
    .evaluate(() => (document.documentElement.innerHTML))
    .end()
    .then(console.log)
    .catch(error => {
      console.error('Search failed:', error)
  });
