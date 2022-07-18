<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Model{

    /**
    *   GET ACTIVE PRODUCTS COUNT
    */
    public function active_products_count(){
    	$this->db->select("*"); 
		$this->db->from('products');
		$this->db->where('status', 1);
		return $this->db->get()->num_rows();
	}

}