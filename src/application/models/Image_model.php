<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."data_structures/Imagem.php");


class ImageHandlingStrategy{
    protected $table;
    protected $tableImageIdColumnName;
    protected $imageTable;
    protected $idColumName;
    protected $imageColumnName;

    public function __construct(string $table,
                                string $tableImageIdColumnName,
                                string $imageTable,
                                string $idColumName,
                                string $imageColumnName){
        $this->table = $table;
        $this->tableImageIdColumnName = $tableImageIdColumnName;
        $this->imageTable = $imageTable;
        $this->idColumName = $idColumName;
        $this->imageColumnName = $imageColumnName;
    }
}

class OneToNImageHandlingStrategy extends ImageHandlingStrategy{

    public function getImages($id){     
        $CI = &get_instance();
        $CI->db->select("id, nome");
        $CI->db->join(Image_model::DB_TABLE,"imagem.id = $this->imageColumnName", 'INNER');
        $CI->db->where("$this->imageTable.$this->idColumName", $id);
        $result = $CI->db->get($this->imageTable)->result();

        $images = array();
        foreach ($result as $key => $value) {
            $images[] = new Imagem($value->id, $value->nome);
            //echo $value->id."  ".$value->nome."<br>";
            
        }

        return $images;
    }

    public function insertImages($id, $images){
        $CI = &get_instance();
        $CI->load->model("My_Model", "model");
        foreach ($images as $key => $image) {
            $CI->db->insert(
                $this->imageTable,
                array(
                    $this->idColumName => $id,
                    $this->imageColumnName => $image->getID()
                ) 
            );
            if(!$CI->model->successQuery()){
                return false;
            }else{
                $CI->model->log($this->imageTable, Log::INSERT);
            }
        }
        return true;
    }

    public function deleteImages($id, $images){
        $CI = &get_instance();
        $CI->load->model("My_Model", "model");
        foreach ($images as $key => $image) {
            $CI->db->delete(
                $this->imageTable,
                array(
                    $this->idColumName => $id,
                    $this->imageColumnName => $image->getID()
                ) 
            );
            if(!$CI->model->successQuery()){
                return false;
            }else{
                $CI->model->log($this->imageTable, Log::DELETE);
            }
        }
    }
}

class OneToOneImageHandlingStrategy extends ImageHandlingStrategy{
    public function join($db){
        $db->join(Image_model::DB_TABLE, 
                  Image_model::DB_TABLE.".".Image_model::ID_COLUMN."=$this->tableImageIdColumnName", "INNER");
        return $db; 
    }
}

require_once(APPPATH."models/My_Model.php");
class Image_model extends My_Model{
    const DB_TABLE = "imagem";
    const ID_COLUMN = "id";
    const NAME_COLUMN = "nome";
    public function __construct(){
        parent::__construct();
        $config = $this->set_upload_options();

        $this->load->library('upload', $config);
    }

    private function SelectStrategy($table){
        if($table == Imagem::PROJETO){
            //TODO:require_once(APPPATH."models/Projeto_model.php");
            $Strategy = new OneToNImageHandlingStrategy(
                                Imagem::PROJETO,
                                "id",
                                Imagem::PROJETO."_imagem",
                                "id_projeto",
                                "id_imagem"
                                );
        }else if($table == Imagem::NOTICIA){
            $Strategy = new OneToNImageHandlingStrategy(
                                Imagem::NOTICIA,
                                "id",
                                Imagem::NOTICIA."_imagem",
                                "noticia_id",
                                "imagem_id"
                                );
        }else{
            require_once(APPPATH."models/Usuario_model.php");
            require_once(APPPATH."models/Membro_model.php");
            if($table == Usuario_model::DB_TABLE ||
               $table == Membro_model::DB_TABLE){
                $Strategy = new OneToOneImageHandlingStrategy(
                                    Usuario_model::DB_TABLE,
                                    Usuario_model::IMAGEM_COLUMN,
                                    "",
                                    "",
                                    ""
                                );
            }else{
                return false;
            }
        }
        
        return $Strategy;
    }

    public function get($id){
        $this->db->where(self::ID_COLUMN, $id);
        $result = $this->db->get(self::DB_TABLE)->row_array();
        return new Imagem($result[self::ID_COLUMN], 
                         $result[self::NAME_COLUMN]);
    }

    public function getImages($table, $id){
        $Strategy = $this->SelectStrategy($table);
        return $Strategy->getImages($id);
    }

    public function insert($image){
        if($image->getName() == Imagem::DEFAULT || $image->getID() == 1)
            return 1;
        $this->db->insert( 
            Image_model::DB_TABLE,
            array(
                Image_model::NAME_COLUMN => $image->getName()
            )
        );
        if($this->successQuery()){
            $id = $this->db->insert_id();
            $this->log(Image_model::DB_TABLE, Log::INSERT);
            return $id;
        }
        return false;
    }

    public function insertImages($table, $id, $images){
        if(!is_array($images)){
            $images = array($images);
        }
        foreach ($images as $key => $image) {
            $images[$key]->setID($this->insert($image));
        }
        $Strategy = $this->SelectStrategy($table);
        return $Strategy->insertImages($id, $images);
    }

    public function delete($image){
        if($image->getID() == Imagem::NO_ID){
            return false;
        }

        $this->db->where(Image_model::ID_COLUMN, $image->getID());
        $this->db->delete(Image_model::DB_TABLE);
        if($this->successQuery()){
            $this->log(Image_model::DB_TABLE, Log::DELETE);
            return true;
        }
        return false;
    }

    public function deleteImages($table, $id, $images){
        if(!is_array($images)){
            $images = array($images);
        }
        $Strategy = $this->SelectStrategy($table);
        if(!$Strategy->deleteImages($id, $images))
        {
            foreach ($images as $key => $image) {
                $this->delete($image);
            }
            return true;
        }
        return false;
    }

    public function list(){
        $result = $this->db->get(Image_model::DB_TABLE)->result_array();
        $images = array();
        foreach ($result as $key => $value) {
            $images[] = new Imagem($value[Image_model::ID_COLUMN],
                                  $value[Image_model::NAME_COLUMN]);
        }

        return $images;
    }

    public function joinTable(string $Table, $db){
        $Strategy = $this->SelectStrategy($Table);
        return $Strategy->join($db);
    }

    public function upload_images($field_name){
        $images = array();
        $files = $_FILES;

        $cpt = count($_FILES[$field_name]['name']);

        for($i=0; $i<$cpt; $i++)
        {           
            $_FILES[$field_name]['name']= $files[$field_name]['name'][$i];
            if($_FILES[$field_name]['name'] == "")
                continue;
            $_FILES[$field_name]['type']= $files[$field_name]['type'][$i];
            $_FILES[$field_name]['tmp_name']= $files[$field_name]['tmp_name'][$i];
            $_FILES[$field_name]['error']= $files[$field_name]['error'][$i];
            $_FILES[$field_name]['size']= $files[$field_name]['size'][$i];

            $this->upload->initialize($this->set_upload_options());
            if($this->upload->do_upload($field_name)){
                $images[] = new Imagem($this->upload->data('file_name'));
            }
        }

        if(count($images) == 0){
            $images[] = new Imagem(1, Imagem::DEFAULT);
        }

        return $images;
    }

    private function set_upload_options()
    {   
        //upload an image options
        $config = array();
        $config['upload_path'] = '.'.DIRECTORY_SEPARATOR.Imagem::FOLDER.DIRECTORY_SEPARATOR;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']     = '1000';
        $config['max_width'] = '1400';
        $config['max_height'] = '768';

        return $config;
    }

    public function removeImage(Imagem $imagem){
        if($imagem->getName() == Imagem::DEFAULT)
            return;
        unlink(APPPATH."../".$imagem);
        $this->delete($imagem);
    }

    public function removeImages(array $images){
        if(!is_array($images)){
            $images = array($images);
        }
        foreach ($images as $key => $image) {
            $this->removeImage($image);
        }
    }
}