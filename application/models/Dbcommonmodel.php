<?php
/**
*
* ClassName: DbCommonModel
*
*  xxx  数据模型
*
* @author chenxiaojun
*
*/
class DbCommonModel extends CI_Model {

	/**
	*  xxx   数据库
	*
	* @var string
	*/
	protected $_db = 'default';

	/**
	*  xxx   数据表名
	*
	* @var string
	*/
    protected $_table_name;

	/**
	* 写操作数据库对象
	*
	* @var object
	*/
    protected $_write_db;



    public function __construct() {
        parent::__construct();
        $this->_write_db = $this->load->database($this->_db, TRUE);
    }

	/**
	* 获取 xxx 数据列表
	*
	* @access public
	* @param int $offset 查寻时的偏移量 [Optional]
	* @param int $page_size 每次查寻的记录数 [Optional]
    * @param array/string $map 要查寻的条件 [Optional]
    * @param array/string $order_by 要查寻排序的条件 [Optional]
	* @return array $mixed
	*/
    public function get_pagelist($offset = 0,$page_size = 20,$map = '',$order_by = '') {
    	if($map){
    		$this->db->where($map);
    	}

    	if($order_by){
    		$this->db->order_by($order_by);
    	}

		if(false == ($query = $this->db->limit($page_size, $offset)->get($this->_table_name))){
			log_message('error',"get_pagelist is fail !! sql:".$this->db->last_query());
			return false;
		}

		//var_dump($this->db->last_query());exit;

        return $query->result_array();
    }

	/**
	* 获取 xxx 数据列表
	*
	* @access public
    * @param array/string $map 要查寻的条件 [Optional]
    * @param array/string $order_by 要查寻排序的条件 [Optional]
	* @return array $mixed
	*/
    public function get_list_bymap($map = '',$order_by = '') {
    	if($map){
    		$this->db->where($map);
    	}

    	if($order_by){
    		$this->db->order_by($order_by);
    	}


		if(false == ($query = $this->db->get($this->_table_name))){
			log_message('error',"get_list_bymap is fail !! sql:".$this->db->last_query());
			return false;
		}

		//var_dump($this->db->last_query());exit;

        return $query->result_array();
    }

	/**
	* 获取 xxx 数据总数
	*
	* @access public
    * @param array/string $map 要查寻的条件 [Optional]
	* @return array $mixed
	*/
    public function get_count($map = '') {
    	if($map){
    		$this->db->where($map);
    	}

		$rs = $this->db->count_all_results($this->_table_name);
		//var_dump($this->db->last_query());exit;

        return $rs;
    }

    /**
    * 添加 xxx 信息
    *
    * @access public
    * @param array $data 单个 xxx 信息 [Must]
    * @return int $mixed
    */
    public function add($data) {
		if(!is_array($data) || empty($data)){
			log_message('error',"add param is error !! data:".json_encode($data));
			return false;
		}

		if(false == ($this->_write_db->insert($this->_table_name,$data))){
			log_message('error',"add is fail !! sql:".$this->_write_db->last_query());
			return false;
		}

		//echo $this->_write_db->last_query();

		return $this->_write_db->insert_id();
    }


    /**
    * 获取指定 xxx 信息
    *
    * @access public
    * @param int $id 指定 xxx 的id [Must]
    * @return array $mixed
    */
    public function get_info($id) {
		if(empty($id)){
			log_message('error',"get_info param is error !! ");
			return false;
		}

		$map['id'] = $id;

		return $this->get_info_bymap($map);
    }


    /**
    * 获取指定条件 单条xxxx 信息
    *
    * @access public
    * @param array/string $map 要查寻的条件 [Optional]
    * @param array/string $order_by 要查寻排序的条件 [Optional]
    * @return array $mixed
    */
    public function get_info_bymap($map = '',$order_by = '') {
    	if($map){
    		$this->db->where($map);
    	}

    	if($order_by){
    		$this->db->order_by($order_by);
    	}

    	if(false == ($query = $this->db->get($this->_table_name))){
			log_message('error',"get_info_bymap is fail !! sql:".$this->db->last_query());
			return false;
    	}
		return $query->row_array();
    }

    /**
    * update
    *
    * @access public
    * @param int $id 要更新的 xxx id [Must]
    * @param array $data 单个 xxx 的信息 [Must]
    * @return bool $mixed
    */
    public function update($id,$data) {
		if(empty($id) || !is_array($data) || empty($data)){
			log_message('error',"update param is error !! id:{$id}--word_data:".json_encode($data));
			return false;
		}

		if(false == ($this->_write_db->where("id",$id)->update($this->_table_name,$data))){
			log_message('error',"update is fail !! sql:".$this->_write_db->last_query());
			return false;
		}

		return true;
    }

    /**
    * 删除指定 xxx
    *
    * @access public
	* @param string/array $map 要查寻的 xxx  条件 [Must]
    * @return string $mixed
    */
    public function del($map) {
		if(empty($map)){
			log_message('error',"del param is error !! map:".json_encode($map));
			return false;
		}

        $this->_write_db->where($map)->delete($this->_table_name);
        return $this->_write_db->affected_rows();
    }

    /**
    * 更新指定map xxx
    *
    * @access public
	* @param string/array $map 要更新的 xxx  条件 [Must]
    * @param array $data 要更新 xxx 的信息 [Must]
    * @return bool $mixed
    */
    public function update_bymap($map,$data) {
		if(empty($map) || empty($data)){
			log_message('error',"update_bymap param is error !! map:".json_encode($map)."--data:".json_encode($data));
			return false;
		}

		if(false == ($this->_write_db->where($map)->update($this->_table_name,$data))){
			log_message('error',"update_bymap is fail !! sql:".$this->_write_db->last_query());
			return false;
		}

		return true;
    }

    /**
    * 删除指定id为的 xxx 信息
    *
    * @access public
    * @param int $id 指定 xxx 的id [Must]
    * @return array $mixed
    */
    public function delinfo_byid($id) {
		if(empty($id)){
			log_message('error',"delinfo_byid param is error !! ");
			return false;
		}

		$map['id'] = $id;
		$this->_write_db->where($map)->delete($this->_table_name);
        return $this->_write_db->affected_rows();
    }

    /**
    * 获取本表所有字段
    *
    * @access public
    * @return array $mixed
    */
    public function get_fields() {
		return $this->db->list_fields($this->_table_name);
    }
}