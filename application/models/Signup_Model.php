<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Signup_Model extends CI_Model{

	/*
		* Inserting new user in DataBase
	*/
	public function insertUser($fname,$lname,$emailid,$password){
		$data=array(
			'name'		=> $fname." ".$lname,
			'email'		=> $emailid,
			'password'	=> $password
		);
		return $this->db->insert('users',$data);
	}

	/*
		* Verify is user with email exist in DataBase
		* if exist marked as activate and verify.
	*/
	public function verifyEmailID($email='')
	{
		$data = array('status' => 1, 'verified' => 1, 'updated_at' => date('Y-m-d H:i:s'));
        $this->db->where('md5(email)', $email);
        return $this->db->update('users', $data);
	}
}