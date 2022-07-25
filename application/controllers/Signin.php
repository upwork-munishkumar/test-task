<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller{

	/*
		* Signin class to set user session and redirect them to welcome page
		* Libraries: Session, form_validation
	*/
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	/*
		* Method used for setting user data in session
		* Conditions:
			* User should be active and verified by email
	*/
	public function index(){
		$data['page_title'] = 'User Signin';
		//Validation for login form
		$this->form_validation->set_rules('emailid','Email id','required|valid_email');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run()){
			$email 		= $this->input->post('emailid');
			$password 	= md5($this->input->post('password'));
			$this->load->model('Signin_Model');
			$validate 	= $this->Signin_Model->authenticate($email,$password);
			if($validate){
				if ($validate->status == 0 || $validate->verified == 0) {
					$this->session->set_flashdata('error','Your email is not verified yet!');
					redirect('signin');	
				}
				$this->session->set_userdata('uid',$validate->id);	
				$this->session->set_userdata('name',$validate->name);
				$this->session->set_userdata('role',$validate->role);	
				redirect('welcome');
			} else {
				$this->session->set_flashdata('error','Invalid login details.Please try again.');
				redirect('signin');
			}
		} else{
			$this->load->view('signin', $data);	
		}
	}
}