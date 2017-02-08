<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Controller extends CI_Controller {
	/**所有model、控制器里，均可直接使用 $this->c_id 形式 获取。
	 在 library 里，使用 $CI->c_id 形式**/
	 // public $a_id ;
	 // public $a_role;
	 // public $a_username;

	function __construct() {
		parent::__construct();
		//$this->init();
		$this->load->model('DbCommonModel');
	}
}