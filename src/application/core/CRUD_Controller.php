<?php defined('BASEPATH') OR exit('No direct script access allowed');


class CRUD_Controller extends CI_Controller{


	public $attributes;
	public $search_fields;
	public $table;
	public $limit_per_page;
	public $offset;
	public $db_table;
	public $ordering;
	public $controller;
	public $verbose_name;

	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		

	}
	public function save(){
		
		$this->db->insert($this->db_table, $this->input->post());
		$this->session->set_flashdata('success',TRUE);
		redirect(base_url($this->controller));
	}


	public function update($id){
		$this->db->where('id', $id);
		$this->db->update($this->db_table, $this->input->post());
		$this->session->set_flashdata('success',TRUE);
		redirect(base_url($this->controller));
	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->db_table);
		$this->session->set_flashdata('success',TRUE);
		redirect(base_url($this->controller));
	}

	public function load_view_create(){
		$data['attributes'] = $this->attributes;
		$data['controller'] = $this->controller;
		$data['verbose_name'] = $this->verbose_name;
		$this->load->view('generic_view_create', $data);
	}

	public function load_view_detail($id){
		$this->db->where('id', $id);
		$data['object'] = $this->db->get($this->db_table)->row_array();
		$data['attributes'] = $this->attributes;
		$data['controller'] = $this->controller;
		$data['verbose_name'] = $this->verbose_name;
		$this->load->view('generic_view_detail', $data);
	}


	public function load_view_list(){
		
	    
		if($this->offset == null) $this->offset = 0;
	 

	  	$this->table['class'] = $this->__format_class();
	  	

		$this->db->order_by($this->ordering[0], $this->ordering[1]);
		$this->db->limit($this->limit_per_page, $this->offset);
		

		if($this->input->post('search') != ''){
			if(count($this->search_fields) > 0)
				$this->db->like($this->search_fields[0], $this->input->post('search'));
			if(count($this->search_fields) > 1){
				for($i = 1 ; $i < count($this->search_fields); $i++){
					$this->db->or_like($this->search_fields[$i], $this->input->post('search'));
				}
			}
		}

		$objects = $this->db->get($this->db_table);
		$total = $this->db->get($this->db_table)->num_rows();
	
		$data['objects'] = $objects->result_array();


		$config['base_url'] = base_url($this->controller.'/index/');
		$config['total_rows'] = $total; 
		$config['per_page'] = $this->limit_per_page; 
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = "</ul>";
		$config['first_link'] = FALSE; 
		$config['last_link'] = FALSE; 
		$config['first_tag_open'] = "<li>";
		$config['first_tar_close'] = "</li>";
		$config['prev_link'] = "Anterior";
		$config['prev_tag_open'] = "<li class='prev'>";
		$config['prev_tag_close'] = "</li>";
		$config['next_link'] = "Proximo";
		$config['next_tag_open'] = "<li class='next'>";
		$config['next_tag_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class='active'><a href='#'>";
		$config['cur_tag_close'] = "</a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['num_links'] = 3; 


		$this->pagination->initialize($config);

		$data['table'] = $this->table;
		$data['search_fields'] = $this->search_fields;
		$data['pagination'] = $this->pagination->create_links();
		$data['controller'] = $this->controller;
		$data['verbose_name'] = $this->verbose_name;


		$this->load->view('generic_view_list', $data);

	}


	private function __format_class(){
		$html = '';

		for($i = 0; $i < count($this->table['class']); $i++){
			$html .= $this->table['class'][$i].' ';
		}
		return $html;
	}
}