<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/24/2019
 * Time: 9:19 AM
 */

require_once "../includes/initialize.php";


$waiting_list = WaitingList::find_by_id($_GET['id']);
$patient      = Patient::find_by_id($waiting_list->patient_id);
$user         = User::find_by_id($session->user_id);

$drugRequest = DrugRequest::find_requests($waiting_list->id, $patient->id);

$clinic      = Clinic::find_by_id($drugRequest->clinic_id);

if (empty($drugRequest)) {
    redirect_to("dashboard.php?id=$waiting_list->id");
}

if(isset($_POST['deleteDrug'])){

    $toDeleteDrug = new EachDrug();
    $toDeleteDrug->id = $_GET['id'];

//     echo $toDeleteDrug->id;

    if($toDeleteDrug->delete()){

        /*$drug        = $_POST['drug'];
        $dosage      = $_POST['dosage'];
        $duration    = $_POST['duration'];

        $new_array = array();
        for ($x = 0; $x < count($drug); $x++) {
            $new_array[$x] = array(
                "name" => $drug[$x], 'dosage' => $dosage[$x], 'duration' => $duration[$x]
            );
        }*/

        redirect_to("review_drug.php?id=$waiting_list->id");

    }

}

if (is_post()) {

    $waiting_list = WaitingList::find_by_id($_GET['id']);
    $patient = Patient::find_by_id($waiting_list->patient_id);


    $drugRequest = DrugRequest::find_requests($waiting_list->id, $patient->id);

    $drug        = $_POST['drug'];
    $dosage      = $_POST['dosage'];
    $duration    = $_POST['duration'];

    $new_array = array();
    for ($x = 0; $x < count($drug); $x++) {
        $new_array[$x] = array(
            "name" => $drug[$x], 'dosage' => $dosage[$x], 'duration' => $duration[$x]
        );
    }

    $drugRequest->drugs_no        = count($new_array);
    $drugRequest->not_available   = count($new_array);

    if ($drugRequest->save()){

        if ($drugRequest->drugs_no <= 0){
            $drugRequest->delete();
        }

        foreach ($new_array as $item) {
            $product = Product::find_by_name($item['name']);
            $eachDrugs = EachDrug::find_all_requests_by_product($drugRequest->id, $product->name);
            foreach ($eachDrugs as $each_drug) {
                $each_drug->product_name = $item['name'];
                $each_drug->dosage = $item['dosage'];
                $each_drug->duration = $item['duration'];
                if ($each_drug->save()){
                    PatientBill::clear_all_bill();
                    $session->message("Prescription has been updated for this patient");
                    redirect_to("dashboard.php?id=$waiting_list->id");
                }
            }
        }

    }







}




require '../layout/header.php';

?>


    <div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        <?php echo "Medical Dashboard - " . $patient->title . " " . $patient->full_name(); ?>
                    </h2>
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

                        <div class="clearfix">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <a style="font-size: larger" href="dashboard.php?id=<?php echo $waiting_list->id ?>">&laquo;Back</a>

                                    <table>
                                        <tr>
                                            <td><b>Patient</b></td>
                                            <td style='padding-left: 200px'><?php
                                                $patient = Patient::find_by_id($drugRequest->patient_id);
                                                echo $patient->full_name();

                                                ?> </td>
                                        </tr>


                                        <tr>
                                            <td><b>Consultant</b></td>
                                            <td style='padding-left: 200px'><?php echo $drugRequest->consultant; ?> </td>
                                        </tr>


                                        <tr>
                                            <td><b>Prescription Date</b></td>
                                            <td style='padding-left: 200px'>
                                                <?php
                                                $date = date('d/m/Y h:i:a', strtotime($drugRequest->date));
                                                echo $date;
                                                ?>
                                            </td>
                                        </tr>

                                    </table>
                                    <form action="" method="post">
                                        <table class="table table-bordered table-condensed table-hover">
                                            <thead>
                                            <tr>
                                                <th>Prescribed Drug(s)</th>
                                                <th>Dosage</th>
                                                <th>Duration</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $avail = "yes";
                                            $sub_total = 0;

                                            $eachDrug = EachDrug::find_all_requests($drugRequest->id);
                                            foreach ($eachDrug as $request) {
                                                $drug = Product::find_by_id($request->product_id);
                                                ?>
                                                <tr>
                                                    <td><?php echo $drug->name; ?>
                                                        <input type='text' class='form-control' name='drug[]' value='<?php echo $drug->name ?>' style='width:300px;' hidden>
                                                    </td>
                                                    <td><select style='width: 100px' class='form-control' required id='dosage' name='dosage[]'>
                                                            <option class='form-control' value='<?php echo $request->dosage ?>'><?php echo $request->dosage ?></option>
                                                            <option class='form-control' value='daily'>daily</option>
                                                            <option class='form-control' value='b.i.d'>b.i.d</option>
                                                            <option class='form-control' value='t.i.d'>t.i.d</option>
                                                            <option class='form-control' value='QHS'>QHS</option>
                                                            <option class='form-control' value='Q4h'>Q4h</option>
                                                            <option class='form-control' value='Q4-6h'>Q4-6h</option>
                                                        </select>
                                                    </td>
                                                    <td><input type='text' class='form-control' name='duration[]' value='<?php echo $request->duration ?>' style='width:100px;'></td>
                                                    <td><span class='delete' data-id='<?= $request->id; ?>'><i class="icon-trash" title="Delete"></i></span></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td colspan="2"><button type="submit" class="btn btn-group-lg" name="save_pres"> Save </button></td>
                                                <td colspan="2"><a href="add_more_drug.php?id=<?php echo $drugRequest->id ?>" class="form-control">Add More Drug</a></td>
                                            </tr>

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





<?php
require '../layout/footer.php';

