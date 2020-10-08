var fs = require('fs');
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
    var content = $(this).find('.section-review-text').text().replace(/\n/g, "").replace(";", "");
    var date = $(this).find('.section-review-publish-date').text();
    var author = $(this).find('.section-review-title').text().replace(/^[ ]+/, "").replace(/[ ]+$/, "");
    note = note.replace(/.*([0-9]+).*/, '$1');
    console.log(baseLigne + ";avis;" + date + ";" + note + ";" + author + ";" + content);
});
