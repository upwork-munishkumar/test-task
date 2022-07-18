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
		$this->db->where('products.id NOT IN (select product_id from `user_products`)',NULL,FALSE);
		return $this->db->get()->num_rows();	
	}

	public function acitve_and_attached_products_quantity()
	{
		$this->db->select("SUM(user_products.quantity) as active_attached_products_quantity"); 
		$this->db->from('user_products');
		$this->db->join('users','users.id = user_products.user_id','left');
		$this->db->join('products','products.id = user_products.product_id','left');		
		$this->db->where('users.status', 1);
		$this->db->where('users.verified', 1);
		$this->db->where('products.status', 1);
		return $this->db->get()->result_array();
	}

}