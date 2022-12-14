<?php
/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 4/14/2019
 * Time: 11:02 PM
 */


require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}

$user = User::find_by_id($session->user_id);

$billed   = Bill::find_billed_drug();

$services = DrugServices::find_billed();

if (is_post()) {
    if (isset($_POST['paymentReceipt'])) {

        $id = $_POST['bill_id'];

        $payment_ref = $_POST['auth_code'];

        $payment_bill = Bill::find_by_id($id);
        $payment_bill->status = "PAID";
        $payment_bill->receipt = $payment_ref;
        $payment_bill->payment_officer = $user->full_name();

        if ($payment_bill->save()) {

            if (!empty(DrugRequest::find_by_billed($payment_bill->id))) {
                $drugs = DrugRequest::find_by_billed($payment_bill->id);
                $drugService = DrugServices::find_by_bill_id($payment_bill->id);
                $drugService->status = "CLEARED";
                $drugService->save();
                foreach ($drugs as $d) {
                    $d->receipt = $payment_ref;
                    $d->save();
                }
                $session->message("Payment Reference has been added");
                redirect_to("billed.php");
            }
        }

    }
}

require('../layout/header.php');
?>





    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                            Unpaid Prescription </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Pharmacy</li>
                            <li class="breadcrumb-item active">Billing</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card patients-list">
                        <div class="body">
                            <a style="font-size: larger" href="dispensary.php">&laquo;Back</a>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs-new2">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#All">Unpaid Prescriptions</a></li>
                                <!--                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#USA">USA</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#India">India</a></li>-->
                            </ul>
                            <div class="tab-content m-t-10 padding-0">
                                <div class="tab-pane table-responsive active show" id="All">
                                    <table class="table m-b-0 table-hover">
                                        <thead class="thead-warning">

                                        <tr>

                                            <th>Bill No.</th>
                                            <th>Patient Name</th>
                                            <th>Amount</th>
                                            <th>Date &amp; Time</th>
                                            <th>Status</th>
                                            <th>Pay</th>

                                        </tr>

                                        </thead>
                                        <tbody>

                                        <?php
                                            foreach($services as $service) { 
                                                $bill = Bill::find_by_id($service->bill_id);
                                             ?>
                                            <tr>
                                                <td><a href="print_bill.php?id=<?php echo $bill->id ?>"><?php echo $bill->bill_number ?></a></td>
                                                <td><?php $patient = Patient::find_by_id($bill->patient_id); echo $patient->full_name()  ?></td>
                                             <!--   <td><?php // echo $bill->quantity ?></td>   -->
                                                <td><?php echo "???$bill->total_price"  ?></td>
                                                <td><?php $d_date = date('d/m/Y h:i a', strtotime($bill->date)); echo $d_date ?></td>
                                                <td><span class="badge badge-info">BILLED</span></td>
                                                <td><button type="button" class="btn btn-success" data-toggle="modal"
                                                            data-pre_reg-id="<?php echo $bill->id ?>"
                                                            data-target="#authenticate">Authenticate
                                                    </button></td>
                                            </tr>
                                        <?php } ?>

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

    <div class="modal" id="authenticate" tabindex="-1" role="dialog" aria-labelledby="deposit to account">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="myModalLabel">Authenticate Receipt</h4>
                </div>
                <form action="billed.php?id=<?php echo $bill->id; ?>" method="post">
                    <div class="modal-body">
                        <div id="modalMessages"></div>

                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-8"> Payment Reference </label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="auth_code"
                                           placeholder="Enter Payment Reference" required>

                                    <input type="hidden" name="bill_id" value="<?php echo $bill->id; ?>"/>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="paymentReceipt"> Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
require('../layout/footer.php');