<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	/*
		* Logout class to unset user session and redirect them back to signin page
		* Libraries: Session
	*/

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	/*
		* Method used for unset user data from session
	*/
	public function index(){
		$this->session->unset_userdata('uid');
		$this->session->sess_destroy();
		return redirect('signin');
	}
}