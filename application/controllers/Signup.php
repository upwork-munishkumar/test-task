<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
  
	/*
		* Signup class to insert new user
		* Libraries: Session, form_validation, email
		* Models: Signup_Model
	*/
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Signup_Model');
    }

    /*
		* Method used for creating new user
		* Conditions:
			* Unique email from users table
		* Send verification email
	*/
	public function index() {
        $data['page_title'] = 'Signup';
        //Form Validation
        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
        $this->form_validation->set_rules('emailid', 'EmailId', 'required|valid_email|is_unique[users.Email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|min_length[6]|matches[password]');
        $this->form_validation->set_message('is_unique', 'This email is already exists.');
        if ($this->form_validation->run()) {
            //Getting Post Values
            $fname 		= $this->input->post('firstname');
            $lname 		= $this->input->post('lastname');
            $emailid 	= $this->input->post('emailid');
            $password 	= md5($this->input->post('password'));
            $insertUser = $this->Signup_Model->insertUser($fname, $lname, $emailid, $password);
            if($insertUser){
            	if ($this->sendEmail($emailid)) {
            		$this->session->set_flashdata('success','You are Successfully Registered! Please confirm the mail sent to your Email-ID!');	
				}else {
					$this->session->set_flashdata('error','Something went wrong. Please try again.');	
					redirect('signup');	
				}
			}else {
				$this->session->set_flashdata('error','Something went wrong. Please try again.');	
				redirect('signup');	
			} 
        }
        $this->load->view('signup', $data);
    }


    /*
		* Method used for sending email for verification
	*/
	public function sendEmail($email='')
    {

    	$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.totalncare.com',
			'smtp_port' => 587,
			'smtp_user' => 'testingsmtp@totalncare.com',
			'smtp_pass' => '[qD]TeT0K[&p',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
    	$this->load->library('email', $config);
    	$subject 	= 'Verify Your Email Address';
        $message 	= 'Dear User,<br /><br />Please click on the below activation link to verify your email address.<br /><br />'.base_url('user/verify/'). md5($email) . '<br /><br /><br />Thanks<br />Coding Test';
        
		$this->email->set_newline("\r\n");
		$this->email->from('testingsmtp@totalncare.com');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);
      	if($this->email->send())
     	{
      		return TRUE;
     	}
     	return FALSE;
    }


    /*
		* Method used for verifying and actiavting users by clicking links sent on email.
	*/
	public function verify($hash=NULL){
        if ($this->Signup_Model->verifyEmailID($hash)){
            $this->session->set_flashdata('verify_msg','<div class="alert alert-success text-center">Your Email Address is successfully verified! Please login to access your account!</div>');
            redirect('signin');
        }else {
            $this->session->set_flashdata('verify_msg','<div class="alert alert-danger text-center">Sorry! There is error verifying your Email Address!</div>');
            redirect('signup');
        }
    }
}