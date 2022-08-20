<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/24/2019
 * Time: 9:19 AM
 */

require_once "../includes/initialize.php";

$user = User::find_by_id($session->user_id);


if (is_post()) {

    if (isset($_POST['save_drug'])) {

        $items = PatientBill::get_bill();
        $item = $items[0];

        redirect_to("drugboard.php");

        $drugRequest                  = new DrugRequest();
        $drugRequest->sync            = "off";
        $drugRequest->bill_id         = 0;
        $drugRequest->consultant      = $user->full_name();
        $drugRequest->drugs_no        = count($items);
        $drugRequest->not_available   = count($items);
        $drugRequest->doc_com         = $_POST['doc_com'];
        $drugRequest->pharm_com       = "";
        $drugRequest->status          = "awaiting_costing";
        $drugRequest->receipt         = "";
        $drugRequest->date            = strftime("%Y-%m-%d %H:%M:%S", time());

        if ($drugRequest->save()) {
            //   foreach ($items as $item) {
            foreach ($items as $keys => $item) {
                $product = Product::find_by_id($item->id);

                $eachDrug = new EachDrug();
                $eachDrug->sync = "off";
                $eachDrug->drug_request_id = $drugRequest->id;
                $eachDrug->product_id = $product->id;
                $eachDrug->product_name = $product->name;
                $eachDrug->quantity = $item->quantity;
                $eachDrug->dosage = $item->dosage;
                $eachDrug->consultant = $user->full_name();
                $eachDrug->pharmacy = "";
                $eachDrug->status = "OPEN";
                $eachDrug->date = strftime("%Y-%m-%d %H:%M:%S", time());
                $eachDrug->save();
            }
            $session->message("Prescription has been done for this patient");
            redirect_to("print_bill.php?id=$drugRequest->id");

        }
    }



}

PatientBill::clear_all_bill();
ScanBill::clear_all_bill();
TestBill::clear_all_bill();


require '../layout/header.php';


?>

<div id="main-content">
    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">

                    <h5><a href="../pham/dispensary.php"> << Back </a></h5


                        <div class="col-lg-12 col-md-12">


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


                                                        <div class="row clearfix">

                                                            <div class="col-sm-5">
                                                                <h5> Prescribe Drugs For Patient </h5>
                                                                <form id="formSearch">
                                                                    <div class=" form-group">
                                                                        <input type="text" placeholder="Name Of Drug"
                                                                               name="txtProduct" id="txtProduct"
                                                                               autocomplete="off" class="typeahead"/>
                                                                        <button type="submit" id="submit"
                                                                                class="btn btn-lg btn-info"
                                                                                data-loading-text="Searching...">Search
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="col-sm-7" id="save_page">
                                                                <?php
                                                                echo PatientBill::save_page();
                                                                ?>


                                                            </div>



                                    </div>


                            </div>




                        </div>



                </div>

<?php
require '../layout/footer.php';
?>




