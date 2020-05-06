<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WebClues</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                    <div class="row flex-grow">
                        <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="post" id="login-frm">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" id="btn-login" name="btn-login" value="SIGN IN" />
                                </div>
                                <div class="mt-3 text-danger">
                                    <?php echo validation_errors();?>
                                    <?php 
                                    if($this->session->flashdata('error')){
                                        echo $this->session->flashdata('error');
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
        </div>
    </body>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/additional-methods.min.js"></script>
    <script>
        $("#login-frm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                email: {required: 'Email is required',email: 'Enter Valid Email'},
                password: {required: 'Password is required',minlength: 'Password must be contain 3 characters'}
            }
        });
    </script>
</html>