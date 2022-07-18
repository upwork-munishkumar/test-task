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
		$acitve_user_count 						= $this->Users->active_and_verified_users();
		$acitve_user_products_count 			= $this->Users->active_users_attached_products();
		$acitve_products_count 					= $this->Products->active_products_count();
		$data['page_title'] 					= 'Dashboard';
		$data['acitve_user_count'] 				= $acitve_user_count;
		$data['acitve_user_products_count'] 	= $acitve_user_products_count;
		$data['acitve_products_count'] 			= $acitve_products_count;
		$this->load->view('dashboard', $data);
	}
}
