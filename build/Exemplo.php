<?php

define("NO_ID", -1, true);

//Noticia.php
class Noticia{
	private $id;
	private $titulo;
	private $caminhoImagens;
	private $descricao;

	public function __construct(int $id,string $titulo, array $caminhoImagens, string $descricao){
		$this->id = $id;
		$this->titulo = $titulo;
		$this->caminhoImagens = caminhoImagens;
		$this->descricao = $descricao;
	}

	public function getID(){ return $this->id; }
	public function getTitulo(){ return $this->titulo; }
	public function getImagens(){ return $this->caminhoImagens; }
	public function getDescricao(){ return $this->descricao; }
}

//Controller.php
class Controller extends CI_Controller{

	public function __construct(){
		$this->load->model('Noticia_Model', 'noticia_model');
	}

	public function RegistraNoticia(){
		$titulo = $this->input->post('titulo');
		$descricao = $this->input->post('descricao');
		$imagens = getImagens();
		$this->noticia_model->insert(
			new Noticia(NO_ID, $titulo, $imagens, $descricao);
		)
	}
}

//Noticia_Model.php
class Noticia_Model extends My_Model{

	public function __construct(){
		parent::__construct();
		$this->load->model('ImageHandler_model', 'image_model');
	}

	public function get($id){
		$this->db->where('id', $id);
		$result = $this->db->get('noticia')->result();
		$imagens = $this->image_model->getImagens(NOTICIA, $id);
		return new Noticia($id, $result[0]->titulo, $imagens, $result[0]->descricao);
	}

	public function insert(Noticia $Noticia){
		//Executa ações para inserir...
		$data = array(
			'titulo' => $Noticia->getTitulo(),
			'descricao' => $Noticia->getDescricao()
		)
		$this->db->insert('noticia');
		if($this->successQuery()){
			$this->image_model->insert(NOTICIA, $Noticia->getImagens());
			$this->log('noticia', INSERT);
		}
	}

	public function update(int $id, Noticia $Noticia){
		//Executa ações para dar update...
		$data = array(
			'titulo' => $Noticia->getTitulo(),
			'descricao' => $Noticia->getDescricao()
		)
		$this->db->where('id', $id);
		$this->db->update('noticia');
		if($this->successQuery()){
			$this->image_model->update(NOTICIA, $Noticia->getImagens());
			$this->log('noticia', UPDATE);
		}
	}

	public function remove(Noticia $Noticia){
		$this->removeById($Noticia->getID());
	}

	public function removeById(int $id){
		//Executa ações para remover
		$this->db->where('id', $id);
		$this->db->delete('noticia');
		if($this->successQuery()){
			$this->image_model->delete(NOTICIA, $id);
			$this->log('noticia', DELETE);
		}
	}
}

?>