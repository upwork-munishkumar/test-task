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
 	}

 	/*
		To display count of active and verified user on Dashboard Page. 
 	*/
	public function index()
	{
		$acitve_user_count 			= $this->Users->active_and_verified_users();
		$data['page_title'] 		= 'Dashboard';
		$data['acitve_user_count'] 	= $acitve_user_count;
		$this->load->view('dashboard', $data);
	}
}
