<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin_Model extends CI_Model{

	/*
		* Verify if user with email and password exists in DataBase
	*/
	public function authenticate($email,$password){
		$data=array(
			'email' 	=> $email,
			'password' 	=> $password
		);
		$query = $this->db->where($data);
		$login = $this->db->get('users');
 		if($login!=NULL){
			return $login->row();
 		}  
	}
}