<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/24/2019
 * Time: 9:19 AM
 */

require_once "../includes/initialize.php";

$drugRequests = DrugRequest::find_by_id($_GET['id']);
$patient = Patient::find_by_id($drugRequests->patient_id);
$user         = User::find_by_id($session->user_id);


$items = PatientBill::get_bill();
$item = $items[0];


if (is_post()) {

    $drugRequests = DrugRequest::find_by_id($_GET['id']);
    $patient = Patient::find_by_id($drugRequests->patient_id);


    $drug        = $_POST['drug'];
    $dosage      = $_POST['dosage'];
    $duration    = $_POST['duration'];

    $new_array = array();
    for ($x = 0; $x < count($drug); $x++) {
        $new_array[$x] = array(
            "name" => $drug[$x], 'dosage' => $dosage[$x], 'duration' => $duration[$x]
        );
    }

    $oldDrugCount = $drugRequests->drugs_no;
    $newDrugCount = count($new_array);
    $oldNotAvail  = $drugRequests->not_available;
    $newNotAvail  = count($new_array);

    $drugRequests->drugs_no        = $oldDrugCount + $newDrugCount;
    $drugRequests->not_available   = $oldNotAvail + $newNotAvail;

    if ($drugRequests->save()) {

        foreach ($new_array as $item) {
            $product = Product::find_by_name($item['name']);


            $eachDrug                  = new EachDrug();
            $eachDrug->sync            = "off";
            $eachDrug->drug_request_id = $drugRequests->id;
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
        $session->message("Prescription has been done for this patient");
        redirect_to("dashboard.php?id=$drugRequests->waiting_list_id");
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


                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">

                                <a href="add_more_drug.php?id=<?php echo $drugRequests->id ?>">Back</a>
                                <h3>Prescription Sheet</h3>

                                <div>

                                    <table class="table table-bordered table-condensed table-hover">


                                        <thead>
                                        <tr>
                                            <th>Drug(s)</th>
                                            <th>Dosage</th>
                                            <th> Duration</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <form action="" method="post">
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
                                        </form>
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
</div>





<?php
require '../layout/footer.php';
?>

