<?php


class Imagem{
    private $id;
    private $name;
    const PROJETO = "projeto";
    const NOTICIA = "noticia";
    const FOLDER = "uploads";
    const NO_ID = -1;
    const DEFAULT = "default.jpg";

    public function __construct(){
        $argv = func_get_args();
        switch(func_num_args()){
            case 1:
                self::__construct1($argv[0]);
                break;
            case 2:
                self::__construct2($argv[0], $argv[1]);
                break;
        }
    }

    public function __construct2($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    private function __construct1($name){
        $this->id = self::NO_ID;
        $this->name = $name;
    }


    public function getID(){
        return $this->id;
    }

    public function setID($newID){
        $this->id = $newID;
    }

    public function getName(){
        return $this->name;
    }

    public function getFilePath(){
        return self::FOLDER.DIRECTORY_SEPARATOR.$this->name;
    }

    public function __toString(){
        return $this->getFilePath();
    }

}

?>