<?php

class Review
{

    protected $plateform;
    protected $date;
    protected $score;
    protected $author;
    protected $content;

    public function setPlateform($plateform) {
        $this->plateform = $plateform;
    }

    public function getPlateform() {

        return $this->plateform;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {

        return $this->date;
    }

    public function setScore($score) {
        $this->score = $score;
    }

    public function getScore() {

        return $this->score;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getAuthor() {

        return $this->author;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {

        return $this->content;
    }

}
