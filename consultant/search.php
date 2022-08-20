<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}
//public function search(){
// return static::$
$user = User::find_by_id($session->user_id);
//$medical = new MedicalReports();

$count = Patient::find_by_number($_GET['folder_number']);
// $emr = MedicalReports::find_by_patient_id($_GET['patient_id']);

if(is_post()){

    $search = $_POST['search_id'];

    $patient = Patient::find_by_number($search);
    if($patient) {
        // while($row = $patient->fetch()){
        require('../layout/header.php');
        ?>



        <div id="main-content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-sm-12">
                            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> GP Consultation </h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                                <li class="breadcrumb-item active">Reports</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="body">
                                <div class="row d-flex">
                                    <a href="../consultant/index.php" style="font-size: large">&laquo; Back</a>
                                    <form action="search.php" method="POST">
                                        <input type="hidden" name="id" value="">
                                        <input type="text" name="search_id" placeholder="Search" value="">
                                        <button type="submit" name="search_btn" class="btn btn-primary">Search</button>
                                    </form>
                                </div>
                                <div class="row clearfix">
                                    <form method="post" action="code.php">
                                        <center><h4>TO WHOM IT MAY CONCERN</h4></center>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Mr./Mrs./Miss</label>
                                                <input type="text" name="patient_name" class="form-control" value="<?php echo $patient->title. " ".  $patient->first_name . " " . "$patient->last_name" ?>">

                                            </div>
                                        </div>
                                        <center><h3><u>MEDICAL CERTIFICATE OF FITNESS FOR ADMISSION</u></h3></center>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>This is to certify that I have examined the above candidate and found him/her to be physically and mentally
                                                    fit for further studies.</p>
                                            </div>
                                        </div>
                                        <?php $ql = "SELECT patients . * , scanresult . * FROM patients, scanresult WHERE patients.id = scanresult.patient_id  "; //"SELECT patients.folder_number, scanresult.resultData FROM patients INNER JOIN result ON patients.patient_id = result.patient_id";
                                        // $scan = Patient::find_by_sql($sql); ?>
                                        <div class="row">
                                            <div class="offset-1 col-md-8">
                                                <label>His/Her Chest X-Ray No:</label>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="offset-1 col-md-8">
                                                <input type="text" name="xray" class="form-control" value="<?php echo $scan->xray_no ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <p>shows no abnormality.</p>
                                            </div>
                                        </div>
                                        <?php $sql = "SELECT patients . * , scanresult . * FROM patients, scanresult WHERE patients.id = scanresult.patient_id  ";

                                        $read = Patient::find_by_sql($sql);
                                        $test = json_decode($medical->result);

                                        $free = $read->$test;
                                        ?>

                                        <div class="row">
                                            <div class="offset-1 col-md-8">
                                                <label>Electrocardiogram Test:</label>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="offset-1 col-md-8">
                                                <input type="text" name="electrocardiogram" class="form-control" value="<?php echo $free->electrocardiogram ?>">
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="offset-1 col-md-11">
                                                <label>Haematological Investigation:</label>
                                            </div>
                                        </div>
                                        <?php
                                        $sql = "SELECT patients . * , result . * FROM patients, result WHERE patients.id = result.patient_id";//"SELECT * patients.folder_number,result.patient_id FROM patients INNER JOIN result ON patient_id = '$patient_id' ";

                                        $medical = Patient::find_by_sql($sql) ?>
                                        <?php $decoded = json_decode($medical->result);
                                        $emr = $medical->$decoded;
                                        ?>
                                        <div class="row form-group">
                                            <div class="offset-1s col-sm-0">
                                                <label>PCV</label>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="pcv" class="form-control" id="pcv" value="<?php echo $emr->pcv ?>">
                                            </div>

                                            <div class="offset-1 col-sm-1">
                                                <label>Blood Group</label>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="bg" class="form-control" id="bg" value="<?php echo $emr->blood_group ?>">
                                            </div>

                                            <div class="offset-1 col-sm-1">
                                                <label>Genotype</label>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="genotype" class="form-control" id="genotype" value="<?php echo $emr->genotype ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="offset-1 col-md-5">
                                                <label>Microbiology & Parasitology Organisms:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea name="micro_para" class="form-control" value ="<?php echo $emr->micro ?>"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="offset-1 col-md-11">
                                                <label>Chemical Pathological Investigation:</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="offset-1 col-md-2">
                                                <label>Urinary Protein</label>
                                            </div>

                                            <div class="col-md-3 mb-4">
                                                <input type="text" name="urinary_protein" class="form-control" id="urinary_protein" value="<?php echo $emr->urinary_protein ?>">
                                            </div>

                                            <div class="offset-1 col-md-1">
                                                <label>Urinary Glucose</label>
                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" name="urinary_glucose" class="form-control" id="urinary_glucose" value="<?php echo $emr->urinary_glucose ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-1 col-md-4">
                                                <label>Visual Acuity:</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="visual" class="form-control" value="<?php echo $emr->visual ?>" required/>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="offset-1 col-md-4">
                                                <label>Allergy:</label>
                                            </div>
                                            <div class="col-md-7 mb-4">
                                                <input type="text" name="allergy" class="form-control" value="<?php echo $emr->allergy ?>" required/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-1 col-md-9">
                                                <label><h4 style="text-align: center;">Medical Officer:</h4></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="offset-1 col-md-4">
                                                <label>Name:</label>
                                            </div>
                                            <?php if ($session->is_logged_in()){
                                                $user = User::find_by_id($session->user_id);?>
                                                <div class="col-md-7 mb-4">
                                                    <input type="text" name="name" readonly="name" class="form-control" value="<?php echo $user->full_name() ?>">
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="row">
                                            <div class="offset-1 col-md-1">
                                                <label>Code No:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="code_no" class="form-control" value="<?php echo $patient->folder_number ?>">
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="offset-1 col-md-7">
                                                <button type="submit" class="btn btn-info">Save</button>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>






                </div>
            </div>
        </div>

    <?php } else{
        echo "No record Found";
    }

}?>

<?php
require('../layout/footer.php');




//$sql = "SELECT * FROM patients WHERE folder_number ='$search' LIMIT 1";
//$result = $count->query("SELECT * FROM patients WHERE folder_number = '$search_id'") ;
//$result = Patient::find_by_sql($sql);
//$result = $count->;
//if($result->num_rows = 1){
// while($row = $result->fetch()){


//  }

//}