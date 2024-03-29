<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_Model extends CI_Model{

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

	/**
    *   GET SUM OF ACTIVE AND ATTACHED PRODUCTS QUANTITY
    */
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

	/**
    *   GET SUM OF ACTIVE AND ATTACHED PRODUCTS PRICE
    */
	public function acitve_and_attached_products_price_sum()
	{
		$this->db->select("SUM(user_products.quantity * user_products.product_price) as active_attached_products_price_sum"); 
		$this->db->from('user_products');
		$this->db->join('users','users.id = user_products.user_id','left');
		$this->db->join('products','products.id = user_products.product_id','left');		
		$this->db->where('users.status', 1);
		$this->db->where('users.verified', 1);
		$this->db->where('products.status', 1);
		return $this->db->get()->result_array();
	}

	/**
    *   GET SUM OF ACTIVE AND ATTACHED PRODUCTS PRICE BY USER
    */
	public function acitve_and_attached_products_price_sum_by_user()
	{
		$this->db->select("users.id, users.name, SUM(user_products.quantity * user_products.product_price) as current_user_active_attached_products_price_sum"); 
		$this->db->from('user_products');
		$this->db->join('users','users.id = user_products.user_id','left');
		$this->db->join('products','products.id = user_products.product_id','left');		
		$this->db->where('users.status', 1);
		$this->db->where('users.verified', 1);
		$this->db->where('products.status', 1);
		$this->db->group_by('user_products.user_id');
		return $this->db->get()->result_array();
	}

	/*
		* Inserting new product
	*/
	public function insertProduct($data=array())
	{
		$this->db->insert('products',$data);
		return $this->db->insert_id();
	}

	/*
		* Updating the product
	*/
	public function updateProduct($data=array(), $id='')
	{
		$this->db->where('id', $id);
		return $this->db->update('products', $data);
	}

	/*
		* Attaching the product in user list
	*/
	public function assignProduct($data=array())
	{
		return $this->db->insert('user_products',$data);
	}

	/*
		* Update the attached product from user list
	*/
	public function update_assignedProduct($data=array(), $user_product_id='')
	{
		$this->db->where('id', $user_product_id);
		return $this->db->update('user_products', $data);
	}

	/*
		* Deleting the product from user list
	*/
	public function deleteProduct($id='', $user_id='')
	{
		$this->db->where('product_id', $id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete('user_products');
	}
}