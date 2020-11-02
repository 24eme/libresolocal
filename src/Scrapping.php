<?php

class Scrapping
{
    public static function downloadSearch($term, $execute = true) {

        return self::execute("download_search.js", array($term), $execute);
    }

    public static function parseSearch($htmlFile, $execute = true) {

        return self::execute("parse_search.js", array($htmlFile), $execute);
    }

    public static function downloadPage($url, $imagePath, $execute = true) {
        $plateform = Page::resolvePlateform($url);

        return self::execute("download_".$plateform.".js", array($url, $imagePath), $execute);
    }

    public static function parsePage($url, $htmlFile, $execute = true) {
        $plateform = Page::resolvePlateform($url);

        return self::execute("parse_".$plateform.".js", array($htmlFile), $execute);
    }

    public static function existReviewsScript($url) {
        $plateform = Page::resolvePlateform($url);

        return file_exists(self::getBinPath()."/download_avis_".$plateform.".js");
    }

    public static function downloadReviews($url, $execute = true) {
        $plateform = Page::resolvePlateform($url);

        return self::execute("download_avis_".$plateform.".js", array($url), $execute);
    }

    public static function parseReviews($url, $htmlFile, $execute = true) {
        $plateform = Page::resolvePlateform($url);

        return self::execute("parse_avis_".$plateform.".js", array($htmlFile), $execute);
    }

    public static function getBinPath() {

        return __DIR__."/../bin";
    }

    public static function getNodejsBin() {

        return "node";
    }

    public static function execute($scriptFile, $arguments = array(), $execute = true) {
        foreach($arguments as $key => $argument) {
            $arguments[$key] = '"'.str_replace('"', '\"', $argument).'"';
        }

        $verbose = "true";
        $command = sprintf("%s %s/%s %s %s", self::getNodejsBin(), self::getBinPath(), $scriptFile, implode(" ", $arguments), $verbose);

        if(!$execute) {

            return $command;
        }

        return shell_exec($command);
    }

}
