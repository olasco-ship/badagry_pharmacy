<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/24/2019
 * Time: 9:19 AM
 */

require_once "../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$waiting_list = WaitingList::find_by_id($_GET['id']);
$patient      = Patient::find_by_id($waiting_list->patient_id);
$user         = User::find_by_id($session->user_id);


if (is_post()) {

    if (isset($_POST['update_rad'])){

        $waiting_list = WaitingList::find_by_id($_GET['id']);
        $patient = Patient::find_by_id($waiting_list->patient_id);


        $scanRequest = ScanRequest::find_requests($waiting_list->id, $patient->id);

        $each = EachScan::find_all_requests($scanRequest->id);

        $scanRequest->scan_no = count($each);
        $scanRequest->not_done = count($each);

        $scanRequest->save();

        $session->message("Radiology/Scan Investigations has been updated for this patient");
        redirect_to("dashboard.php?id=$waiting_list->id");
    }

    if (isset($_POST['save_scan'])) {

        $items = ScanBill::get_bill();
        $item = $items[0];
        $scanRequests = ScanRequest::find_requests($waiting_list->id, $patient->id);

        $oldScanCount = $scanRequests->scan_no;
        $newScanCount = count($items);
        $oldNotDone  = $scanRequests->not_done;
        $newNotDone  = count($items);

        $scanRequests->scan_no = $oldScanCount + $newScanCount;
        $scanRequests->not_done = $oldNotDone + $newNotDone;


        if ($scanRequests->save()) {
            foreach ($items as $item) {
                $test = Test::find_by_id($item->id);

                $eachScan = new EachScan();
                $eachScan->scan_id = $test->id;
                $eachScan->scan_request_id = $scanRequests->id;
                $eachScan->quantity = 1;
                $eachScan->scan_price = $item->price;
                $eachScan->sync = "off";
                $eachScan->scan_name = $test->name;
                $eachScan->consultant = $user->full_name();
                $eachScan->scanResult = "";
                $eachScan->scientist = "";
                $eachScan->radiologist = "";
                $eachScan->status = "REQUEST";
                $eachScan->date = strftime("%Y-%m-%d %H:%M:%S", time());
                $eachScan->save();
            }
            $session->message("Radiology/Scan Investigations has been updated for this patient");
            redirect_to("dashboard.php?id=$waiting_list->id");
            // redirect_to();
        }

    }



}

ScanBill::clear_all_bill();



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
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="dashboard.php?id=<?php echo $waiting_list->id ?>">Back</a>
                                        <h5>REVIEW Radiology/Scan Investigations</h5>
                                        <?php
                                        $s_Request = ScanRequest::find_requests($waiting_list->id, $patient->id);
                                        if (!empty($s_Request)) {
                                        ?>
                                        <form action="" method="post">
                                            <?php

                                            $s_Request = ScanRequest::find_requests($waiting_list->id, $patient->id);
                                            if (empty($s_Request)) {
                                                echo "<h5>No Radiology/Scan Investigation selected</h5>";
                                            } else {
                                            ?>
                                            <h5><u>Selected Radiology/Scan Investigation(s)</u></h5>
                                            <table class="table table-bordered table-condensed table-hover">
                                                <?php
                                                $e_Scan = EachScan::find_all_requests($s_Request->id);
                                                foreach ($e_Scan as $e) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $e->scan_name ?></td>
                                                        <!--                                                    <input type="hidden" name="test_name" class="form-control"  value="--><?php //echo $e->test_id ?><!--">-->
                                                        <td><span class='deleteScan' data-id='<?= $e->id; ?>'><i class="icon-trash" title="Delete"></i></span></td>
                                                    </tr>
                                                    <?php
                                                }
                                                }
                                                ?>
                                                <tr>
                                                    <th>Note:</th>
                                                    <td><textarea name="doc_note" class="form-control"><?php echo $s_Request->doc_com ?></textarea> </td>
                                                </tr>

                                                <?php } ?>

                                                <tr>
                                                    <td colspan="2"><button type="submit" class="btn btn-group-lg" name="update_rad"> Save </button></td>
                                                    <!--                                                <td colspan="2"><a href="add_more_drug.php?id=--><?php //echo $drugRequest->id ?><!--" class="form-control">Add More Drug</a></td>-->
                                                </tr>

                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tab-pane" id="Radiology">

                                        <div class="row">
                                            <div class="col-md-7">

                                                <ul class="nav nav-tabs-new2">
                                                    <li class="nav-item"><a class="nav-link active show"
                                                                            data-toggle="tab"
                                                                            href="#Home-new2">Radiology</a>
                                                    </li>
                                                    <li class="nav-item"><a class="nav-link"
                                                                            data-toggle="tab"
                                                                            href="#Profile-new2">
                                                            Ultrasound Scan </a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane show active" id="Home-new2">

                                                        <h5>Radiology</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name Of Investigation</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody id="radioItems">
                                                                <?php // $revs = Test::find_all();
                                                                $revs = Test::find_all_by_unit_id(4);
                                                                foreach ($revs as $rev) { ?>
                                                                    <tr data-id="<?php echo $rev->revenueHead_id; ?>">
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <label><input
                                                                                            type="checkbox"
                                                                                            class="add_to_bill"
                                                                                            value=""
                                                                                            data-id="<?php echo $rev->id; ?>"><?php echo $rev->name; ?>
                                                                                </label>
                                                                            </div>

                                                                        </td>

                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane" id="Profile-new2">

                                                        <h5> Ultrasound Scan </h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name Of Investigation</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody id="scanItems">
                                                                <?php // $revs = Test::find_all();
                                                                $revs = Test::find_all_by_unit_id(5);
                                                                foreach ($revs as $rev) { ?>
                                                                    <tr data-id="<?php echo $rev->revenueHead_id; ?>">
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <label><input
                                                                                            type="checkbox"
                                                                                            class="add_to_bill"
                                                                                            value=""
                                                                                            data-id="<?php echo $rev->id; ?>"><?php echo $rev->name; ?>
                                                                                </label>
                                                                            </div>

                                                                        </td>

                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-md-5 bill" id="scanCheck">

                                            </div>
                                        </div>

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

