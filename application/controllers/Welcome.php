<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Users');
        $this->load->model('Products_Model');
		if(!$this->session->userdata('uid'))
			redirect('signin');
	}

	public function index()
	{
		$userfname 										= $this->session->userdata('name');
		$data['name']									= $userfname;
		$acitve_user_count 								= $this->Users->active_and_verified_users();
		$acitve_user_products_count 					= $this->Users->active_users_attached_products();
		$acitve_products_count 							= $this->Products_Model->active_products_count();
		$acitve_products_but_not_attached_count 		= $this->Products_Model->acitve_products_but_not_attached_count();
		$acitve_and_attached_products_quantity 			= $this->Products_Model->acitve_and_attached_products_quantity();
		$acitve_and_attached_products_price_sum 		= $this->Products_Model->acitve_and_attached_products_price_sum();
		$acitve_and_attached_products_price_sum_by_user = $this->Products_Model->acitve_and_attached_products_price_sum_by_user();
		$data['page_title'] 							= 'Welcome';
		$data['acitve_user_count'] 						= $acitve_user_count;
		$data['acitve_user_products_count'] 			= $acitve_user_products_count;
		$data['acitve_products_count'] 					= $acitve_products_count;
		$data['acitve_products_but_not_attached_count']	= $acitve_products_but_not_attached_count;
		$data['acitve_and_attached_products_quantity']  = (isset($acitve_and_attached_products_quantity[0]) && isset($acitve_and_attached_products_quantity[0]['active_attached_products_quantity']))?$acitve_and_attached_products_quantity[0]['active_attached_products_quantity']:0; 
		$data['acitve_and_attached_products_price_sum']  		= (isset($acitve_and_attached_products_price_sum[0]) && isset($acitve_and_attached_products_price_sum[0]['active_attached_products_price_sum']))?$acitve_and_attached_products_price_sum[0]['active_attached_products_price_sum']:0; 
		$data['acitve_and_attached_products_price_sum_by_user']	= $acitve_and_attached_products_price_sum_by_user;
		$this->load->view('welcome',$data);
	}
}
