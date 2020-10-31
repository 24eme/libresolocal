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
