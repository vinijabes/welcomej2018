<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."models/Search_filter.php");

class ListMaker{

	public function getLinks(searchFilter $filter, $model){
		$CI = &get_instance();
		$CI->load->library("pagination");

		$attribute = $filter->getAttribute();
		$order_by = $filter->getOrderBy();
		$quantidade = $filter->getLimit();
		$nome = $filter->getLike();

		$num_rows = $model->num_rows($filter);
                $db_Table = $filter->getDB();
                $db_Table[0] = strtoupper($db_Table[0]); 
		$config['base_url'] = base_url($db_Table.'//visualizar/'.$attribute.'/'.$order_by.'/'.$quantidade.'/'.$nome.'/');
        $config['total_rows'] = $num_rows; 
        $config['per_page'] = $quantidade; 
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

        $CI->pagination->initialize($config);
        return $CI->pagination->create_links();
	}

}

?>