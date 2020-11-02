<?php

class Search {

    protected $term = null;
    protected $verbose = false;

    public function __construct($term) {
        $this->term = $term;
    }

    public function setVerbose($verbose)  {
        $this->verbose = $verbose;
    }

    public function getUrls() {
        $urls = array();
        foreach(explode("\n", $this->getCSV()) as $url) {
            if(!$url) {
                continue;
            }
            if(!Page::resolvePlateform($url)) {
                continue;
            }
            $urls[] = $url;
        }

        return $urls;
    }

    public function getCSV() {
        $csvFile = __DIR__."/../cache/".md5($this->term).".csv";

        if(file_exists($csvFile)) {
            return file_get_contents($csvFile);
        }

        $htmlFile = __DIR__."/../cache/".md5($this->term).".html";
        if(!file_exists($htmlFile)) {
            file_put_contents($htmlFile, Scrapping::downloadSearch($this->term));
        }

        if(!file_exists($csvFile)) {
            file_put_contents($csvFile, Scrapping::parseSearch($htmlFile));
        }

        return file_get_contents($csvFile);
    }

}
