<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once(APPPATH.'controllers/AuthLog.php');

class MY_Controller extends AuthLog{

	public function __construct(){
		parent::__construct();
	}

}