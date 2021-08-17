<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}




require('../layout/header.php');
?>



    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> GP Consultation </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body">

                            <a href="../consultant/index.php" style="font-size: large">&laquo; Back</a>
                            <div class="row clearfix">
                                <form method="post" action="">
                                    <center><h4>TO WHOM IT MAY CONCERN</h4></center>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Mr./Mrs./Miss</label>
                                            <input type="text" name="patient_name" class="form-control" value="">
                                        </div>
                                    </div>
                                    <center><h3><u>MEDICAL CERTIFICATE OF FITNESS FOR ADMISSION</u></h3></center>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>This is to certify that I have examined the above candidate and found him/her to be physically and mentally
                                                fit for further studies.</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <label>His/Her Chest X-Ray No:</label>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" name="x-ray" class="form-control" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <p>shows no abnormality.</p>
                                        </div>
                                    </div>
                                </form>
                            </div>

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

