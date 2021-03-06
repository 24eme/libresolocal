<?php

class Commerce {

    protected $pages = array();
    protected $key = null;

    public function __construct()
    {
        $this->pages = array();
    }

    public function getKey() {

        return $this->key;
    }

    public function setKey($key) {

        $this->key = $key;
    }

    public function generateKey() {
        if(!is_null($this->key)) {

            return $this->getKey();
        }

        $this->key = md5(uniqid());

        return $this->getKey();
    }

    public function addPage($url) {
        $this->pages[] = new Page($url);
    }

    public function getPages() {

        return $this->pages;
    }

    public function getName() {
        foreach($this->getPages() as $page) {

            return $page->getName();
        }
    }

    public function getAddress() {
        foreach($this->getPages() as $page) {

            return $page->getAddress();
        }
    }

    public function getReviews() {
        $reviews = array();
        foreach($this->getPages() as $page) {
            foreach($page->getReviews() as $review) {
                $reviews[$review->getDate()->format('YmdHis').uniqid()] = $review;
            }
        }

        krsort($reviews);

        return $reviews;
    }

    public function getReviewsFacets() {
        $facets = array("Par page" => array(), "Par année" => array(), "Par note" => array());

        foreach($this->getReviews() as $review) {
            $facets['Par page'][$review->getPlateform()] += 1;
            $facets['Par année'][$review->getDate()->format('Y')] += 1;
            $facets['Par note'][($review->getScore()) ? $review->getScore() : "Aucune"] += 1;
        }

        krsort($facets['Par note']);
        arsort($facets['Par page']);

        return $facets;
    }

    public function save() {
        $this->generateKey();
        $urls = array();
        foreach($this->getPages() as $page) {
            $urls[] = $page->getUrl();
        }
        file_put_contents(__DIR__."/../data/".$this->getKey(), implode("\n", $urls));
    }

    public static function find($key) {
        $urls = explode("\n", file_get_contents(__DIR__."/../data/".$key));

        $commerce = new Commerce();
        $commerce->setKey($key);
        foreach($urls as $url) {
            $commerce->addPage($url);
        }

        return $commerce;
    }

}
