var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "facebook";
var nom = $('#entity_sidebar a span').eq(0).text();

var baseLigne = plateforme + ";" + nom;

$('.userContentWrapper').each(function() {
    var content = $(this).find('.userContent').text().replace(/\n/g, '');
    var date = $(this).find('._5ptz').attr('title');
    var note = "";
    var author = $(this).find('.fwb .profileLink').text();
    console.log(baseLigne + ";avis;" + date + ";" + ";" + author + ";" + content);
});
