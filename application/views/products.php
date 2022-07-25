<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
        <title><?=$page_title;?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
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
                width: 100%;
                margin: 0 auto;
                padding: 50px;
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
            <?php
                if($userRole == 1){
            ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Admin</p>
                            <b>As admin you can view all products, there status and if they are attached to any user in any quantity</b>
                        </div>
                    </div>
            <?php
                }
            ?>
        	<?php if($this->session->flashdata('success')){?>
            	<div class="alert alert-success">
                    <?php  echo $this->session->flashdata('success');?>
                </div>
            <?php } ?>
            <?php if($this->session->flashdata('error')){?>
            	<div class="alert alert-danger">
                    <?php  echo $this->session->flashdata('error');?>
                </div>
            <?php } ?>
            <h2>Products</h2>
            <table id="example" class="display" style="width:100%">
		        <thead>
		            <tr>
		                <th>#</th>
		                <th>Title</th>
		                <th>Image</th>
                        <?php if($userRole == 1){?>
                            <th>User Attached</th>
                            <th>User Attached Email</th>
                        <?php } ?>
                        <th>Quantity</th>
		                <th>Per Price</th>
		                <th>Action</th>
                        <?php if($userRole == 1){?>
                            <th>Status</th>
                        <?php } ?>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		if ($list) {
		        			foreach ($list as $count => $product) {
		        				$productQuantity = ($product->quantity)?$product->quantity:0;
                                $productStatus   = ($product->status == 0)?'In active':'Active';
                                echo "<tr><td>".($count+1)."</td>";
		        				echo "<td>".$product->title."</td>";
		        				echo "<td> <img width='150px' src='".base_url('assets/images/products/').$product->image."' class='img-responsive' alt='".$product->image."'></td>";
                                if($userRole == 1){
                                    $attached_userName = (!empty($product->attached_user_email))?$product->attached_user_name:'No user attached';
                                    $attached_userEmail = (!empty($product->attached_user_email))?$product->attached_user_email:'No user attached';
    		        				echo "<td>".$attached_userName."</td>";
                                    echo "<td>".$attached_userEmail."</td>";
                                }
                                echo "<td>".$productQuantity."</td>";
		        				echo "<td>".$product->product_price."</td>";
		        				echo "<td><a href='".base_url('view-product/').$product->id."' title='View Product'><i class='fa fa-eye'></i></a> <a href='".base_url('edit-product/').$product->id."'  title='Edit Product'><i class='fa fa-pencil'></i></a> <a href='".base_url('delete-product/').$product->id."' title='Delete Product'><i class='fa fa-trash'></i></a></td>";
                                if($userRole == 1){
                                    echo "<td>".$productStatus."</td></tr>";
                                }
                            }
		        		}
		        	?>
		        </tbody>
		        <tfoot>
		            <tr>
		                <th>#</th>
		                <th>Title</th>
		                <th>Image</th>
		                <th>Quantity</th>
		                <th>Per Price</th>
		                <th>Action</th>
		            </tr>
		        </tfoot>
		    </table><br>
		    <form>
                <div class="form-group">
                    <a href="<?php echo base_url('add-product');?>" class="btn btn-success btn-lg btn-block" style="color:#fff;">Add Product</a>
                </div>
            </form>
        </div>
        <script>
        	$(document).ready(function () {
			    $('#example').DataTable();
			});
        </script>
    </body>
</html>