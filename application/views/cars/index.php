<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WebClues</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    </head>
    <body>
        <div class="container-scroller">
            <!-- partial -->
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
                if(!empty($this->session->flashdata('success'))){
                    echo '<button type="button" class="col-12 btn btn-inverse-success btn-fw">'.$this->session->flashdata('success').'</button><br/>';
                }else if(!empty($this->session->flashdata('error'))){
                    echo '<button type="button" class="col-12 btn btn-inverse-danger btn-fw">'.$this->session->flashdata('error').'</button><br/>';
                }
                ?>
                <br/>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                        <a href="<?php echo site_url('Cars/add_car');?>"><button type="button" class="btn btn-gradient-primary btn-fw">Add Car</button></a>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table" id="eventTable">
                                        <thead>
                                            <tr>
                                                <th> Car Image </th>
                                                <th> Car Name </th>
                                                <th> Car Description </th>
                                                <th> Car Attributes </th>
                                                <th> Status</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!empty($cars)){
                                            foreach($cars as $index => $car){
                                                $fuel = ($car['car_fuel'] == 1) ? 'Petrol' : ($car['car_fuel'] == 2) ? 'Diesel' : 'CNG';
                                                echo '<tr>';
                                                    echo '<td><img src="'.base_url().'uploads/'.$car['car_photo'].'"  style="width:100px !important;height:100px !important;border-radius:0 !important;"></td>';
                                                    echo '<td>'.$car['car_name'].'</td>';
                                                    echo '<td>'.$car['car_description'].'</td>';
                                                    echo '<td>
                                                        <ul>
                                                            <li><strong>Color</strong>: '.$car['car_color'].'</li>
                                                            <li><strong>Fuel</strong>: '.$fuel.'</li>
                                                        </ul>
                                                    </td>';

                                                    if($car['status'] == 1){
                                                        echo '<td><label class="badge badge-gradient-success">active</label></td>';
                                                    }else{
                                                        echo '<td><label class="badge badge-gradient-danger">inactive</label></td>';
                                                    }
                                                    echo '<td><a href="'.site_url('Cars/edit_car/').$car['id'].'">Edit</a></td>';
                                                echo '</tr>';
                                            }
                                        } else{
                                            echo '<tr><td valign="top" colspan="5" style="text-align:center;">No Cars</td></tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <p><?php echo $links;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
    </body>
</html>