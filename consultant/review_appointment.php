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


if (is_post()) {

    $waiting_list = WaitingList::find_by_id($_GET['id']);
    $patient = Patient::find_by_id($waiting_list->patient_id);

    $next_app = test_input($_POST['next_app']);

    $appointment = Appointment::find_pending_appointment($waiting_list->id, $patient->id);
    $appointment->next_app = $next_app;

    $appointment->save();

    $session->message("Patient's appointment date has been updated!");

    redirect_to("dashboard.php?id=$waiting_list->id");

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
                            <div class="col-lg-6 col-md-6">

                                <a href="dashboard.php?id=<?php echo $waiting_list->id ?>">Back</a>
                                <h5>REVIEW APPOINTMENT</h5>
                                <?php
                                $appointment = Appointment::find_pending_appointment($waiting_list->id, $patient->id);
                                ?>

                                <form action="" method="post">
                                    <div class="form-group">
                                        <!-- <label>Select Date</label>-->
                                        <!--<div class="input-group ">
                                            <span class="input-group-addon"></span>
                                            <input type="date" name="" value=""
                                                   class="form-control">
                                        </div>-->
                                        <div class="input-group ">
                                            <span class="input-group-addon"></span>
                                            <input type="text" name="next_app" value="<?php echo $appointment->next_app ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" name="save_appointment"
                                            class="btn btn-lg btn-primary">Save
                                        Appointment
                                    </button>
                                </form>
                            </div>

                            <div class="col-lg-6 col-md-6">
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
