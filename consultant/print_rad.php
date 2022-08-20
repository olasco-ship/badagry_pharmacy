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

$session->message("Investigations has been requested for this patient");

/*if (is_post()){

    if (isset($_POST['print_pres'])){
        $session->message("Prescription has been done for this patient");
        redirect_to("dashboard.php?id=$waiting_list->id");
    }

}*/


require('../layout/header2.php')
?>




    <div id="main-content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="body">
                    <?php
                    if (!empty($message)) { ?>
                        <div id="success" class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <?php echo output_message($message); ?>
                        </div>
                    <?php }
                    ?>

                            <div id="body">

                                <a style="font-size: larger" href="dashboard.php?id=<?php echo $waiting_list->id ?>">&laquo;Back</a>
                                <div id="body">
                                    <h2>Scan/Radiology</h2>
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
                                            <th>Department</th>
                                            <th>Investigation(s)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        if (!empty(ScanRequest::find_requests($waiting_list->id, $patient->id))) {
                                            $scan  = ScanRequest::find_requests($waiting_list->id, $patient->id);

                                            //  print_r($drugs); exit;

                                            $eachScan = EachScan::find_all_requests($scan->id);

                                            foreach ($eachScan as $each) {
                                                $product = Test::find_by_id($each->scan_id);
                                                $unit    = Unit::find_by_id($product->unit_id);
                                                ?>
                                                <tr>
                                                    <td><?php echo $unit->name;  ?></td>
                                                    <td><?php echo $product->name;  ?></td>
                                                </tr>
                                            <?php }     }  ?>

                                    </table>

                                </div>

                                <form class="form-inline" id="formPrint">
                                    <!--                                          <input type="hidden" value="--><?php //echo $bill->id; ?><!--"  id="billId"/>-->
                                    <button type="submit" name="print_inv" id="submit" class="btn btn-lg btn-success"
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



