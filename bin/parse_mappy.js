var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "mappy";
var nom = $('#ContentView h1').text().replace(/^[ ]+/, '').replace(/[ ]+$/, '');
var adresse = $('#ContentView h2.geoentityPopinView-poiAddress').text();
var phone = $('#ContentView .contacts .tel a').attr('href').replace(/^tel:/, '');
var site = $('#ContentView .contacts .url a').attr('href');
var categorie = $('#ContentView h2.geoentityPopinView-poiRubric').text();

var baseLigne = plateforme + ";" + nom;

console.log(baseLigne + ";nom;" + nom);
console.log(baseLigne + ";adresse;" + adresse);
console.log(baseLigne + ";telephone;" + phone);
console.log(baseLigne + ";site;" + site);
console.log(baseLigne + ";categorie;" + categorie);
