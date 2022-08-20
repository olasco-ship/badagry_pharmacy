<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/24/2019
 * Time: 9:19 AM
 */

require_once "../includes/initialize.php";

$user         = User::find_by_id($session->user_id);


 $items = PatientBill::get_bill();
 $item = $items[0];


if (is_post()) {

    $patient_name        = $_POST['patient_name'];
    $folder_number       = $_POST['folder_number'];
    $station_id          = $_POST['station_id'];
    $physician           = $_POST['physician'];
    
    $drug        = $_POST['drug'];
    $dosage      = $_POST['dosage'];
    $duration    = $_POST['duration'];
    $comment     = $_POST['doc_com'];

    $new_array = array();
    for ($x = 0; $x < count($drug); $x++) {
        $new_array[$x] = array(
            "name" => $drug[$x], 'dosage' => $dosage[$x], 'duration' => $duration[$x] 
        );
    }

    $system_number = getSystemNumber($first_name, $last_name);

    $patient                   = new Patient();
    $patient->sync             = "off";
    $patient->folder_number    = $folder_number;
    $patient->system_number    = $system_number;
    $patient->first_name       = $patient_name;
    $patient->date_registered  = strftime("%Y-%m-%d %H:%M:%S", time());
    if ($patient->save()){
        $wait_list                = new WaitingList();
        $wait_list->sync          = "off";
        $wait_list->patient_id    = $patient->id;
        $wait_list->room_id       = 0;
        $wait_list->officer       = $user->full_name();
        $wait_list->dr_seen       = "";
        $wait_list->vitals        = '';
        $wait_list->status        = 'nurse';
        $wait_list->date          = strftime("%Y-%m-%d %H:%M:%S", time());
        $wait_list->save();
    }


        $drugRequest                  = new DrugRequest();
        $drugRequest->sync            = "off";
        $drugRequest->waiting_list_id = $wait_list->id;
        $drugRequest->patient_id      = $patient->id;
        $drugRequest->bill_id         = 0;
        $drugRequest->consultant      = $user->full_name();
        $drugRequest->drugs_no        = count($new_array);
        $drugRequest->not_available   = count($new_array);
        $drugRequest->doc_com         = $_POST['doc_com'];
        $drugRequest->pharm_com       = "";
        $drugRequest->status          = "awaiting_costing";
        $drugRequest->receipt         = "";
        $drugRequest->date            = strftime("%Y-%m-%d %H:%M:%S", time());

        if ($drugRequest->save()) {
            //   foreach ($items as $item) {
             foreach ($new_array as $item) {
                $product = Product::find_by_name($item['name']);

                $eachDrug                  = new EachDrug();
                $eachDrug->sync            = "off";
                $eachDrug->drug_request_id = $drugRequest->id;
                $eachDrug->product_id      = $product->id;
                $eachDrug->product_name    = $product->name;
                $eachDrug->quantity        = "0";
                $eachDrug->dosage          = $item['dosage'];
                $eachDrug->duration        = $item['duration'];
                $eachDrug->consultant      = $user->full_name();
                $eachDrug->pharmacy        = "";
                $eachDrug->status          = "OPEN";
                $eachDrug->date            = strftime("%Y-%m-%d %H:%M:%S", time());
                $eachDrug->save();
            }
            PatientBill::clear_all_bill();
//            $session->message("Prescription has been done for this patient");
            redirect_to("print_bill.php?id=$wait_list->id");
        }

   }




require '../layout/header.php';

?>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Treatment</li>
                        <li class="breadcrumb-item active"> History</li>
                    </ul>
                </div>

            </div>
        </div>


        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">

                    <div class="body">


                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">

                                <a href="dashboard.php">Back</a>
                                <h3>Prescription Sheet</h3>

                                <div>

                                    <form action="" method="post">

                                    <table class="table table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <td colspan="3">
                                                <input type='text' class='form-control' name='patient_name' value='<?php echo $patient_name ?>'>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Folder Number</th>
                                            <td colspan="3">
                                                <input type='text' class='form-control' name='folder_number' value='<?php echo $folder_number ?>'>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Physician</th>
                                            <td colspan="3">
                                                <input type='text' class='form-control' name='physician' value='<?php echo $physician ?>'>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> Dispensary </th>
                                            <td colspan="3">
                                                <?php $station = PharmacyStation::find_all(); ?>
                                                <select class="form-control" id="station_id" name="station_id" required>
                                                    <option value="">--Select Dispensary--</option>
                                                    <?php
                                                    foreach ($station as $s) { ?>
                                                        <option value="<?php echo $s->id; ?>"><?php echo $s->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                            <tr>
                                                <th>Drug(s)</th>
                                                <th>Dosage</th>
                                                <th> Duration</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                                <?php
                                                $items = PatientBill::get_bill();
                                                foreach ($items as $item) {   ?>
                                                    <tr>
                                                        <td><?php echo $item->name ?>
                                                            <input type='text' class='form-control' name='drug[]' value='<?php echo $item->name ?>' style='width:300px;' hidden>
                                                        </td>
                                                        <td>
                                                        <select style='width: 100px' class='form-control' required id='dosage' name='dosage[]'>
                                                                <option class='form-control' value=''></option>
                                                                <option class='form-control' value='daily'>daily</option>
                                                                <option class='form-control' value='b.i.d'>b.i.d</option>
                                                                <option class='form-control' value='t.i.d'>t.i.d</option>
                                                                <option class='form-control' value='QHS'>QHS</option>
                                                                <option class='form-control' value='Q4h'>Q4h</option>
                                                                <option class='form-control' value='Q4-6h'>Q4-6h</option>
                                                            </select>   
                                                        </td>
                                                        <td>
                                                            <input type='text' class='form-control' name='duration[]' value='' style='width:100px;'>
                                                        
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="4"><textarea class='form-control' rows='2' cols='70' placeholder='Prescription Note' name='doc_com'></textarea></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4"><button type="submit" class="btn btn-success"> Save Prescription </button></td>
                                                </tr>

                                        </tbody>

                                    </table>

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
require '../layout/footer.php';
?>