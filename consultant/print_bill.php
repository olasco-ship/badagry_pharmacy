<?php
/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 4/14/2019
 * Time: 6:10 PM
 */


require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}


$waiting_list = WaitingList::find_by_id($_GET['id']);

/*if (is_post()){

    if (isset($_POST['print_pres'])){
        $session->message("Prescription has been done for this patient");
        redirect_to("dashboard.php?id=$waiting_list->id");
    }

}*/


require('../layout/header.php')
?>




    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>GP Consultation</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Medical</li>
                            <li class="breadcrumb-item active"> GP Consultation </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="clearfix">
                <div class="card">

                    <div class="body">
                        <div class="row">
                            <div class="col-lg-7 col-md-8 col-sm-7">

                                <div id="body">
                                    <?php
                                    if (!empty($message)) { ?>
                                        <div id="success" class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <?php echo output_message($message); ?>
                                        </div>
                                    <?php }
                                    ?>

                                    <a style="font-size: larger" href="dashboard.php?id=<?php echo $waiting_list->id ?>">&laquo;Back</a>
                                    <div id="body">
                                        <h2>PHARMACY</h2>
                                        <table>
                                            <tr>
                                                <td><b>Patient </b></td>
                                                <td style='padding-left: 100px'><?php
                                                    $patient = Patient::find_by_id($waiting_list->patient_id);
                                                    echo $patient->full_name();
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b> Folder Number </b></td>
                                                <td style='padding-left: 100px'><?php $patient = Patient::find_by_id($waiting_list->patient_id);
                                                    echo $patient->folder_number; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <?php
                                                if (isset($patient->nhis_tracking) and (!empty($patient->nhis_tracking))) {
                                                    echo "<td><b>NHIS Tracking No.</b></td>";
                                                    echo "<td style='padding-left: 100px'> $patient->nhis_tracking</td>";
                                                }
                                                ?>
                                            </tr>


                                        </table>

                                        <table class="table table-bordered table-condensed table-hover">
                                            <thead>
                                            <tr>
                                                <th>Drug(s)</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            if (!empty(DrugRequest::find_requests($waiting_list->id, $patient->id))) {
                                                $drugs  = DrugRequest::find_requests($waiting_list->id, $patient->id);

                                              //  print_r($drugs); exit;

                                                $eachDrug = EachDrug::find_all_requests($drugs->id);

                                                foreach ($eachDrug as $each) {
                                                    $product = Product::find_by_id($each->product_id);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $product->name;  ?></td>
                                                    </tr>
                                                <?php }     }  ?>

                                        </table>

                                    </div>

                                    <form class="form-inline" id="formPrint">
<!--                                          <input type="hidden" value="--><?php //echo $bill->id; ?><!--"  id="billId"/>-->
                                        <button type="submit" name="print_pres" id="submit" class="btn btn-lg btn-success"
                                                data-loading-text="Searching...">Print
                                        </button>
                                    </form>



                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

























<?php
require('../layout/footer.php');

