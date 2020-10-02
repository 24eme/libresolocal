var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

var plateforme = "google"
var nom = $('.section-hero-header-title-title span').text();
var adresse = $('button[data-item-id="address"] .gm2-body-2').text();
var phone = $('button[data-item-id*="phone:tel:"] .gm2-body-2').text();
var site = $('button[data-item-id="authority"] .gm2-body-2').text();
var note = $('.section-hero-header-title-description-container .section-star-display').text();
var nbNotes = $('.section-hero-header-title-description-container .section-rating-term .widget-pane-link[jsaction="pane.rating.moreReviews"]').eq(0).text().replace(/[()]*/g, "");
var categorie = $('.section-hero-header-title-description-container .section-rating-term .widget-pane-link[jsaction="pane.rating.category"]').eq(0).text();

var baseLigne = plateforme + ";" + nom;

console.log(baseLigne + ";nom;" + nom);
console.log(baseLigne + ";adresse;" + adresse);
console.log(baseLigne + ";telephone;" + phone);
console.log(baseLigne + ";site;" + site);
console.log(baseLigne + ";note;" + note.replace(",", ".") + "/5");
console.log(baseLigne + ";nombre_avis;" + nbNotes);
console.log(baseLigne + ";categorie;" + categorie);
$('.section-open-hours-container tr').each(function() {
    var jour = $(this).find('th div').text();
    var horaires = []
    $(this).find('td li').each(function() {
        horaires.push($(this).text());
    });
    console.log(baseLigne + ";horaire_" + jour + ";" + horaires.join(","));
});
