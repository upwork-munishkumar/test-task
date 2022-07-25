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
                            <b>As admin you have all the capabilities</b>
                        </div>
                    </div>
            <?php
                }
            ?>
            <h2>Welcome: <b> <?php echo $name;?></b></h2>
            <form>
                <div id="body">
                    <p>3.1. Count of all active and verified users.</p>
                    <code><b>Active And Verified User Count: </b><?=$acitve_user_count;?></code>

                    <p>3.2. Count of active and verified users who have attached active products.</p>
                    <code><b>Active And Verified User Attached Product Count: </b><?=$acitve_user_products_count;?></code>

                    <p>3.3. Count of all active products (just from products table).</p>
                    <code><b>Active Products Count: </b><?=$acitve_products_count;?></code>

                    <p>3.4. Count of active products which don't belong to any user.</p>
                    <code><b>Products Count which are active but not attached to any user: </b><?=$acitve_products_but_not_attached_count;?></code>

                    <p>3.5. Amount of all active attached products (if user1 has 3 prod1 and 2 prod2 which are active, user2 has 7 prod2 and 4 prod3, prod3 is inactive, then the amount of active attached products will be 3 + 2 + 7 = 12).</p>
                    <code><b>Active and Attached Products Qunatity: </b><?=$acitve_and_attached_products_quantity;?></code>

                    <p>3.6. Summarized price of all active attached products (from the previous subpoint if prod1 price is 100$, prod2 price is 120$, prod3 price is 200$, the summarized price will be 3 x 100 + 9 x 120 = 1380).</p>
                    <code><b>Active and Attached Products Price Sum: </b>€<?=$acitve_and_attached_products_price_sum;?></code>

                    <p>3.7. Summarized prices of all active products per user. For example - John Summer - 85$, Lennon Green - 107$.</p>
                    <code>
                        <b>Active and Attached Products Price Sum By User: </b>
                        <table class="table-bordered table-hover table-responsive">
                            <thead>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Total Products Price</th>
                            </thead>
                            <?php
                                if ($acitve_and_attached_products_price_sum_by_user) {
                                    echo "<tbody>";
                                    foreach ($acitve_and_attached_products_price_sum_by_user as $userData) {
                                        echo "<tr><td>".$userData['id']."</td>";
                                        echo "<td>".$userData['name']."</td>";
                                        echo "<td> €".$userData['current_user_active_attached_products_price_sum']."</td></tr>";
                                    }
                                    echo "</tbody>";
                                }
                            ?>
                        </table>
                    </code>

                    <p>3.8. The exchange rates for USD and RON based on Euro using https://exchangeratesapi.io/ . This is a separated subpoint and isn't related to the previous subpoints.</p>
                    <code>
                        <b>Exchange Rate from EURO TO USD and RON </b>
                        <table class="table-bordered table-hover table-responsive">
                            <thead>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Total Products Price</th>
                                <th>Currency Converter</th>
                            </thead>
                            <?php
                                if ($acitve_and_attached_products_price_sum_by_user) {
                                    echo "<tbody>";
                                    foreach ($acitve_and_attached_products_price_sum_by_user as $userData) {
                                        echo "<tr><td>".$userData['id']."</td>";
                                        echo "<td>".$userData['name']."</td>";
                                        echo "<td class='pp_sum'> €".$userData['current_user_active_attached_products_price_sum']."</td>";
                                        echo "<td>
                                            <select name='get_currency_rates' class='get_currency_rates form-control'>
                                                <option selected disabled>Select Currency</option>
                                                <option value='USD' data-price='".$userData['current_user_active_attached_products_price_sum']."'>USD</option>
                                                <option value='RON' data-price='".$userData['current_user_active_attached_products_price_sum']."'>RON</option>
                                            </select> 
                                        </td></tr>";
                                    }
                                    echo "</tbody>";
                                }
                            ?>
                        </table>
                    </code>
                </div>
            </form>
            <form>
                <div class="form-group">
                    <a href="<?php echo site_url('products');?>" class="btn btn-success btn-lg btn-block" style="color:#fff;">Products</a>
                </div>
                <div class="form-group">
                    <a href="<?php echo site_url('Logout');?>" class="btn btn-success btn-lg btn-block" style="color:#fff;">Logout</a>
                </div>
            </form>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".get_currency_rates").on("change", function(){
                    var $this               = $(this);
                    var old_text            = $this.parent().parent().find('.pp_sum').text();
                    var selected_currency   = $this.val();
                    var current_price       = $this.find(':selected').data('price');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo base_url('change-currency'); ?>",
                        data: {
                            'selected_currency': selected_currency,
                            'current_price'    : current_price
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if (data.status == 'error') {
                                alert("There is some error, please try after some time!");
                                return false;
                            }
                            $this.parent().parent().find('.pp_sum').text("€" + current_price + " - " + data.converted_price)
                        }
                    });
                })
            })
        </script>
    </body>
</html>