<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$user = User::find_by_id($session->user_id);


$department = "Pharmacy";

$dept = 'drug';


$count = Product::count_all();



$count_assigned = Dispensed::count_all();

$count_users = User::count_by_department($department);


require('../../layout/header.php');
?>




<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Store Count </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Main Dashboard</li>
                    </ul>
                </div>
      
            </div>
        </div>

        <div class="row clearfix">

            <div class="col-lg-12 col-md-12">
                <div class="card">

                    <div class="body">

                        <div class="row clearfix">


                            <div class="col-md-3">
                                <a href="update.php">
                                    <div class="body bg-info text-light">
                                        <h4><i class="icon-wallet"></i>
                                            <?php
                                            ?>
                                        </h4>
                                        <span> Update Store Count </span>
                                    </div>
                                </a>
                            </div>
                       
                            <div class="col-md-3">
                                <a href="<?php echo emr_lucid ?>/store/history.php">
                                    <div class="body bg-success text-light">
                                        <h4><i class="icon-wallet"></i> <?php 
                                                                        ?> </h4>
                                        <span>Drug Count History</span>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>




<?php
require('../../layout/footer.php');
