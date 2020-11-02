<?php

$f3 = require(__DIR__.'/../vendor/fatfree/lib/base.php');
require __DIR__ . '/../app/bootstrap.php';

$test = new Test();

$urlTest = "https://www.google.fr/maps/place/test";
$term = 'test';

$test->expect(Scrapping::downloadSearch($term, false) == Scrapping::getNodejsBin().' '.Scrapping::getBinPath().'/download_search.js "test" true', "commande de téléchargement html de la recherche");
$test->expect(Scrapping::parseSearch("file.html", false) == Scrapping::getNodejsBin().' '.Scrapping::getBinPath().'/parse_search.js "file.html" true', "commande de parsing du html de la recherche");
$test->expect(Scrapping::downloadPage($urlTest, "file.jpg", false) == Scrapping::getNodejsBin().' '.Scrapping::getBinPath().'/download_google.js "'.$urlTest.'" "file.jpg" true', "commande de téléchargement html d'une page");
$test->expect(Scrapping::parsePage($urlTest, "file.html", false) == Scrapping::getNodejsBin().' '.Scrapping::getBinPath().'/parse_google.js "file.html" true', "commande de parsing du html d'une page");
$test->expect(Scrapping::existReviewsScript($urlTest), "le script de download des avis existe");
$test->expect(!Scrapping::existReviewsScript("http://test.test/"), "le script de download des avis n'existe pas");
$test->expect(Scrapping::downloadReviews($urlTest, false) == Scrapping::getNodejsBin().' '.Scrapping::getBinPath().'/download_avis_google.js "'.$urlTest.'" true', "commande de téléchargement html des avis");
$test->expect(Scrapping::parseReviews($urlTest, "file.html", false) == Scrapping::getNodejsBin().' '.Scrapping::getBinPath().'/parse_avis_google.js "file.html" true', "commande de parsing du html des avis");

file_put_contents(__DIR__."/../cache/".md5($term).".csv", $urlTest."\n");

$search = new Search($term);

$test->expect(count($search->getUrls()) == 1, "Une url exporté dans la recherche");
$test->expect($search->getUrls()[0] == $urlTest, "L'url de test est ".$urlTest);

$test->expect(Page::resolvePlateform("https://www.google.fr/maps/place/Ma+Boutique") == "google", "Reconnaissance des urls google maps");
$test->expect(Page::resolvePlateform("https://goo.gl/maps/a65gdFzz7") == "google", "Reconnaissance des urls raccourci de google maps");
$test->expect(Page::resolvePlateform("https://www.pagesjaunes.fr/pros/123456789") == "pagesjaunes", "Reconnaissance des urls pages jaunes");
$test->expect(Page::resolvePlateform("https://www.facebook.com/MaBoutique/") == "facebook", "Reconnaissance des urls facebook");
$test->expect(Page::resolvePlateform("https://fr.mappy.com/poi/12345678abcdef#") == "mappy", "Reconnaissance des urls mappy");
$test->expect(Page::resolvePlateform("https://www.petitscommerces.fr/page/ma-boutique/") == "petitscommerces", "Reconnaissance des urls petits commerces");

$commerce = new Commerce();
$commerce->addPage($urlTest);
$commerce->save();

$test->expect(count($commerce->getPages()) == 1, "Le commerce a une page");
$test->expect($commerce->getKey(), "Le commerce a une clé");
$commerceFinded = Commerce::find($commerce->getKey());
$test->expect($commerceFinded instanceof Commerce, "Récupération du commerce");
$test->expect($commerceFinded->getKey() == $commerce->getKey(), "La commerce récupéré à la même clé");
$test->expect(count($commerceFinded->getPages()) == 1, "Le commerce récupéré à une page");

file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;nom;Boutique test\n");
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;adresse;5 rue des cailloux\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;telephone;0102030405\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;site;www.maboutique.shop\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;note;4\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;nombre_avis;10\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_lundi;09:30–19:00\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_mardi;09:30–19:00\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_mercredi;09:30–19:00\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_jeudi;09:30–19:00\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_vendredi;09:30–19:00\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_samedi;09:30–19:00\n", FILE_APPEND);
file_put_contents(__DIR__."/../cache/".md5($urlTest).".csv", "test;Boutique test;horaire_dimanche;Fermé\n", FILE_APPEND);

file_put_contents(__DIR__."/../cache/".md5($urlTest)."_avis.csv", "test;Boutique test;avis;".date('c').";5;un passant;une boutique trop bien\n");
file_put_contents(__DIR__."/../cache/".md5($urlTest)."_avis.csv", "test;Boutique test;avis;".date('c').";5;un autre passant;Au top\n", FILE_APPEND);

$page = new Page($urlTest);

$test->expect($page->getName() == "Boutique test", "Nom du commerce de la page");
$test->expect($page->getAddress() == "5 rue des cailloux", "Adresse du commerce de la page");
$test->expect($page->getPhone() == "0102030405", "Numéro de téléphone de la page");
$test->expect($page->getWebsite() == "www.maboutique.shop", "Site web de la page");
$test->expect($page->getScore() == 4, "Note de la page");
$test->expect($page->getReviewsCount() == 10, "Nombre d'avis de la page");
$test->expect(count($page->getHours()) == 7, "Tableau des horeaires de la page");
$test->expect($page->getHour('dimanche') == "Fermé", "Horaire d'un jour de la page");
$test->expect(count($page->getReviews()) == 2, "2 avis récupéré");

$commerce = new Commerce();
$commerce->addPage($urlTest);

$test->expect(count($commerce->getPages()) == 1, "Le commerce a une page");
$test->expect($commerce->getName() == $page->getName(), "Nom du commerce");
$test->expect($commerce->getAddress() == $page->getAddress(), "Adresse du commerce");
$failed = 0;
foreach ($test->results() as $result) {
    if ($result['status']) {
        echo "\033[7;32mPASS\033[0m ";
    } else {
        echo "\033[7;31mFAIL\033[0m ";
        $failed += 1;
    }

    echo $result['text'];
    if (!$result['status']) {
        echo ' ['.$result['source'].']';
    }
    echo "\n";
}

if($failed) {
    echo "\n\033[7;31m$failed test failed\033[0m\n";
    exit(1);
}
