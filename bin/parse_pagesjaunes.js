var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "pagesjaunes"
var nom = $('#teaser-header .denom h1').text();
var adresse = $('#teaser-footer .zone-coordonnees .address').text();
var phone = $('#teaser-footer .zone-coordonnees .coord-numero').text();
var site = $('#teaser-footer .zone-coordonnees .lvs-container .pj-link.pj-lb .value').text();
var note = $('#teaser-header .fd-note strong').text();
var nbNotes = $('#teaser-header .teaser-nombre-avis').text().replace("Voir les ", "").replace(" avis", "");
var categorie = $('#zone-info .prestations ul.list-v li span').text();

var baseLigne = plateforme + ";" + nom;

console.log(baseLigne + ";nom;" + nom);
console.log(baseLigne + ";adresse;" + adresse);
console.log(baseLigne + ";telephone;" + phone);
console.log(baseLigne + ";site;" + site);
console.log(baseLigne + ";note;" + note.replace(",", ".") + "/5");
console.log(baseLigne + ";nombre_avis;" + nbNotes);
console.log(baseLigne + ";categorie;" + categorie);
$('#infos-horaires ul.liste-horaires-principaux > li').each(function() {
    var jour = $(this).find('p').text().toLowerCase();
    var horaires = []
    $(this).find('ul.liste li').each(function() {
        horaires.push($(this).text().replace(/ /g, "").replace(/\n/g, ""));
    });
    console.log(baseLigne + ";horaire_" + jour + ";" + horaires.join(","));
});
