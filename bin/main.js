exports.parseAbsoluteDate = function(strDate) {
    //strDate = strDate.replace(/,.*$/, '');
    strDate = strDate.replace(/janvier/, 'january');
    strDate = strDate.replace(/février/, 'february');
    strDate = strDate.replace(/mars/, 'march');
    strDate = strDate.replace(/avril/, 'april');
    strDate = strDate.replace(/mai/, 'may');
    strDate = strDate.replace(/juin/, 'june');
    strDate = strDate.replace(/juillet/, 'july');
    strDate = strDate.replace(/août/, 'august');
    strDate = strDate.replace(/septembre/, 'september');
    strDate = strDate.replace(/octobre/, 'october');
    strDate = strDate.replace(/novembre/, 'november');
    strDate = strDate.replace(/décembre/, 'december');

    var date = new Date(strDate);

    if(date == "Invalid Date") {

        return "";
    }

    return date.toISOString();
}

exports.parseRelativeDate = function(strDate) {
    var nbDays = 0;
    strDate = strDate.replace(/ une? /, ' 1 ');
    if(strDate.match(/ans?$/)) {
        nbDays = strDate.replace(/^[^0-9]*([0-9]+)[^0-9]*$/, '$1') * 365;
    }
    if(strDate.match(/mois$/)) {
        nbDays = strDate.replace(/^[^0-9]*([0-9]+)[^0-9]*$/, '$1') * 31;
    }
    if(strDate.match(/semaines?$/)) {
        nbDays = strDate.replace(/^[^0-9]*([0-9]+)[^0-9]*$/, '$1') * 7;
    }
    if(strDate.match(/jours?$/)) {
        nbDays = strDate.replace(/^[^0-9]*([0-9]+)[^0-9]*$/, '$1');
    }

    nbYear = Math.floor(nbDays / 365);
    nbDays = nbDays % 365;
    nbMonth = Math.floor(nbDays / 31);
    nbDays = nbDays % 31;

    var date = new Date();
    var year = date.getFullYear() - nbYear;
    var month = date.getMonth() - nbMonth;
    var day = date.getDate() - nbDays;
    if(day < 0) {
        day = day + 31;
        month = month - 1;
    }
    if(month < 0) {
        month = month + 12;
        year = year - 1;
    }

    date.setFullYear(year);
    date.setMonth(month);
    date.setDate(day);

    return date.toISOString();
}
