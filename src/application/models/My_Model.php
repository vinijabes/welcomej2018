<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(BASEPATH."core/Model.php");

class My_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$_SESSION['user_id'] = 1;
	}

	public function log($table, $operation){
		$id = $_SESSION['user_id'];
		$ip = get_client_ip_server();
		$data = array(
			LOG::TABELA_COLUMN     => $table,
			LOG::OPERACAO_COLUMN   => $operation,
			LOG::USUARIO_ID_COLUMN => $id,
			LOG::IP_COLUMN 		   => $ip
		);

		$this->db->insert(Log::DB_TABLE, $data);
	}

	public function successQuery(){
		return $this->db->affected_rows();
	}
}

class Log{
	const UPDATE = "Update";
	const INSERT = "Insert";
	const DELETE = "Delete";
	const DB_TABLE = "log";
	const TABELA_COLUMN = "tabela";
	const OPERACAO_COLUMN = "operacao";
	const USUARIO_ID_COLUMN = "usuario_id";
	const IP_COLUMN = "ip";
}

function get_client_ip_server() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


?>