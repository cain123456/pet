<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_Model extends CI_Model {
    public function __construct()
    {
        parent::__construct();

        $this->load->model('db/index_db_model');
    }
}