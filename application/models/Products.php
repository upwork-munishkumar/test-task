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

	/**
    *   GET PRODUCTS COUNT WHICH ARE ACTIVE BUT NOT ATTACHED TO ANY USER
    */
	public function acitve_products_but_not_attached_count()
	{
		$this->db->select("*"); 
		$this->db->from('products');
		$this->db->where('status', 1);
		$this->db->where('products.id NOT IN (select product_id from `user-products`)',NULL,FALSE);
		return $this->db->get()->num_rows();	
	}

}