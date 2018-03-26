<?php  defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."models/My_Model.php");
require_once(APPPATH."data_structures/Projeto.php");

class Projeto_model extends My_model{
	const DB_TABLE            = "projeto";
    const ID_COLUMN           = "id";
    const NAME_COLUMN         = "nome";
    const DESCRIPTION_COLUMN  = "descricao";
    const DATA_COLUMN         = "data";
    const SLUG_COLUMN         = "slug";
    const DB_PROJECT_IMG	  = "projeto_imagem";

    public function __construct(){
    	parent::__construct();
    	$this->load->model("Image_model", "imageModel");
    }

    //Método responsável por retornar objeto do tipo Projeto
    public function get(int $id){
    	$this->db->where(self::ID_COLUMN, $id); // Where id = $id
    	$result = $this->db->get(self::DB_TABLE)->row_array(); //Resultado da busca no banco pelo id 
    	$images = $this->imageModel->getImages(self::DB_TABLE, $id); //Pegando as imagens pelo $id
    	return new Projeto($result[self::ID_COLUMN],
    					   $result[self::NAME_COLUMN],
    					   $result[self::DESCRIPTION_COLUMN],
    					   $images,
    					   $result[self::DATA_COLUMN],
                           $result[self::SLUG_COLUMN]
    						);	//Criação de um objeto Projeto a partir do dados buscado no banco
    }

    //Método semelhante ao "public function get(int $id)" porém agora o parâmetro é o nome
    //**Necessita de revisão pois pode acontecer de ter projetos com o mesmo nome
    public function getByName(string $nome){
    	$this->db->where(self::NAME_COLUMN, $nome);
    	$row = $this->db->get(self::DB_TABLE)->row_array();
    	$images = $this->imageModel->getImages(self::DB_TABLE, $row[self::ID_COLUMN]);
    	return new Projeto($row[self::ID_COLUMN],
    					   $row[self::NAME_COLUMN],
    					   $row[self::DESCRIPTION_COLUMN],
    					   $images,
    					   $row[self::DATA_COLUMN],
                           $row[self::SLUG_COLUMN]
    						);
    }
    public function getBySlug(string $slug){
        $this->db->where(self::SLUG_COLUMN, $slug); // Where slug = $slug
        $row = $this->db->get(self::DB_TABLE)->row_array(); //Resultado da busca no banco pelo id 
        $images = $this->imageModel->getImages(self::DB_TABLE, $row[self::ID_COLUMN]); //Pegando as 
        return new Projeto($row[self::ID_COLUMN],
                           $row[self::NAME_COLUMN],
                           $row[self::DESCRIPTION_COLUMN],
                           $images,
                           $row[self::DATA_COLUMN],
                           $row[self::SLUG_COLUMN]
                            );
    }
    //Método de inserção no banco 
    public function insert(Projeto $projeto){
    	$this->db->insert(self::DB_TABLE, $projeto->serializeSQL()); //Inserindo apenas id, nome, descrição e data
    	if($this->successQuery()){
    		//Inserção das imagens
    		if($this->imageModel->insertImages(self::DB_TABLE, $this->db->insert_id(),$projeto->getImagens())) {
    			$this->log(self::DB_TABLE, Log::INSERT);
            	return true;
    		}
            
        }
        return false;
    	
    }

    public function update(Projeto $projeto){
    	//Por enquanto não realiza update de imagens
    	$this->db->where(self::ID_COLUMN, $projeto->getID());
    	$this->db->update(self::DB_TABLE, $projeto->serializeSQL());
    	if($this->successQuery()){    		
    			$this->log(self::DB_TABLE, Log::UPDATE);
            	return true; 
        }
        return false;
    }


    public function remove(Projeto $projeto){    	
    	$images = $this->imageModel->getImages(self::DB_TABLE, $projeto->getID()); //pegando as imagens do projeto
    	$this->db->where("id_projeto", $projeto->getID()); 
    	if($this->db->delete(self::DB_PROJECT_IMG)){ // Remoção de projeto_imagem para que seja possivel remover as imagens e o projeto referido
    		if($this->imageModel->deleteImages($images)){ //Remoção das imagens
    			$this->db->where(self::ID_COLUMN, $projeto->getID());
    			if($this->db->delete(self::DB_TABLE)){ //Removendo a tabela do projeto
    				$this->log(self::DB_TABLE, Log::DELETE);
            		return true;
    			}
    		}
    	}
    	return false;
    	
    }

    public function list(){
        $result = $this->db->get(self::DB_TABLE)->result_array();
        $projetos = array();
        foreach ($result as $key => $value) {
            $images = $this->imageModel->getImages(self::DB_TABLE, $value[self::ID_COLUMN]);
            $projetos[$key] = new Projeto($value[self::ID_COLUMN],
                                          $value[self::NAME_COLUMN],
                                          $value[self::DESCRIPTION_COLUMN],
                                          $images,
                                          $value[self::DATA_COLUMN]);
        }
        return $projetos;
    }

    public function getRecent($limit = 4, $inicio = 0){
        $this->db->select("*");
        $this->db->order_by(self::DATA_COLUMN, 'DESC');
        $this->db->limit($limit, $inicio);
        $row = $this->db->get(self::DB_TABLE)->result_array();
        if(count($row) > 0){
            $projetos = array();
            foreach ($row as $key => $value) {
                $images = $this->imageModel->getImages(self::DB_TABLE, $value[self::ID_COLUMN]);
                $projetos[$key] = new Projeto($value[self::ID_COLUMN],
                                          $value[self::NAME_COLUMN],
                                          $value[self::DESCRIPTION_COLUMN],
                                          $images,
                                          $value[self::DATA_COLUMN],
                                          $value[self::SLUG_COLUMN]);
        }
        return $projetos;
        }
        else return false;
    }

    public function countAll(){
        return $this->db->count_all(self::DB_TABLE);
    }

}


?>