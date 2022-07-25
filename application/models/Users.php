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

	/**
    *   GET ACTIVE AND VERIFIED USERS ATTACHED PRODUCT COUNT
    */
    public function active_users_attached_products()
	{
		$this->db->select("user_products.*,users.*"); 
		$this->db->from('user_products');
		$this->db->join('users','users.id = user_products.user_id','left');
		$this->db->where('users.status', 1);
		$this->db->where('users.verified', 1);
		$this->db->group_by('user_products.user_id');
		return $this->db->get()->num_rows();
	}

	/**
    *   GET ACTIVE AND VERIFIED USERS ATTACHED PRODUCT LIST
    */
    public function active_users_attached_products_list($user_id='')
	{
		$this->db->select("user_products.product_price, user_products.quantity, products.*"); 
		$this->db->from('user_products');
		$this->db->join('products','products.id = user_products.product_id','left');
		$this->db->join('users','users.id = user_products.user_id','left');
		$this->db->where('users.status', 1);
		$this->db->where('users.verified', 1);
		$this->db->where('products.status', 1);
		$this->db->where('user_products.user_id', $user_id);
		$this->db->group_by('user_products.product_id');
		return $this->db->get()->result();	
	}

	/**
    *   GET PRODUCT DATA
    */
    public function active_users_attached_productsDetails($user_id='', $product_id='')
	{
		$this->db->select("user_products.product_price, user_products.quantity, user_products.id as user_product_id, products.*"); 
		$this->db->from('user_products');
		$this->db->join('products','products.id = user_products.product_id','left');
		$this->db->join('users','users.id = user_products.user_id','left');
		$this->db->where('users.status', 1);
		$this->db->where('users.verified', 1);
		$this->db->where('products.status', 1);
		$this->db->where('products.id', $product_id);
		$this->db->where('user_products.user_id', $user_id);
		return $this->db->get()->result();	
	}

}