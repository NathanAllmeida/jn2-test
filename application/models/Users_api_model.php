<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_api_model extends MY_Model{
	public function __construct(){
        $this->table = 'users_api';
        $this->primary_key = 'user_api_id';
        $this->return_as = 'array';
        $this->timestamps = TRUE;

	    $this->cache_driver = 'file';
		$this->cache_prefix = 'mm';
        $this->delete_cache_on_save = true;

		parent::__construct();
	}
}
