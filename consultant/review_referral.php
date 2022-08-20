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

    $sub_clinic_id = test_input($_POST['sub_clinic_id']);

    $clinic_note = test_input($_POST['clinic_note']);

    $referral = Referrals::find_pending_referrals($waiting_list->id, $patient->id);
    $referral->referred_sub_clinic_id = $sub_clinic_id;
    $referral->referral_note = $clinic_note;
    $referral->save();

    $session->message("Patient's referred clinic has been updated!");

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
                                <h5>REVIEW REFERRAL</h5>
                                <?php
                                $referral = Referrals::find_pending_referrals($waiting_list->id, $patient->id);
                                if (!empty($referral)) {
                                    $sub_clinic = SubClinic::find_by_id($referral->referred_sub_clinic_id);
                                    $clinic = Clinic::find_by_id($sub_clinic->clinic_id);
                                }
                                ?>

                                <form action="" method="post">
                                    <div class="form-group">
                                        <label>Hospital Clinic</label>
                                        <select class="form-control" id="clinic_id"
                                                name="clinic_id" required>
                                            <option <?php echo ($clinic->id) ? 'selected ="TRUE"' : ''; ?>value="<?php echo $clinic->id ?>"><?php echo $clinic->name ?></option>
                                            <?php
                                            $finds = Clinic::find_all();
                                            foreach ($finds as $find) { ?>
                                                <option value="<?php echo $find->id; ?>"><?php echo $find->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Sub-Clinic</label>
                                        <div id="sub_clinic_id">
                                            <select name="sub_clinic_id" required>
                                                <option <?php echo ($referral->referred_sub_clinic_id) ? 'selected ="TRUE"' : ''; ?>value="<?php echo $referral->referred_sub_clinic_id ?>"><?php echo $sub_clinic->name ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Note to clinic</label>
                                        <textarea class='form-control' rows='5'
                                                  cols='70' placeholder='Notes'
                                                  name='clinic_note'><?php echo $referral->referral_note ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="refer_patient"
                                                class="btn btn-success"> Refer Patient
                                        </button>
                                    </div>

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
