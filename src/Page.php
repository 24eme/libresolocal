<?php

class Page {

    protected $plateform = null;
    protected $url = null;
    protected $verbose = null;
    protected $hydrate = false;
    protected $name = null;
    protected $address = null;
    protected $website = null;
    protected $score = null;
    protected $reviews_count = null;
    protected $hours = null;

    public function __construct($url) {
        $this->url = $url;
        $this->plateform = self::resolvePlateform($url);
    }

    public function getUrl() {

        return $this->url;
    }

    public function getImageFile() {

        return __DIR__."/../cache/".md5($this->url).".jpg";
    }

    public function getPlateform() {

        return $this->plateform;
    }

    public function getName() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->name;
    }

    public function getAddress() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->address;
    }

    public function getPhone() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->phone;
    }

    public function getWebsite() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->website;
    }

    public function getScore() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->score;
    }

    public function getReviewsCount() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->reviews_count;
    }

    public function getHour($dayName) {

        return $this->getHours()[$dayName];
    }

    public function getHours() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->hours;
    }

    public function getReviews() {
        if(!$this->hydrate) {
            $this->hydrate();
        }

        return $this->reviews;
    }

    public function hydrate() {
        foreach(explode("\n", $this->getCSV()) as $line) {
            if(!$line) {
                continue;
            }
            $data = str_getcsv($line, ";");
            $infos[$data[2]] = $data[3];
        }

        $this->name = isset($infos['nom']) ? $infos['nom'] : null;
        $this->address = isset($infos['adresse']) ? $infos['adresse'] : null;
        $this->phone = isset($infos['telephone']) ? $infos['telephone'] : null;
        $this->website = isset($infos['site']) ? $infos['site'] : null;
        $this->score = isset($infos['note']) ? $infos['note'] : null;
        $this->reviews_count = isset($infos['nombre_avis']) ? $infos['nombre_avis'] : null;
        $this->hours = array();
        $this->hours['lundi'] = isset($infos['horaire_lundi']) ? $infos['horaire_lundi'] : null;
        $this->hours['mardi'] = isset($infos['horaire_mardi']) ? $infos['horaire_mardi'] : null;
        $this->hours['mercredi'] = isset($infos['horaire_mercredi']) ? $infos['horaire_mercredi'] : null;
        $this->hours['jeudi'] = isset($infos['horaire_jeudi']) ? $infos['horaire_jeudi'] : null;
        $this->hours['vendredi'] = isset($infos['horaire_vendredi']) ? $infos['horaire_vendredi'] : null;
        $this->hours['samedi'] = isset($infos['horaire_samedi']) ? $infos['horaire_samedi'] : null;
        $this->hours['dimanche'] = isset($infos['horaire_dimanche']) ? $infos['horaire_dimanche'] : null;
        $this->reviews = Reviews::getReviews($this->url);

        $this->hydrate = true;
    }

    public function getCSV() {
        $csvFile = __DIR__."/../cache/".md5($this->url).".csv";

        if(file_exists($csvFile)) {
            return file_get_contents($csvFile);
        }

        $htmlFile = __DIR__."/../cache/".md5($this->url).".html";
        $imageFile = __DIR__."/../cache/".md5($this->url).".jpg";
        if(!file_exists($htmlFile)) {
            file_put_contents($htmlFile, self::download($this->url, $imageFile, $this->verbose));
        }

        if(!file_exists($csvFile)) {
            file_put_contents($csvFile, self::parse($this->url, $htmlFile, $this->verbose));
        }

        return file_get_contents($csvFile);
    }

    public static function download($url, $imagePath, $verbose = false) {
        $html = shell_exec("nodejs ../bin/download_".self::resolvePlateform($url).".js '".$url."' $imagePath true");

        if(!$html) {
            throw new Exception("download failed");
        }

        return $html;
    }

    public static function parse($url, $htmlFile) {
        $csv = shell_exec("nodejs ../bin/parse_".self::resolvePlateform($url).".js $htmlFile");

        if(!$csv) {
            throw new Exception("parse failed");
        }

        return $csv;
    }

    public static function resolvePlateform($url) {
        if(preg_match("|^https://[^\.\ ]*.?google.[^\.\ ]+/maps/place/|", $url)) {
            return "google";
        }
        if(preg_match("|^https://goo.gl/maps/[a-zA-Z0-9]+|", $url)) {
            return "google";
        }
        if(preg_match("|^https://www.pagesjaunes.fr/pros/[0-9]+|", $url)) {
            return "pagesjaunes";
        }
        if(preg_match("|^https://www.facebook.com/[^/]+/|", $url)) {
            return "facebook";
        }
        if(preg_match("|^https://fr.mappy.com/poi/[0-9a-z]+|", $url)) {
            return "mappy";
        }
    }


}
