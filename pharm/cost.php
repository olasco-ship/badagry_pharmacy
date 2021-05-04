<?php
/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 4/30/2019
 * Time: 11:28 AM
 */


require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}





if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $query = trim($_POST['search']);
    $min_length = 3;
}


require('../layout/header.php');
?>




    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                            Cost Pharmacy Request </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Pharmacy</li>
                            <li class="breadcrumb-item active">Costing</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 text-right">
                        <div class="bh_chart hidden-xs">
                            <div class="float-left m-r-15">
                                <small>Visitors</small>
                                <h6 class="mb-0 mt-1"><i class="icon-user"></i> 1,784</h6>
                            </div>
                            <span class="bh_visitors float-right">2,5,1,8,3,6,7,5</span>
                        </div>
                        <div class="bh_chart hidden-sm">
                            <div class="float-left m-r-15">
                                <small>Visits</small>
                                <h6 class="mb-0 mt-1"><i class="icon-globe"></i> 325</h6>
                            </div>
                            <span class="bh_visits float-right">10,8,9,3,5,8,5</span>
                        </div>
                        <div class="bh_chart hidden-sm">
                            <div class="float-left m-r-15">
                                <small>Chats</small>
                                <h6 class="mb-0 mt-1"><i class="icon-bubbles"></i> 13</h6>
                            </div>
                            <span class="bh_chats float-right">1,8,5,6,2,4,3,2</span>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card patients-list">
                        <div class="header">

                            <div href="#" class="right">
                                <form class="form-inline" id="basic-form" action="" method="post">
                                    <div class="form-group">
                                        <input type="text"  class="form-control" placeholder="Folder Number"
                                               name="search" required>
                                        <button type="submit" class="btn btn-outline-primary">Search</button>
                                        <button type="button" name="search" onClick="location.href=location.href"  class="btn btn-outline-warning">Refresh</button>
                                    </div>
                                </form>

                                <br/>

                                <?php if (is_post()){  ?>
                                    <div id="success" class="alert alert-success alert-dismissible" role="alert" style="width: 500px">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        All records for <?php echo $query ?>
                                    </div>
                                <?php } ?>


                            </div>



                            <ul class="header-dropdown">
                                <li><a class="tab_btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Weekly">W</a></li>
                                <li><a class="tab_btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Monthly">M</a></li>
                                <li><a class="tab_btn active" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Yearly">Y</a></li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <a style="font-size: larger" href="../pharm/dispensary.php">&laquo;Back</a>


                            <ul class="nav nav-tabs-new2">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#All">Cost & Confirmation</a></li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content m-t-10 padding-0">
                                <div class="tab-pane table-responsive active show" id="All">
                                    <table class="table m-b-0 table-hover">
                                        <thead class="thead-purple">

                                        <tr>

                                            <th>Folder No.</th>
                                            <th>Patient Name</th>
                                            <th>Ward/Clinic</th>
                                            <th> Prescribed Drugs</th>
                                         <!--   <th>Investigation left</th>  -->
                                            <th>Prescription Date</th>
                                            <th></th>
                                          


                                        </tr>

                                        </thead>
                                        <tbody>

                                        <?php
                                        if (is_post()) {
                                            $query = trim($_POST['search']);
                                            $patients = Patient::find_patient_by_num_or_name($query);
                                            foreach($patients as $patient) {   ?>
                                                <tr>
                                                    <td><?php echo $patient->folder_number ?></td>
                                                    <td><?php echo $patient->full_name() ?></td>
                                                    <td><?php echo $bill->consultant ?></td>
                                                    <td><?php echo $patient->gender ?></td>
                                                    <td><?php $d_date = date('d/m/Y h:i:a', strtotime($bill->date)); echo $d_date ?></td>
                                                    <td><a href='index.php?id=<?php echo $bill->id ?>'>Cost</a></td>
                                                    <!--     <td><span class="label label-success">COMPLETED</span></td>  -->
                                                </tr>
                                            <?php } } else {
                                                $drugRequests = DrugRequest::find_awaiting_costing();
                                            foreach($drugRequests as $request) {
                                                $patient = Patient::find_by_id($request->patient_id);
                                                ?>
                                                <tr>
                                                    <td><a href='presc.php?id=<?php echo $request->id ?>'> <?php echo $patient->folder_number ?></a></td>
                                                    <td><?php echo $patient->full_name()  ?></td>
                                                    <td><?php if ($request->ward_id == 0) {
                                                            $waiting = WaitingList::find_by_id($request->waiting_list_id);
                                                            $subClinic = SubClinic::find_by_id($waiting->sub_clinic_id);
                                                            echo $subClinic->name;
                                                        } else {
                                                            $ward = Wards::find_by_id($request->ward_id);
                                                            echo $ward->ward_number;
                                                        }

                                                        ?></td>
                                                    <td><?php echo $request->drugs_no ?></td>
                                                <!--    <td><?php echo $request->not_available ?></td>  -->
                                                    <td><?php $d_date = date('d/m/Y h:i:a', strtotime($request->date)); echo $d_date ?></td>
                                                  <!--  <td><a href='cost_drug.php?id=<?php echo $request->id ?>'>Cost</a></td> -->
                                                    <td><?php if ($request->ward_id == 0) {  ?>
                                                        <a href='cost_drug.php?id=<?php echo $request->id ?>'>Cost </a>
                                                        <?php   } else {  ?>
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <a class="dropdown-item" href='cost_drug.php?id=<?php echo $request->id ?>'> Cash </a>
                                                                <a class="dropdown-item" href='cost_ward_drug.php?id=<?php echo $request->id ?>'>Pay From Wallet</a>
                                                            </div>
                                                        </div>

                                                        <?php   } ?>
                                                    </td>
                                          

                                                </tr>

                                            <?php }
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>










<?php

require('../layout/footer.php');