<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
        <title><?=$page_title;?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <style>
            body {
			    color: #fff;
			    background: #63738a;
			    font-family: 'Roboto', sans-serif;
			}

			.form-control {
			    height: 40px;
			    box-shadow: none;
			    color: #969fa4;
			}

			.form-control:focus {
			    border-color: #5cb85c;
			}

			.form-control,
			.btn {
			    border-radius: 3px;
			}

			.signup-form {
			    width: 450px;
			    margin: 0 auto;
			    padding: 30px 0;
			    font-size: 15px;
			}

			.signup-form h2 {
			    color: #fff;
			    margin: 0 0 15px;
			    position: relative;
			    text-align: center;
			}

			.signup-form h2:before,
			.signup-form h2:after {
			    content: "";
			    height: 2px;
			    width: 30%;
			    background: #d4d4d4;
			    position: absolute;
			    top: 50%;
			    z-index: 2;
			}

			.signup-form h2:before {
			    left: 0;
			}

			.signup-form h2:after {
			    right: 0;
			}

			.signup-form .hint-text {
			    color: #fff;
			    margin-bottom: 30px;
			    text-align: center;
			}

			.signup-form form {
			    color: #999;
			    border-radius: 3px;
			    margin-bottom: 15px;
			    background: #f2f3f7;
			    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			    padding: 30px;
			}

			.signup-form .form-group {
			    margin-bottom: 20px;
			}

			.signup-form input[type="checkbox"] {
			    margin-top: 3px;
			}

			.signup-form .btn {
			    font-size: 16px;
			    font-weight: bold;
			    min-width: 140px;
			    outline: none !important;
			}

			.signup-form .row div:first-child {
			    padding-right: 10px;
			}

			.signup-form .row div:last-child {
			    padding-left: 10px;
			}

			.signup-form a {
			    color: #fff;
			    text-decoration: underline;
			}

			.signup-form a:hover {
			    text-decoration: none;
			}

			.signup-form form a {
			    color: #5cb85c;
			    text-decoration: none;
			}

			.signup-form form a:hover {
			    text-decoration: underline;
			} 
        </style>
    </head>
    <body>
        <div class="signup-form">
            <h2>Register</h2>
            <p class="hint-text">Add your product</p>
            <?php echo form_open_multipart('edit-product/'.$product_details[0]->id,['name'=>'add-product','autocomplete'=>'off']);?>
            <div class="form-group">
                <!--success message -->
                <?php if($this->session->flashdata('success')){?>
                	<div class="alert alert-success">
                        <?php  echo $this->session->flashdata('success');?>
                    </div>
                <?php } ?>
                <!--error message -->
                <?php if($this->session->flashdata('error')){?>
                	<div class="alert alert-danger">
                        <?php  echo $this->session->flashdata('error');?>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col">
                        <?php echo form_input(['name'=>'title','class'=>'form-control','value'=>$product_details[0]->title,'placeholder'=>'Product Name']);?>
                        <?php echo form_error('title',"<div style='color:red'>","</div>");?>
                    </div>
                    <div class="col">
                    	<?php echo form_input(['name'=>'quantity','class'=>'form-control','value'=>$product_details[0]->quantity,'placeholder'=>'Enter product qunatity', 'type'=>'number']);?>
                        <?php echo form_error('quantity',"<div style='color:red'>","</div>");?>	 
                    </div>
                </div>
            </div>
            <div class="form-group">
    			<?php echo form_input(['name'=>'price','class'=>'form-control','value'=>$product_details[0]->product_price,'placeholder'=>'Enter product price per quantity', 'type'=>'number']);?>
				<?php echo form_error('price',"<div style='color:red'>","</div>");?>
            </div>
            <div class="form-group">
    			<div class="row">
	                <div class="col-lg-12 col-md-12 col-sm-6">
	                	<?php
	                		$product_image = base_url('assets/images/products/').$product_details[0]->image;
	                	?>
	                    <div class="white-box text-center"><img width="150px" src="<?=$product_image;?>" class="img-responsive"></div>
	                </div>
	            </div>
	            <code>Leave below image field as blank, if you want to keep same!</code>
    		</div>
            <div class="form-group">
    			<?php echo form_input(['name'=>'image','class'=>'form-control','value'=>set_value('image'),'type'=>'file']);?>
    			<?php echo form_input(['name'=>'old_image','class'=>'form-control','value'=>$product_details[0]->image,'type'=>'hidden']);?>
            	<?php echo form_error('image',"<div style='color:red'>","</div>");?>
            </div>
			<?php echo form_input(['name'=>'user_product_id','class'=>'form-control','value'=>$product_details[0]->user_product_id,'type'=>'hidden']);?>
			<div class="form-group">
				<?php 
                	$data = array(
				        'name'        => 'description',
				        'id'          => 'description',
				        'value'       => $product_details[0]->description,
				        'rows'        => '5',
				        'cols'        => '10',
				        'style'       => 'width:100%',
				        'class'       => 'form-control'
				    );
				    echo form_textarea($data);
                ?>
                <?php echo form_error('description',"<div style='color:red'>","</div>");?>  	
            </div>
            <div class="form-group">
                <?php echo form_submit(['name'=>'Add','value'=>'Submit','class'=>'btn btn-success btn-lg btn-block']);?>
            </div>
            </form>
            <?php echo form_close();?>
        </div>
    </body>
</html>