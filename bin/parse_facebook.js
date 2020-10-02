var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "facebook";
var nom = $('#entity_sidebar a span').eq(0).text();
var adresse = $('#content_container ._1xnd ._4bl9 ._2iem').eq(0).text();
var phone = $('#content_container ._1xnd ._4bl9 ._50f4').eq(0).text().replace("Appeler ", "");
var email = $('#content_container  ._1xnd ._5aj7 ._4bl9 a').eq(0).attr('href').replace("mailto:", "");
var site = $('#content_container ._1xnd ._5aj7 ._4bl9 a[target=_blank] ._50f4').eq(0).text();
var note = $('._672g._1f47').text();
var nbNotes = $('._67l2').text().replace(/[^0-9]*([0-9]+)[^0-9]*/, "$1");
var categories = $('._4bl9._5m_o').text().split(" · ");

var baseLigne = plateforme + ";" + nom;

console.log(baseLigne + ";nom;" + nom);
console.log(baseLigne + ";adresse;" + adresse);
console.log(baseLigne + ";telephone;" + phone);
console.log(baseLigne + ";email;" + email);
console.log(baseLigne + ";site;" + site);
console.log(baseLigne + ";note;" + note.replace(",", ".") + "/5");
console.log(baseLigne + ";nombre_avis;" + nbNotes);
for(k in categories) {
    console.log(baseLigne + ";categorie;" + categories[k]);
}
$('ul li.__MenuItem').each(function() {
    var jour = $(this).find('._4bl7').text().replace(": ", "");
    var horaires = $(this).find('._4bl9._5-l7').text().replace(/ /g, "");
    console.log(baseLigne + ";horaire_" + jour + ";" + horaires);
});
