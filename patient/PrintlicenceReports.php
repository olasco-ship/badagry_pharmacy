<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$medical = MedicalReportsOld::find_by_id($_GET['id']);





require('../layout/header2.php');
?>


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Medical Report</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Medical Report</li>
                            <li class="breadcrumb-item active"> Medical Certificate </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="clearfix">
                <div class="card">

                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">

                                <div id="body">
                                    <?php $patient = Patient::find_by_id($medical->patient_id);
 ?>
                                    <center><h4>TO WHOM IT MAY CONCERN</h4></center>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Mr./Mrs./Miss</label>
                                            <input type="text" name="patient_name" class="form-control" value="<?php echo $patient->title. " ".  $patient->first_name . " " . "$patient->last_name" ?>">
                                        </div>
                                    </div>
                                    <center><h3><u>MEDICAL CERTIFICATE OF FITNESS FOR DRIVER'S LICENCE</u></h3></center>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>This is to certify that I have examined the above candidate and found him/her to be physically and mentally
                                                fit.</p>
                                        </div>
                                    </div>

                                    <?php
                                    $decoded = json_decode($medical->result);
                                    ?>
                                    <div class="row">
                                        <div class="offset-1 col-md-8">
                                            <label>His/Her Chest X-Ray No:</label>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="offset-1 col-md-8">
                                            <input type="text" name="xray" class="form-control" value="<?php echo $decoded->xray ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <p>shows no abnormality.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-1 col-md-11">
                                            <label>Haematological Investigation:</label>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                            <div class="offset-1 col-md-1">
                                                <label>PCV</label>
                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" name="pcv" class="form-control" id="pcv" value="<?php echo $decoded->pcv ?>">
                                            </div>

                                            <div class="offset-1 col-md-1">
                                                <label>WBC</label>
                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" name="wbc" class="form-control" id="wbc" value="<?php echo $decoded->wbc ?>">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="offset-1  col-md-2">
                                                <label>Blood Group</label>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="bg" class="form-control" id="bg" value="<?php echo $decoded->bg ?>">
                                            </div>

                                            <div class="offset-1 col-md-1">
                                                <label>Genotype</label>
                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" name="genotype" class="form-control" id="genotype" value="<?php echo $decoded->genotype ?>">
                                            </div>
                                        </div>

                                         <div class="row">
                <div class="offset-1 col-md-4">
                    <label>Visual Acuity:</label>
                </div>
                <div class="col-md-7">
                    <input type="text" name="visual" class="form-control" value="<?php echo $decoded->visual ?>" required/>
                </div>
            </div>

               <!-- <div class="offset-1 col-md-4">
                    <label>HCV:</label>
                </div>
                <div class="col-md-7 mb-4">
                    <input type="text" name="hepatitis" class="form-control" value="<?php echo $decoded->hcv ?>">
                </div>
            </div>-->

                                    <div class="row">
                                        <div class="offset-1 col-md-1">
                                            <label>Code No:</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="code_no" class="form-control" value="<?php echo $decoded->code ?>">
                                        </div>

                                        <!--<div class="offset-1 col-md-2">
                                            <label>Pregnancy Test</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="pregnancy" class="form-control">
                                                <option value="<?php echo $decoded->preg_test ?>"><?php echo $decoded->preg_test ?></option>
                                                <option value="Positive">Positive</option>
                                                <option value="Negative">Negative</option>
                                            </select>
                                        </div>-->
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-inline">
                                            <input type="hidden" value="<?php echo $medical->id; ?>" id="billId" />
                                            <button type="button" id="printBill" class="btn btn-lg btn-success" data-loading-text="Searching...">Print Report
                                            </button>
                                            <!--<a href="print_preview.php?id=<?php /*echo $bill->id */?>" target="_blank" class="btn btn-outline-warning" role="button">
                                        Print Bill
                                    </a>-->
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

