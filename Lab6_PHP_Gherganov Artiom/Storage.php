<?php

class Storage {

    private $file = 'data.json';

    public function getAll() {
        return file_exists($this->file)
            ? json_decode(file_get_contents($this->file), true)
            : [];
    }

    public function save($data) {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }
}