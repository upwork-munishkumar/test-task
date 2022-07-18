<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model{

    /**
    *   GET ACTIVE AND VERIFIED USERS COUNT
    */
    public function active_and_verified_users(){
    	$this->db->select("*"); 
		$this->db->from('users');
		$this->db->where(['status' => 1, 'verified' => 1]);
		return $this->db->get()->num_rows();
	}
}