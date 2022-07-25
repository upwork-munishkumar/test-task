<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	/*
		* Product class to insert, edit, update and delete products
		* Libraries: Session, form_validation
		* Models: Users, Products_Model
	*/
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('Users');
        $this->load->model('Products_Model');
		if(!$this->session->userdata('uid'))
			redirect('signin');
	}

	/*
		* Method used for listing all products of user
	*/
	public function index()
	{
		$userfname 			= $this->session->userdata('name');
		$useruid 			= $this->session->userdata('uid');
		$userRole 			= $this->session->userdata('role');
		$data['name']		= $userfname;
		$data['userRole']	= $userRole;
		$data['page_title']	= 'Products';
		if ($userRole == 2) {
			$data['list'] 		= $this->Users->active_users_attached_products_list($useruid);
		}else{
			$data['list'] 		= $this->Users->products_list_for_admin();
		}
		$this->load->view('products',$data);
	}

	/*
		* Method for inserting for new product
	*/
	public function add()
	{
		$data['page_title'] = 'Add Product';
        //Form Validation
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        if (empty($_FILES['image']['name'])){
		    $this->form_validation->set_rules('image', 'Image', 'required');
		}
        if ($this->form_validation->run()) {
            
            $uplaodData = $this->upload_image($_FILES['image']);
            //Getting Post Values
            $insertData['title'] 		= $this->input->post('title');
            $insertData['image'] 		= $uplaodData['file_name'];
            $insertData['description'] 	= $this->input->post('description');
            $insertData['status'] 		= 1;
            $insertedProduct 			= $this->Products_Model->insertProduct($insertData);
            if ($insertedProduct) {
	            $assignProduct['quantity'] 		= $this->input->post('quantity');
	            $assignProduct['product_price']	= $this->input->post('price');
	            $assignProduct['user_id'] 		= $this->session->userdata('uid');
	            $assignProduct['product_id'] 	= $insertedProduct;
	            $assignedProduct 				= $this->Products_Model->assignProduct($assignProduct);
            	if($assignedProduct){
	            	$this->session->set_flashdata('success','Product has been added succesfully!');
					redirect('products');
				}else {
					$this->session->set_flashdata('error','Something went wrong. Please try again.');	
					redirect('add-product');	
				}
            }else {
				$this->session->set_flashdata('error','Something went wrong. Please try again.');	
				redirect('add-product');	
			}
        }
        $this->load->view('add_product', $data);
	}

	/*
		* Method for updating the product
	*/
	public function edit($id='')
	{
		$useruid 			= $this->session->userdata('uid');
		$userRole 			= $this->session->userdata('role');
		$data['userRole']	= $userRole;
		$data['page_title'] = 'Edit Product';
		$product_details 	= $this->Users->active_users_attached_productsDetails($useruid, $id);
		if ($product_details) {
			$data['product_details'] = $product_details;
			$this->form_validation->set_rules('title', 'Title', 'required');
	        $this->form_validation->set_rules('description', 'Description', 'required');
	        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
	        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
	        if ($this->form_validation->run()) {
	        	$updateData['title'] 		= $this->input->post('title');
	        	if (empty($_FILES['image']['name'])){
			    	$updateData['image'] 	= $this->input->post('old_image');
				}else{
					$uplaodData = $this->upload_image($_FILES['image']);
					$updateData['image']	= $uplaodData['file_name'];
				}
	            $updateData['description'] 	= $this->input->post('description');
	            $updatedProduct 			= $this->Products_Model->updateProduct($updateData, $id);
	        	if ($updatedProduct) {
	        		$assignProduct['quantity'] 		= $this->input->post('quantity');
		            $assignProduct['product_price']	= $this->input->post('price');
		            $assignProduct['user_id'] 		= $this->session->userdata('uid');
		            $assignProduct['product_id'] 	= $id;
		            $assignProduct['updated_on'] 	= date('Y-m-d H:i:s');
		            $assignedProduct 				= $this->Products_Model->update_assignedProduct($assignProduct, $this->input->post('user_product_id'));
	            	if($assignedProduct){
		            	$this->session->set_flashdata('success','Product has been updated succesfully!');
						redirect('products');
					}else {
						$this->session->set_flashdata('error','Something went wrong. Please try again.');	
						redirect('edit-product/'.$id);	
					}
	        	}else {
					$this->session->set_flashdata('error','Something went wrong. Please try again.');	
					redirect('edit-product/'.$id);	
				}
	        }
		}else{
			$this->session->set_flashdata('error','Either product is not available or not in your assigned list!');
			redirect('products');
		}
		$this->load->view('edit_products', $data);
	}


	/*
		* Method to view the product
	*/
	public function view($id='')
	{
		$useruid 			= $this->session->userdata('uid');
		$data['page_title'] = 'View Product';
		$product_details 	= $this->Users->active_users_attached_productsDetails($useruid, $id);
		if ($product_details) {
			$data['product_details'] = $product_details;
		}else{
			$this->session->set_flashdata('error','Either product is not available or not in your assigned list!');
			redirect('products');
		}
		$this->load->view('view_product', $data);
	}

	/*
		* Method to delete the product from user list
	*/
	public function remove($id='')
	{
		$useruid 		= $this->session->userdata('uid');
		$deletedProduct = $this->Products_Model->deleteProduct($id, $useruid);
		if ($deletedProduct) {
			$this->session->set_flashdata('success','Product has been deleted from your list!');
		}else{
			$this->session->set_flashdata('error','Something went wrong. Please try again.');	
		}
		redirect('products');
	}


	/*
		* Method to upload product image
	*/
	public function upload_image($image='')
	{
		$config['upload_path']          = './assets/images/products';
        $config['allowed_types']        = 'gif|jpg|png';
		$new_name 						= time()."-".$_FILES["image"]['name'];
		$config['file_name'] 			= $new_name;
		
        $this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('image')){
			$error = array('error' => $this->upload->display_errors());
        	$this->session->set_flashdata('error',$error['error']);	
			redirect('add-product');
        }else {
        	return $this->upload->data();
        }
	}

	/*
		* This method is for listing all products for not admin users
	*/
	public function add_from_all_products()
	{
		$userfname 			= $this->session->userdata('name');
		$useruid 			= $this->session->userdata('uid');
		$userRole 			= $this->session->userdata('role');
		$userEmail 			= $this->session->userdata('email');
		$data['name']		= $userfname;
		$data['userRole']	= $userRole;
		$data['userEmail']	= $userEmail;
		$data['page_title']	= 'Products List';
		$data['list'] 		= $this->Users->products_list_for_attach();
		$this->load->view('products_list',$data);
	}

	/*
		* Attach the products from list to user
	*/
	public function attach($product_id='')
	{
		$data['page_title'] = 'Edit Product';
		$product_details 	= $this->Users->get_special_edit_for_attach($product_id);
		if ($product_details) {
			$data['product_details'] = $product_details;
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
	        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
	        if ($this->form_validation->run()) {
	        	$updateData['title'] 		= $this->input->post('title');
	        	if (empty($_FILES['image']['name'])){
			    	$updateData['image'] 	= $this->input->post('old_image');
				}else{
					$uplaodData = $this->upload_image($_FILES['image']);
					$updateData['image']	= $uplaodData['file_name'];
				}
	            $updateData['description'] 	= $this->input->post('description');
	            $updatedProduct 			= $this->Products_Model->updateProduct($updateData, $id);
	        	if ($updatedProduct) {
	        		$assignProduct['quantity'] 		= $this->input->post('quantity');
		            $assignProduct['product_price']	= $this->input->post('price');
		            $assignProduct['user_id'] 		= $this->session->userdata('uid');
		            $assignProduct['product_id'] 	= $this->input->post('product_id');
		            $assignedProduct 				= $this->Products_Model->assignProduct($assignProduct);
	            	if($assignedProduct){
		            	$this->session->set_flashdata('success','Product has been added to list!');
						redirect('products');
					}else {
						$this->session->set_flashdata('error','Something went wrong. Please try again.');	
						redirect('edit-product/'.$id);	
					}
	        	}else {
					$this->session->set_flashdata('error','Something went wrong. Please try again.');	
					redirect('edit-product/'.$id);	
				}
	        }
		}else{
			$this->session->set_flashdata('error','Either product is not available or not active!');
			redirect('products');
		}
		$this->load->view('attach_products', $data);
	}

}
