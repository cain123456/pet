<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Pet extends C_Controller {
	public function __construct(){
		parent::__construct();
		 $this->load->model('home/index_model');
		// $this->load->model('invite_model');
		// $this->load->model('companyauth_model');
		// $this->load->model('index_model');
		// $this->load->helper('cookie');
		// $this->init();
	}
	public function index()
	{
		$this->load->view('home/index');
		

	}
}
