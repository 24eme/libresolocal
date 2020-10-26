var fs = require('fs');
var main = require('./main.js');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "google";
var nom = $('title').text().replace(/ - .*$/, '');
var baseLigne = plateforme + ";" + nom;

$('.section-review-content').each(function() {
    var note = $(this).find('span.section-review-stars').attr('aria-label');
    if(!note) {
        return;
    }
    note = note.replace(/.*([0-9]+).*/, '$1');
    var content = $(this).find('.section-review-text').text().replace(/\n/g, "").replace(";", "");
    var dateText = $(this).find('.section-review-publish-date').text();
    var author = $(this).find('.section-review-title').text().replace(/^[ ]+/, "").replace(/[ ]+$/, "");

    dateText = main.parseRelativeDate(dateText);

    console.log(baseLigne + ";avis;" + dateText + ";" + note + ";" + author + ";" + content);
});
