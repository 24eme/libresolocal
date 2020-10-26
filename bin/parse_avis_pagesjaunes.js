var fs = require('fs');
var main = require('./main.js');

var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "pagesjaunes"
var nom = $('#teaser-header .denom h1').text();

var baseLigne = plateforme + ";" + nom;

$('ul#liste-contributions li.avis').each(function() {
    var content = $(this).find('.commentaire').text().replace(/\n/g, '');
    var date = main.parseAbsoluteDate($(this).find('.info .date').text().replace(/[ ]+$/, ''));
    var note = $(this).find('.note-contributeur strong').text();
    var author = $(this).find('.pseudo').text();
    console.log(baseLigne + ";avis;" + date + ";" + note + ";" + author + ";" + content);
});
