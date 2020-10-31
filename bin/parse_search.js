var fs = require('fs');
var fileHTML = process.argv[2];
const cheerio = require('cheerio');
const $ = cheerio.load(fs.readFileSync(fileHTML));

if($('#media_result_group a').length) {
    console.log("https://www.google.com" + $('#media_result_group a').eq(1).attr('data-url'));
}

$('div.rc > div > a').each(function() {
    var url = $(this).attr('href');

    if(!url.match(/^https?:\/\//)) {
        return;
    }
    console.log(url);
});
