var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

if($('#media_result_group a').length) {
    console.log("google;Google Maps;https://www.google.com" + $('#media_result_group a').eq(1).attr('data-url'));
}

$('.rc a').each(function() {
    var url = $(this).attr('href');

    if(url.match(/^https:\/\/www.pagesjaunes.fr\/pros\/[0-9]+$/)) {
        console.log("pagesjaunes;PagesJaunes;"+url);
    }

    if(url.match(/^https:\/\/www.facebook.com\/[^\/]+\/$/)) {
        console.log("facebook;Facebook;"+url);
    }

    if(url.match(/^https:\/\/fr.mappy.com\/poi\/[^\/]+$/)) {
        console.log("mappy;Mappy;"+url);
    }

});
