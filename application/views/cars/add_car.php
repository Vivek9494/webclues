<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WebClues</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    </head>
    <body>
        <div class="container-scroller">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-calendar"></i>
                            </span> <?php echo $this->session->userdata('webclues_user')['name'];;?> 
                        </h3>
                        <a href="<?php echo site_url('login/logout');?>">Logout</a>
                    </div>
                    <div class="">
                    <?php
                        echo validation_errors();
                    ?>
                    <br/>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" id="add-car-frm" name="add-car-frm" enctype="multipart/form-data">
                                        <div class="form-group col-md-5">
                                            <label>Car Name <span style="color:#fe7c96;">*</span></label>
                                            <input type="text" class="form-control <?= (form_error('designation')) ? 'form-error' : '';?>" id="car_name" name="car_name" value="<?= set_value('car_name'); ?>">
                                            <?= form_error('car_name');?>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Car Color <span style="color:#fe7c96;">*</span></label>
                                            <select class="form-control <?= (form_error('car_color')) ? 'form-error' : '';?>" id="car_color" name="car_color">
                                                <option value="">Select Color</option>
                                                <option value="red">Red</option>
                                                <option value="white">White</option>
                                                <option value="black">Black</option>
                                            </select>
                                            <?= form_error('car_color');?>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Car Fuel <span style="color:#fe7c96;">*</span></label><br>
                                            <input type="radio" name="car_fuel" id="car_fuel_1" value="1" checked> Petrol
                                            <input type="radio" name="car_fuel" id="car_fuel_2" value="2"> Diesel
                                            <input type="radio" name="car_fuel" id="car_fuel_3" value="3"> CNG
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Car Description <span style="color:#fe7c96;">*</span></label>
                                            <textarea class="form-control <?= (form_error('car_description')) ? 'form-error' : '';?>" id="car_description" rows="4" name="car_description"><?= set_value('car_description');?></textarea>
                                            <?= form_error('car_description');?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Car Image <span style="color:#fe7c96;">*</span></label><br>
                                            <input type="file" name="userfile" id="userfile" >
                                            <?= form_error('userfile');?>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Make Date <span style="color:#fe7c96;">*</span></label><br>
                                            <select class="form-control <?= (form_error('car_date')) ? 'form-error' : '';?>" id="car_date" name="car_date" style="width:100px;display:inline-block;">
                                                <option value="">DD</option>
                                                <?php 
                                                for($i=1;$i<=31;$i++){
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <select class="form-control <?= (form_error('car_month')) ? 'form-error' : '';?>" id="car_month" name="car_month" style="width:100px;display:inline-block;">
                                                <option value="">MM</option>
                                                <?php 
                                                for($i=1;$i<=12;$i++){
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <select class="form-control <?= (form_error('car_year')) ? 'form-error' : '';?>" id="car_year" name="car_year" style="width:100px;display:inline-block;">
                                                <option value="">YYYY</option>
                                                <?php 
                                                for($i=2000;$i<=date('Y');$i++){
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?= form_error('car_date');?>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Car Status <span style="color:#fe7c96;">*</span></label><br>
                                            <input type="radio" name="car_status" id="car_status_1" value="1" checked> Active
                                            <input type="radio" name="car_status" id="car_status_0" value="0"> Inactive
                                            <?= form_error('car_status');?>
                                        </div>
                                        <br/>
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-gradient-primary mr-2" id="submit_btn" name="submit_btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/additional-methods.min.js"></script>
    <script>
        $("#add-car-frm").validate({
            rules: {
                car_name: {
                    required: true,
                    pattern: /^[a-zA-Z ]*$/,
                },
                car_color: {
                    required: true,
                    pattern: /^[a-zA-Z]*$/,
                },
                car_fuel: {
                    required: true,
                },
                car_description: {
                    required: true,
                    minlength: 10
                },
                car_image: {
                    required: true,
                    extension: "jpg|jpeg|png|"
                },
                car_date: {
                    required: true,
                    pattern: /^[0-9]*$/,
                },
                car_month: {
                    required: true,
                    pattern: /^[0-9]*$/,
                },
                car_year: {
                    required: true,
                    pattern: /^[0-9]*$/,
                },
                car_status: {
                    required: true
                }                
            },
            messages: {
                car_name: {required: 'Car Name is required',pattern: 'Only Alphabetic Characters allowed'},
                car_color: {required: 'Car Color is required',pattern: 'Only Alphabetic Characters allowed'},
                car_fuel: {required: 'Car Fuel is required'},
                car_description: {required: 'Car Description is required',minlength: 'Description must be contain 10 characters'},
                car_image: {required: 'Car Image is required',extention: 'Only jpg,png,jpeg allowed'},
                car_date: {required: 'Car Date is required',pattern: 'Numbers only'},
                car_month: {required: 'Car Month is required',pattern: 'Numbers only'},
                car_year: {required: 'Car Year is required',pattern: 'Numbers only'},
                car_status: {required: 'Car Status is required'}
            },
            submitHandler: function(form) { 
                $.ajax({
                    type: "post",
                    url: '<?php echo site_url('cars/save_car');?>',
                    data: new FormData(form),
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var result = JSON.parse(response);
                        if(result.status == 'success'){
                            setTimeout(function(){ alert('Car details added successfully');window.location.href = "<?php echo site_url('cars/index');?>";}, 3000);
                        }else{
                            alert(result.message);
                        }
                    }
                });
            }
        });
    </script>
</html>