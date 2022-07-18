<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Dashboard/Stats Page for this controller.
	 *
	 * This page will display stats from DB
	*/

	public function __construct(){
		parent::__construct();
        $this->load->model('Users');
        $this->load->model('Products');   
 	}

 	/*
		To display count of active and verified user on Dashboard Page. 
 	*/
	public function index()
	{
		$acitve_user_count 								= $this->Users->active_and_verified_users();
		$acitve_user_products_count 					= $this->Users->active_users_attached_products();
		$acitve_products_count 							= $this->Products->active_products_count();
		$acitve_products_but_not_attached_count 		= $this->Products->acitve_products_but_not_attached_count();
		$acitve_and_attached_products_quantity 			= $this->Products->acitve_and_attached_products_quantity();
		$acitve_and_attached_products_price_sum 		= $this->Products->acitve_and_attached_products_price_sum();
		$data['page_title'] 							= 'Dashboard';
		$data['acitve_user_count'] 						= $acitve_user_count;
		$data['acitve_user_products_count'] 			= $acitve_user_products_count;
		$data['acitve_products_count'] 					= $acitve_products_count;
		$data['acitve_products_but_not_attached_count']	= $acitve_products_but_not_attached_count;
		$data['acitve_and_attached_products_quantity']  = (isset($acitve_and_attached_products_quantity[0]) && isset($acitve_and_attached_products_quantity[0]['active_attached_products_quantity']))?$acitve_and_attached_products_quantity[0]['active_attached_products_quantity']:0; 
		$data['acitve_and_attached_products_price_sum']  = (isset($acitve_and_attached_products_price_sum[0]) && isset($acitve_and_attached_products_price_sum[0]['active_attached_products_price_sum']))?$acitve_and_attached_products_price_sum[0]['active_attached_products_price_sum']:0; 
		
		$this->load->view('dashboard', $data);
	}
}
