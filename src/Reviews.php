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
        $csvFile = __DIR__."/../cache/".md5($url)."_avis.csv";

        if(file_exists($csvFile)) {
            return file_get_contents($csvFile);
        }

        $htmlFile = __DIR__."/../cache/".md5($url)."_avis.html";
        if(!file_exists($htmlFile)) {
            file_put_contents($htmlFile, self::download($url, $verbose));
        }

        if(!file_exists($csvFile)) {
            file_put_contents($csvFile, self::parse($url, $htmlFile));
        }

        return file_get_contents($csvFile);
    }

    public static function download($url, $verbose = false) {
        $scriptPath = __DIR__."/../bin/download_avis_".Page::resolvePlateform($url).".js";

        if(!file_exists($scriptPath)) {
            return;
        }

        $html = shell_exec("node $scriptPath '".$url."' true");

        if(!$html) {
            throw new Exception("download failed");
        }

        return $html;
    }

    public static function parse($url, $htmlFile) {
        $scriptPath = __DIR__."/../bin/parse_avis_".Page::resolvePlateform($url).".js";

        if(!file_exists($scriptPath)) {
            return;
        }

        $csv = shell_exec("node $scriptPath $htmlFile");

        return $csv;
    }
}
