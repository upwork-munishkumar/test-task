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
		Display stats of USERS and PRODUCTS and Their PRICES. 
 	*/
	public function index()
	{
		$acitve_user_count 								= $this->Users->active_and_verified_users();
		$acitve_user_products_count 					= $this->Users->active_users_attached_products();
		$acitve_products_count 							= $this->Products->active_products_count();
		$acitve_products_but_not_attached_count 		= $this->Products->acitve_products_but_not_attached_count();
		$acitve_and_attached_products_quantity 			= $this->Products->acitve_and_attached_products_quantity();
		$acitve_and_attached_products_price_sum 		= $this->Products->acitve_and_attached_products_price_sum();
		$acitve_and_attached_products_price_sum_by_user = $this->Products->acitve_and_attached_products_price_sum_by_user();
		$data['page_title'] 							= 'Dashboard';
		$data['acitve_user_count'] 						= $acitve_user_count;
		$data['acitve_user_products_count'] 			= $acitve_user_products_count;
		$data['acitve_products_count'] 					= $acitve_products_count;
		$data['acitve_products_but_not_attached_count']	= $acitve_products_but_not_attached_count;
		$data['acitve_and_attached_products_quantity']  = (isset($acitve_and_attached_products_quantity[0]) && isset($acitve_and_attached_products_quantity[0]['active_attached_products_quantity']))?$acitve_and_attached_products_quantity[0]['active_attached_products_quantity']:0; 
		$data['acitve_and_attached_products_price_sum']  = (isset($acitve_and_attached_products_price_sum[0]) && isset($acitve_and_attached_products_price_sum[0]['active_attached_products_price_sum']))?$acitve_and_attached_products_price_sum[0]['active_attached_products_price_sum']:0; 
		$data['acitve_and_attached_products_price_sum_by_user']	= $acitve_and_attached_products_price_sum_by_user;
		$this->load->view('dashboard', $data);
	}


	/*
		CONVERT CURRENCY FROM EURO TO USD AND RON 
 	*/
	public function change_currency()
	{
		$method_response = array();
		$method_response['status'] = 'error';

		$selected_currency 	= $this->input->post('selected_currency');
		$current_price 		= $this->input->post('current_price');

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=".$selected_currency."&from=EUR&amount=".$current_price,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/plain",
		    "apikey: 9tE9u7JwTByTd7v3YhJJKwIqBc1FhbDG"
		  ),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET"
		));

		$response = curl_exec($curl);
		curl_close($curl);
		
		$currency_converter_res = json_decode($response, true);

		if (isset($currency_converter_res['success']) && $currency_converter_res['success'] == 1) {
			$method_response['status'] = 'success';
			$method_response['converted_price'] = $currency_converter_res['result'];
		}
		die(json_encode($method_response));
	}
}
