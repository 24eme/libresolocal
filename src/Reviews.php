<?php

class Reviews
{

    public static function getReviews($url, $verbose = false) {
        $reviews = array();
        foreach(explode("\n", self::getCSV($url, $verbose)) as $line) {
            if(!$line) {
                continue;
            }
            $data = str_getcsv($line, ";");
            $review = new Review();
            $review->setPlateform(Page::resolvePlateform($url));
            $review->setDate(new DateTime($data[3]));
            $review->setScore($data[4]);
            $review->setAuthor($data[5]);
            $review->setContent($data[6]);

            $reviews[] = $review;
        }

        return $reviews;
    }

    public static function getCSV($url, $verbose = false) {
        if(!Scrapping::existReviewsScript($url)) {
            return;
        }

        $csvFile = __DIR__."/../cache/".md5($url)."_avis.csv";

        if(file_exists($csvFile)) {
            return file_get_contents($csvFile);
        }

        $htmlFile = __DIR__."/../cache/".md5($url)."_avis.html";

        if(!file_exists($htmlFile)) {
            file_put_contents($htmlFile, Scrapping::downloadReviews($url));
        }

        if(!file_exists($csvFile)) {
            file_put_contents($csvFile, Scrapping::parseReviews($url, $htmlFile));
        }

        return file_get_contents($csvFile);
    }

}
