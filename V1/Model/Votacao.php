<?php
class Votacao {
    private $id;
    private $categoria;
    private $indicado1;
    private $indicado2;
    private $indicado3;
    private $indicado4;

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getIndicado1() {
        return $this->indicado1;
    }

    public function setIndicado1($indicado1) {
        $this->indicado1 = $indicado1;
    }

    public function getIndicado2() {
        return $this->indicado2;
    }

    public function setIndicado2($indicado2) {
        $this->indicado2 = $indicado2;
    }

    public function getIndicado3() {
        return $this->indicado3;
    }

    public function setIndicado3($indicado3) {
        $this->indicado3 = $indicado3;
    }

    public function getIndicado4() {
        return $this->indicado4;
    }

    public function setIndicado4($indicado4) {
        $this->indicado4 = $indicado4;
    }
}
