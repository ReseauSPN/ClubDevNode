<?php

/**
 * Data est une classe qui permet de gérer la persistence de données dans un fichier texte
 * @author berduj
 */
class dataManager {

    private $filename;
    private $data;

    public function __construct()
    {
        $this->filename = __DIR__ . DIRECTORY_SEPARATOR . "data.txt";
        if (!file_exists($this->filename)) {
            $this->initData();
            $this->save();
        }
        $this->data = unserialize(file_get_contents($this->filename));
    }

    public function getAll()
    {
        return $this->data;
    }

    public function getByName($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        throw new Exception("La clé " . $name . " n'existe pas");
    }

    public function setByName($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function save()
    {
        file_put_contents($this->filename, serialize($this->data));
    }

    public function initData()
    {
        unset($this->data);
        //$this->data=array()
        for ($i = 1; $i <= 10; $i++) {
            $this->setByName("variable_" . $i, $i);
        }
        $this->save();
    }

}
