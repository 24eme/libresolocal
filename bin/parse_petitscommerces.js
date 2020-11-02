var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "petitscommerces"
var nom = $('.listing-main-info h1').text().replace("\n", "").replace(/^[ ]+/, "").replace(/[ ]+$/, "");
var adresse = $('.listing-main-info h2').text().replace("\n", "").replace(/^[ ]+/, "").replace(/[ ]+$/, "");
var phone = $('.local_phone').next('span').text().replace("\n", "").replace(/^[ ]+/, "").replace(/[ ]+$/, "");
var site = $('.fa-link').parent('a').attr('href');

var baseLigne = plateforme + ";" + nom;

console.log(baseLigne + ";nom;" + nom);
console.log(baseLigne + ";adresse;" + adresse);
console.log(baseLigne + ";telephone;" + phone);
console.log(baseLigne + ";site;" + site);

$('#open-hours ul.extra-details li').each(function() {
    var jour = $(this).find('p.item-attr').text().toLowerCase();
    var horaires = []
    $(this).find('p.item-property span').each(function() {
        horaires.push($(this).text().replace(/ /g, "").replace(/\n/g, ""));
    });
    console.log(baseLigne + ";horaire_" + jour + ";" + horaires.join(","));
});
