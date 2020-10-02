var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "lefigaro";
var nom = $('#item-header h1').text();
var adresse = $('#item-header address a span[itemprop=streetAddress]').text()+" "+$('#item-header address a span[itemprop=postalCode]').text()+" "+$('#item-header address a span[itemprop=addressLocality]').text();

var baseLigne = plateforme + ";" + nom;

console.log(baseLigne + ";nom;" + nom);
console.log(baseLigne + ";adresse;" + adresse);
