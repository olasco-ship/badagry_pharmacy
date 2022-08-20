



                    <div class="tab-pane show active" id="PatientDetails">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><b> VITAL SIGNS
                                    </b></li>
                            </ol>
                        </nav>
                        <?php
                        $vitals    = Vitals::find_by_waiting_list($waitList->id);
                        foreach ($vitals as $vital) {
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <h5> Vital Signs as
                                            at <?php $d_date = date('d/m/Y h:i a', strtotime($vital->date));
                                            echo $d_date ?></h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <?php
                                                if (isset($vital->temperature) and (!empty($vital->temperature))) {
                                                    echo "<th>Temperature</th>";
                                                    echo "<td> $vital->temperature</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->pulse) and (!empty($vital->pulse))) {
                                                    echo "<th> Heart Rate(Pulse) </th>";
                                                    echo "<td> $vital->pulse</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->resp_rate) and (!empty($vital->resp_rate))) {
                                                    echo "<th> Respiratory Rate </th>";
                                                    echo "<td> $vital->resp_rate</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->pressure) and (!empty($vital->pressure))) {
                                                    echo "<th>Blood Pressure</th>";
                                                    echo "<td> $vital->pressure</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->weight) and (!empty($vital->weight))) {
                                                    echo "<th> Weight </th>";
                                                    echo "<td> $vital->weight</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->height) and (!empty($vital->height))) {
                                                    echo "<th> Height </th>";
                                                    echo "<td> $vital->height</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->pain) and (!empty($vital->pain))) {
                                                    echo "<th> Pain </th>";
                                                    echo "<td> $vital->pain</td>";
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if (isset($vital->urinalysis) and (!empty($vital->urinalysis))) {
                                                    echo "<th> Urinalysis </th>";
                                                    echo "<td> $vital->urinalysis</td>";
                                                }
                                                ?>
                                            </tr>

                                            <tr>
                                                <?php
                                                if (isset($vital->rbs) and (!empty($vital->rbs))) {
                                                    echo "<th> RBS </th>";
                                                    echo "<td> $vital->rbs</td>";
                                                }
                                                ?>
                                            </tr>

                                            <tr>
                                                <?php
                                                if (isset($vital->bmi) and (!empty($vital->bmi))) {
                                                    echo "<th> BMI </th>";
                                                    echo "<td> $vital->bmi</td>";
                                                }
                                                ?>
                                            </tr>

                                            </tbody>
                                        </table>
                                        <?php
                                        if (isset($vital->comment) and (!empty($vital->comment)))
                                            echo $vital->comment;
                                        ?>
                                        <p class="text-info" style="font-size: larger"><code></code>
                                            Vitals Done
                                            By <?php echo $vital->nurse ?>
                                        </p>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <?php


                                        $subClinic = SubClinic::find_by_id($vital->sub_clinic_id);

                                        $clinic = Clinic::find_by_id($subClinic->clinic_id);
                                        ?>
                                        <h5> Clinical Vital Signs </h5>
                                        <?php
                                        $decoded = $vital->clinical_vitals;
                                        $array = json_decode($decoded);
                                        ?>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th>CLINIC</th>
                                                <th><?php echo $clinic->name ?></th>
                                            </tr>
                                            <?php
                                            foreach ($array as $key => $value) { ?>
                                                <tr>
                                                    <th><?php echo $key ?></th>
                                                    <td><?php echo $value ?></td>
                                                </tr>
                                            <?php } ?>

                                        </table>
                                    </div>
                                </div>

                            </div>
                        <?php }  ?>

                        <?php
                        $case_note = CaseNote::find_open_case_note($waitList->id, $patient->id);
                        if (!empty($case_note)) {
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> CLINICAL NOTES
                                        </b></li>
                                </ol>
                            </nav>
                            <ul style="font-size: medium">
                                <?php
                                $case_note = CaseNote::find_open_case_note($waitList->id, $patient->id);
                                if (!empty($case_note)) {
                                    ?>
                                    <div class="col-sm-12">

                                        <table>
                                            <tr>
                                                <th>Complains</th>
                                                <?php $decoded = json_decode($case_note->complains);
                                                        foreach($decoded as $single){
                                                            ?>
                                                <td style="padding-left: 100px">
                                                           <?php echo $single . ", "; ?>
                                                </td>
                                                <?php
                                                        }
                                                ?>
                                            </tr>
                                            <tr>
                                                <th>Duration Of Complain</th>
                                                <?php $decoded = json_decode($case_note->duration);
                                                foreach($decoded as $single){
                                                    ?>
                                                    <td style="padding-left: 100px">
                                                        <?php echo $single . ", "; ?>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <th>History Of Complain</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->hpc ?></td>
                                            </tr>
                                            <tr>
                                                <th>Systemic Review</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->sys_review ?></td>
                                            </tr>
                                            <tr>
                                                <th>Physical Examination</th>
                                                <td style="padding-left: 100px"><?php $decoded = json_decode($case_note->examination);
                                                    foreach($decoded as $single)
                                                        echo $single->general . ", ";
                                                    ?></td>
                                            </tr>

                                            <tr>
                                                <th>Condition of Examination</th>
                                                <td style="padding-left: 100px"><?php $decoded = json_decode($case_note->examination);
                                                    foreach($decoded as $single)
                                                        echo $single->condition . ", ";
                                                    ?></td>
                                            </tr>

                                            <tr>
                                                <th>Family History</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->family_history ?></td>
                                            </tr>

                                            <tr>
                                                <th>Personal History</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->personal_history ?></td>
                                            </tr>

                                            <tr>
                                                <th>Mental State</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->mental_state ?></td>
                                            </tr>

                                            <?php
                                            if (isset($case_note->past_history) and !empty($case_note->past_history)){
                                                ?>
                                                <tr>
                                                    <th>Past Medical History</th>
                                                    <td style="padding-left: 100px"><?php echo $case_note->past_history ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if (isset($case_note->immune_history) and !empty($case_note->immune_history)){
                                                ?>
                                                <tr>
                                                    <th>Immunization History</th>
                                                    <td style="padding-left: 100px"><?php echo $case_note->immune_history ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if (isset($case_note->nutri_history) and !empty($case_note->nutri_history)){
                                                ?>
                                                <tr>
                                                    <th>Immunization History</th>
                                                    <td style="padding-left: 100px"><?php echo $case_note->nutri_history ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if (isset($case_note->dev_history) and !empty($case_note->dev_history)){
                                                ?>
                                                <tr>
                                                    <th>Developmental History</th>
                                                    <td style="padding-left: 100px"><?php echo $case_note->dev_history ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if (isset($case_note->soc_history) and !empty($case_note->soc_history)){
                                                ?>
                                                <tr>
                                                    <th>Social History</th>
                                                    <td style="padding-left: 100px"><?php echo $case_note->soc_history ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <tr>
                                                <th>Systemic Examination</th>
                                                <?php $decoded = json_decode($case_note->systemic_examination);
                                                foreach($decoded as $single){
                                                    $cat = ExaminationCategory::find_by_id($single->examination);
                                                    ?>
                                                    <td style="padding-left: 100px">
                                                        <?php echo $cat->name; ?>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>

                                            <tr>
                                                <th>Symptoms</th>
                                                <?php $decoded = json_decode($case_note->systemic_examination);
                                                foreach($decoded as $single){
                                                    $symptoms = Examination::find_by_id($single->symptoms);
                                                    ?>
                                                    <td style="padding-left: 100px">
                                                        <?php echo $symptoms->name . ", "; ?>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <th>Diagnosis</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->diagnosis ?></td>
                                            </tr>
                                            <tr>
                                                <th>Differentials</th>
                                                <td style="padding-left: 100px"><?php echo $case_note->differentials ?></td>
                                            </tr>
                                            <tr>
                                                <th> Additional Notes  </th>
                                                <td style="padding-left: 100px"><?php echo $case_note->note ?></td>
                                            </tr>

                                            <?php
                                            if (isset($case_note->surgery) and !empty($case_note->surgery)){
                                                $decoded = json_decode($case_note->surgery);
                                                foreach ($decoded as $key => $value){
                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'preoperative_hb') {
                                                            echo "<tr>";
                                                            echo "<th>PREOPERATIVE HB</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'preoperative_date') {
                                                            echo "<tr>";
                                                            echo "<th>PREOPERATIVE DATE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Genotype') {
                                                            echo "<tr>";
                                                            echo "<th>GENOTYPE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'BloodGroup') {
                                                            echo "<tr>";
                                                            echo "<th>BLOOD GROUP</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'LabRefNo') {
                                                            echo "<tr>";
                                                            echo "<th>Lab. Ref. No</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'XrayRefNo') {
                                                            echo "<tr>";
                                                            echo "<th>X-RAY Ref. No</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Allergy') {
                                                            echo "<tr>";
                                                            echo "<th>KNOWN ALLERGIES</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'previousDrugHistory') {
                                                            echo "<tr>";
                                                            echo "<th>PREVIOUS DRUG HISTORY</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'operationProposed') {
                                                            echo "<tr>";
                                                            echo "<th>OPERATION PROPOSED</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'IndicationForOperation') {
                                                            echo "<tr>";
                                                            echo "<th>INDICATION FOR OPERATION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'EmergencyElective') {
                                                            echo "<tr>";
                                                            echo "<th>EMERGENCY/ELECTIVE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ProposedDateOfOperation') {
                                                            echo "<tr>";
                                                            echo "<th>PROPOSED DATE OF OPERATION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ConsentGiven') {
                                                            echo "<tr>";
                                                            echo "<th>CONSENT GIVEN</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'houseOfficer') {
                                                            echo "<tr>";
                                                            echo "<th>HOUSE OFFICER'S SIGNATURE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                            <?php
                                            if (isset($case_note->icu) and !empty($case_note->icu)){
                                                $decoded = json_decode($case_note->icu);
                                                foreach ($decoded as $key => $value){
                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'SPO2') {
                                                            echo "<tr>";
                                                            echo "<th>SPO2</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'GlasgowComaScore') {
                                                            echo "<tr>";
                                                            echo "<th>GLASGOW COMA SCORE AT ADMISSION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'PCV') {
                                                            echo "<tr>";
                                                            echo "<th>PCV ON ADMISSION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'BloodTransfussion') {
                                                            echo "<tr>";
                                                            echo "<th>BLOOD TRANSFUSSION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Vasopro') {
                                                            echo "<tr>";
                                                            echo "<th>Vasopro</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Anticoagulant') {
                                                            echo "<tr>";
                                                            echo "<th>Anticoagulant</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Comorbidity') {
                                                            echo "<tr>";
                                                            echo "<th>COMORBIDITY</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'IcuIndication') {
                                                            echo "<tr>";
                                                            echo "<th>ICU INDICATION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'managing_team') {
                                                            echo "<tr>";
                                                            echo "<th>MANAGING TEAM</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Ventilator') {
                                                            echo "<tr>";
                                                            echo "<th>VENTILATION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ventilation_mode') {
                                                            echo "<tr>";
                                                            echo "<th>VENTILATION MODE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'airways') {
                                                            echo "<tr>";
                                                            echo "<th>AIRWAYS</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ventilationDuration') {
                                                            echo "<tr>";
                                                            echo "<th>VENTILATION DURATION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'criticalIncident') {
                                                            echo "<tr>";
                                                            echo "<th>CRITICAL INCIDENT</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'daysOnVentilator') {
                                                            echo "<tr>";
                                                            echo "<th>DAYS ON VENTILATOR</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'dischargeDate') {
                                                            echo "<tr>";
                                                            echo "<th>DISCHARGE DATE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'remark') {
                                                            echo "<tr>";
                                                            echo "<th>REMARK</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'outcome') {
                                                            echo "<tr>";
                                                            echo "<th>OUTCOME</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                            <?php
                                            if (isset($case_note->anaesthesia) and !empty($case_note->anaesthesia)){
                                                $decoded = json_decode($case_note->anaesthesia);
                                                ?>
                                                <tr>
                                                    <td><strong>PREOPERATIVE ASSESSMENT</strong></td>
                                                </tr>
                                                    <?php
                                                foreach ($decoded as $key => $value){
                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'pcv') {
                                                            echo "<h2><u>PREOPERATIVE ASSESSMENT</u></h2>";
                                                            echo "<tr>";
                                                            echo "<th>PCV(%)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'hb') {
                                                            echo "<tr>";
                                                            echo "<th>Hb(gm/dl)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'urinalysis') {
                                                            echo "<tr>";
                                                            echo "<th>Urinalysis</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'asa') {
                                                            echo "<tr>";
                                                            echo "<th>ASA Physical Status</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'hxExamInx') {
                                                            echo "<tr>";
                                                            echo "<thRelevant Hx, Exam, Inx and Significant drug Rx</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'hbGenotype') {
                                                            echo "<tr>";
                                                            echo "<th>Hb Genotype</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'premedication') {
                                                            echo "<tr>";
                                                            echo "<th>Premedication</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'timeGiven') {
                                                            echo "<tr>";
                                                            echo "<th>Time Given</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'dentition') {
                                                            echo "<tr>";
                                                            echo "<th>Dentition</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'lastPerOral') {
                                                            echo "<tr>";
                                                            echo "<th>Last Per Oral</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'prevAnaestheticYes' || $key == 'prevAnaestheticNo'){
                                                            echo "<h4>Anaesthetic History</h4>";
                                                            echo "<tr>";
                                                            echo "<th>Previous Anaesthetics</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'complications') {
                                                            echo "<tr>";
                                                            echo "<th>Complications</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubationYes' || $key == 'intubationNo') {
                                                            echo "<h4>Airway</h4>";
                                                            echo "<tr>";
                                                            echo "<th>Likely Intubation</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'mallampati') {
                                                            echo "<tr>";
                                                            echo "<th>Mallampati</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubationComment') {
                                                            echo "<tr>";
                                                            echo "<th>Comment</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'smokerYes' || $key == 'smokerNo') {
                                                            echo "<tr>";
                                                            echo "<th>Smoker</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'lmp') {
                                                            echo "<h4>Obst/Gynae</h4>";
                                                            echo "<tr>";
                                                            echo "<th>LMP</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'parity') {
                                                            echo "<tr>";
                                                            echo "<th>Parity</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'gestAge') {
                                                            echo "<tr>";
                                                            echo "<th>Gest: Age</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'rxn') {
                                                            echo "<h4>Allergies/Blood Txn";
                                                            echo "<tr>";
                                                            echo "<th>Rxn</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'eucr') {
                                                            echo "<tr>";
                                                            echo "<th>E/U/C/R</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'hrbpm') {
                                                            echo "<tr>";
                                                            echo "<th>HR(bpm)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'bpmmhg') {
                                                            echo "<tr>";
                                                            echo "<th>BP(mmHg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'temp') {
                                                            echo "<tr>";
                                                            echo "<th>Temp(℃)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'seenBy') {
                                                            echo "<tr>";
                                                            echo "<th>Seen By</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'date') {
                                                            echo "<tr>";
                                                            echo "<th>Date</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'time') {
                                                            echo "<tr>";
                                                            echo "<th>Time</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }

                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intra_hr') {
                                                            echo "<tr>";
                                                            echo "<th>Baseline vital Signs: HR(bpm)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'nibp') {
                                                            echo "<tr>";
                                                            echo "<th>NIBP(mmHg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'sao') {
                                                            echo "<tr>";
                                                            echo "<th>Sa0(%)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intra_temp') {
                                                            echo "<tr>";
                                                            echo "<th>Temp(<span>&#176;</span>C)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'facemaskYes' || $key == 'facemaskNo') {
                                                            echo "<h4>AIRWAY</h4>";
                                                            echo "<tr>";
                                                            echo "<th>Facemask</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'facemaskSize') {
                                                            echo "<tr>";
                                                            echo "<th>Facemask Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'oralYes' || $key == 'oralNo') {
                                                            echo "<tr>";
                                                            echo "<th>Oral airway</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'oralSize') {
                                                            echo "<tr>";
                                                            echo "<th>Oral airway size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'nasalYes' || $key == 'nasalNo') {
                                                            echo "<tr>";
                                                            echo "<th>Nasal airway</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'nasalSize') {
                                                            echo "<tr>";
                                                            echo "<th>Nasal Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'lmaYes' || $key == 'lmaNo') {
                                                            echo "<tr>";
                                                            echo "<th>LMA</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'lmaSize') {
                                                            echo "<tr>";
                                                            echo "<th> LMA Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'easy' || $key == 'difficulty') {
                                                            echo "<tr>";
                                                            echo "<th>Maintenance</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'inductionTime') {
                                                            echo "<h4>INDUCTION/IV agent</h4>";
                                                            echo "<tr>";
                                                            echo "<th>Time</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'halo' || $key == 'sevo' || $key == 'isofiu' || $key == 'conc') {
                                                            echo "<tr>";
                                                            echo "<th>Inhalation</th>";
                                                            echo "<td style='text-align: center'>$value %</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'suxamethonuin') {
                                                            echo "<tr>";
                                                            echo "<th>Suxanethoniun(mg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'inductionOthers') {
                                                            echo "<tr>";
                                                            echo "<th>Others</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubatYes' || $key == 'intubatNo') {
                                                            echo "<tr>";
                                                            echo "<th>INTUBATION</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubationOral') {
                                                            echo "<tr>";
                                                            echo "<th>Oral</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubationNasal') {
                                                            echo "<tr>";
                                                            echo "<th>Nasal</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'tracheostomy') {
                                                            echo "<tr>";
                                                            echo "<th>Tracheostomy</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'singleLumen') {
                                                            echo "<tr>";
                                                            echo "<th>Single lumen</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'doubleLumen') {
                                                            echo "<tr>";
                                                            echo "<th>Double lumen</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubationSize') {
                                                            echo "<tr>";
                                                            echo "<th>Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'intubationType') {
                                                            echo "<tr>";
                                                            echo "<th>Type</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'cuff') {
                                                            echo "<tr>";
                                                            echo "<th>Cuff</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'uncuff') {
                                                            echo "<tr>";
                                                            echo "<th>Uncuff</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'pre02') {
                                                            echo "<tr>";
                                                            echo "<th>Pre02</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'humidification') {
                                                            echo "<tr>";
                                                            echo "<th>Humidification</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'rapidSequence') {
                                                            echo "<tr>";
                                                            echo "<th>Rapid Sequence</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ngTube') {
                                                            echo "<tr>";
                                                            echo "<th>N/G Tube</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'fibreOptic') {
                                                            echo "<tr>";
                                                            echo "<th>Fibreoptic</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'bougie') {
                                                            echo "<tr>";
                                                            echo "<th>Bougie</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'laryngoscopy') {
                                                            echo "<tr>";
                                                            echo "<th>Laryngoscopy Grade</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'successful' || $key == 'failed') {
                                                            echo "<tr>";
                                                            echo "<th>Outcome</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'Laryngoscopist') {
                                                            echo "<tr>";
                                                            echo "<th>laryngoscopist</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'halothane') {
                                                            echo "<h4>MAINTENANCE";
                                                            echo "<tr>";
                                                            echo "<th>Halothane</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'isoflurane') {
                                                            echo "<tr>";
                                                            echo "<th>Isoflurane</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'sevoflurane') {
                                                            echo "<tr>";
                                                            echo "<th>Sevoflurane</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'desflurane') {
                                                            echo "<tr>";
                                                            echo "<th>Desflurane</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'n20') {
                                                            echo "<tr>";
                                                            echo "<th>N2O</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'air') {
                                                            echo "<tr>";
                                                            echo "<th>Air</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'analgesiaDrug') {
                                                            echo "<h4>ANALGESIA</h4>";
                                                            echo "<tr>";
                                                            echo "<th>Drug</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'analgesiaDose') {
                                                            echo "<tr>";
                                                            echo "<th>Dose(mg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'tivaDrug') {
                                                            echo "TIVA";
                                                            echo "<tr>";
                                                            echo "<th>Drug</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'infusionRate') {
                                                            echo "<tr>";
                                                            echo "<th>Infusion Rate</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'spontaneous') {
                                                            echo "<tr> <th> <h4>Ventilation</h4> </th> </tr>";
                                                            echo "<tr>";
                                                            echo "<th>Spontaneous</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'manual' || $key == 'ventilator') {
                                                            echo "<tr>";
                                                            echo "<th>Controlled</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'circle' || $key == 'semiClosed' || $key == 'bains' || $key == 'magills' || $key == 'infants' || $key == 'waters') {
                                                            echo "<tr>";
                                                            echo "<th>BREATHING SYSTEM</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ecg' || $key == 'monNIBP' || $key == 'sa02' || $key == 'erc02' || $key == 'monTemp' || $key == 'precordialStethoscope' || $key == 'inhagent') {
                                                            echo "<tr>";
                                                            echo "<th>MONITORING</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'muscleRelaxant') {
                                                            echo "<h4>MUSCLE RELAXANT";
                                                            echo "<tr>";
                                                            echo "<th>Agent</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'muscleRelaxantDose') {
                                                            echo "<tr>";
                                                            echo "<th>Dose(mg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'reversal') {
                                                            echo "<tr>";
                                                            echo "<th>Reversal</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'reversalDose') {
                                                            echo "<tr>";
                                                            echo "<th>Dose(mg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'directArterial' || $key == 'cvp' || $key == 'pappcwp' || $key == 'invasiveOthers') {
                                                            echo "<tr>";
                                                            echo "<th>INVASIVE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'line1') {
                                                            echo "<h4>VENOUS ACCESS</h4>";
                                                            echo "<tr>";
                                                            echo "<th>Line 1</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'site1') {
                                                            echo "<tr>";
                                                            echo "<th>Site</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'size1') {
                                                            echo "<tr>";
                                                            echo "<th>Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'line2') {
                                                            echo "<tr>";
                                                            echo "<th>Line 2</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'site2') {
                                                            echo "<tr>";
                                                            echo "<th>Site</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'size2') {
                                                            echo "<tr>";
                                                            echo "<th>Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'spinal' || $key == 'epidural' || $key == 'cse' || 'infiltration' || $key == 'others') {
                                                            echo "<tr>";
                                                            echo "<th><h4>REGIONAL ANAESTHESIA</h4></th>";
                                                            echo "</tr>";
                                                            echo "<tr>";
                                                            echo "<th>TYPE</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'position') {
                                                            echo "<tr>";
                                                            echo "<th>Position</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'regionalSite') {
                                                            echo "<tr>";
                                                            echo "<th>Site</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'needleSize') {
                                                            echo "<tr>";
                                                            echo "<th>Needle Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'regionalDrug') {
                                                            echo "<tr>";
                                                            echo "<th>Drug</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'regionalDose') {
                                                            echo "<tr>";
                                                            echo "<th>Dose(mg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'complete' || $key == 'patchy' || $key == 'qfailed') {
                                                            echo "<tr>";
                                                            echo "<th>Block Quality</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'blockHeight') {
                                                            echo "<tr>";
                                                            echo "<th>Block Height</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'performedBy') {
                                                            echo "<tr>";
                                                            echo "<th>Performed By</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'operationPer') {
                                                            echo "<tr>";
                                                            echo "<th>Operation Performed</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'criticalIncidences') {
                                                            echo "<tr>";
                                                            echo "<th>Critical incidences</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'colloid') {
                                                            echo "<tr>";
                                                            echo "<th>Total Fluid: Colloid</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'crystalloid') {
                                                            echo "<tr>";
                                                            echo "<th>Crystalloid</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'bloodTransfused') {
                                                            echo "<tr>";
                                                            echo "<th>Total Blood Transfused</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'suctionBottle') {
                                                            echo "<tr>";
                                                            echo "<th>Suction Bottle</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'spogesDrapes') {
                                                            echo "<tr> <th>Estimated Blood Loss</th> </tr>";
                                                            echo "<tr>";
                                                            echo "<th>Spoges/Drapes</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'floor') {
                                                            echo "<tr>";
                                                            echo "<th>Floor</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'bloodTotal') {
                                                            echo "<tr>";
                                                            echo "<th>Total</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'satisfactory' || $key == 'unsatisfactiory' || $key == 'icu') {
                                                            echo "<tr>";
                                                            echo "<th>POST OPERATIVE STATUS</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'post_hr') {
                                                            echo "<tr> <th><h4>VITAL SIGNS</h4></th> </tr>";
                                                            echo "<tr>";
                                                            echo "<th>Size</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'post_bp') {
                                                            echo "<tr>";
                                                            echo "<th>BP(mmHg)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'post_sa02') {
                                                            echo "<tr>";
                                                            echo "<th>Sa02(%)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'post_temp') {
                                                            echo "<tr>";
                                                            echo "<th>Temp(℃)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'etc02') {
                                                            echo "<tr>";
                                                            echo "<th>ETC02</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'timeDelivered') {
                                                            echo "<tr> <th><h4>BABY APGAR SCORE </h4></th> </tr>";
                                                            echo "<tr>";
                                                            echo "<th>Temp(℃)</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'remarks') {
                                                            echo "<tr>";
                                                            echo "<th>Remarks</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'emergencySatisfactory' || $key == 'emergencyUnSatisfactory') {
                                                            echo "<tr> <th><h4>Emegency Airway Assessment</h4></th>";
                                                            echo "<tr>";
                                                            echo "<th>Post-Extubation Status</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'ett') {
                                                            echo "<tr>";
                                                            echo "<th>ETT left in situ</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'why') {
                                                            echo "<tr>";
                                                            echo "<th>If yes, why</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'reIntubationTheatre') {
                                                            echo "<tr>";
                                                            echo "<th>Re-intubation in theatre</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    if (isset($value) and !empty($value)) {
                                                        if ($key == 'comments') {
                                                            echo "<tr>";
                                                            echo "<th>Comments</th>";
                                                            echo "<td style='text-align: center'>$value</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                              <?php  }
                                ?>
                            </ul>

                        <?php }  ?>



                        <?php
                        $test_request = TestRequest::find_requests($waitList->id, $patient->id);
                        if (!empty($test_request)) {
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> LABORATORY TEST REQUEST
                                        </b></li>
                                </ol>
                            </nav>
                            <ul style="font-size: large">
                                <?php
                                $t_Request = TestRequest::find_requests($waitList->id, $patient->id);
                                if (empty($t_Request)) {
                                    echo "<h5>No Lab Investigation selected</h5>";
                                } else {
                                    $e_Test = EachTest::find_all_requests($t_Request->id);

                                    $result = Result::find_checked_test_request($t_Request->id);
                                    if (empty($result)) {
                                        // echo "Test Result Not Available yet";
                                    } else {
                                        //  print_r($result);
                                    }
                                    foreach ($e_Test as $e) {
                                        echo "<li> $e->test_name</li>";
                                    }
                                    if (!empty($t_Request->doc_com))
                                        echo " Request Note: " .  $t_Request->doc_com . "<br/>";
                                }
                                ?>
                            </ul>
                            <?php
                            if (isset($t_Request->id)){
                                $results = Result::find_checked_test_request($t_Request->id);
                                if (empty($results)) {
                                    echo "Test Result Not Available yet";
                                }
                                else {
                                    foreach ($results as $result) {
                                        switch ($result->dept) {
                                            case "Microbiology":
                                                include("../labResults/micro_res.php");
                                                break;
                                            case "Haematology":
                                                include("../labResults/haem_res.php");
                                                break;
                                            case "Chemical Pathology":
                                                include("../labResults/chem_res.php");
                                                break;
                                            case "Parasitology":
                                                include("../labResults/para_res.php");
                                                break;
                                            case "Histology":
                                                include("../labResults/histo_res.php");
                                                break;
                                            default:
                                                echo "";
                                        }


                                    }
                                }
                            }

                            ?>
                        <?php }   ?>

                        <?php
                        $scan_request = ScanRequest::find_requests($waitList->id, $patient->id);
                        if (!empty($scan_request)) {
                            ?>
                            <br/>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> RADIOLOGY/ULTRASOUND REQUEST
                                        </b></li>
                                </ol>
                            </nav>
                            <ul style="font-size: large">
                                <?php
                                $s_Request = ScanRequest::find_requests($waitList->id, $patient->id);
                                if (empty($s_Request)) {
                                    echo "<h5>No Xray/Ultrasound selected</h5>";
                                } else {
                                    $e_Scan = EachScan::find_all_requests($s_Request->id);
                                    //   print_r($e_Scan);
                                    foreach ($e_Scan as $scan) {
                                        echo "<li> $scan->scan_name</li>";
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                            if (!empty($s_Request->doc_com))
                                echo "<b>Note: </b>" .  $s_Request->doc_com . "<br/>";
                            ?>
                        <?php }
                        if (isset($s_Request->id)){
                            $results = ScanResult::find_completed_results_by_scan_req($s_Request->id);
                            if (empty($results)) {
                                echo " Result Not Available yet";
                            }
                            else {
                                foreach ($results as $result) {
                                    include("../rad/rad_res.php");
                                }
                            }
                        }
                        ?>

                       <!-- --><?php
/*                        $results = ScanResult::find_completed_results_by_scan_req($s_Request->id);
                        if (empty($results)) {
                            echo " Result Not Available yet";
                        }
                        else {
                            foreach ($results as $result) {
                                include("../rad/rad_res.php");
                            }
                        }
                        */?>




                        <?php
                        $drug_request = DrugRequest::find_requests($waitList->id, $patient->id);
                        if (!empty($drug_request)) {
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> DRUG PRESCRIPTION
                                        </b></li>
                                </ol>
                            </nav>
                            <ul style="font-size: large">
                                <?php
                                $d_Request = DrugRequest::find_requests($waitList->id, $patient->id);

                                if (empty($d_Request)) {
                                    echo "<h5>No drugs selected</h5>";
                                } else {
                                    $e_Drug = EachDrug::find_all_requests($d_Request->id);
                                    $table = "                                                       
                                                        <table class='table table-bordered table-condensed table-hove'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Drug(s)</th>
                                                                    <th>Duration</th>
                                                                    <th>Dosage</th>
                                                                </tr>
                                                            </thead>                                          
                                                            <tbody>";
                                    foreach ($e_Drug as $drug) {
                                        $table .=
                                            "<tr><td>$drug->product_name</td>
                                                                    <td>$drug->duration </td>
                                                                    <td>$drug->dosage</td>
                                                               </tr>
                                                  
                                                        ";
                                    }
                                    $table .= "</tbody>
                                                    </table> ";
                                    echo $table;

                                }
                                ?>
                            </ul>
                        <?php }  ?>

                        <?php
                        //   $referral    = Referrals::find_pending_referrals($waitList->id, $patient->id);
                        $referral    = Referrals::find_patient_referral($waitList->id, $patient->id);
                        if (!empty($referral)) {
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> CLINIC REFERRALS
                                        </b></li>
                                </ol>
                            </nav>
                            <ul style="font-size: medium">
                                <?php
                             //   $referral    = Referrals::find_pending_referrals($waitList->id, $patient->id);
                                $referral    = Referrals::find_patient_referral($waitList->id, $patient->id);
                                if (!empty($referral)) {
                                    $cur_clinic = SubClinic::find_by_id($referral->current_sub_clinic_id);
                                    $sub_clinic = SubClinic::find_by_id($referral->referred_sub_clinic_id);
                                }
                                ?>
                                <table>
                                    <tr>
                                        <th>Referred From:</th>
                                        <td style="padding-left: 50px"><?php echo $cur_clinic->name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Referred Clinic:</th>
                                        <td style="padding-left: 50px"><?php echo $sub_clinic->name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Referral Note:</th>
                                        <td style="padding-left: 50px"><?php echo $referral->referral_note ?></td>
                                    </tr>
                                </table>

                            </ul>

                        <?php }   ?>

                        <?php
                     //   $appointment = Appointment::find_pending_appointment($waitList->id, $patient->id);
                        $appointment = Appointment::find_patient_appointment($waitList->id, $patient->id);
                        if (!empty($appointment)) {
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> APPOINTMENT
                                        </b></li>
                                </ol>
                            </nav>
                            <ul style="font-size: large">
                                <?php
                                $appointment = Appointment::find_patient_appointment($waitList->id, $patient->id);
                                if (empty($appointment)) {
                                    echo "No Appointment";
                                } else {
                                    echo $appointment->next_app;
                                }

                                ?>
                            </ul>
                        <?php }    ?>

                        <?php
                        $admission = ReferAdmission::find_by_waiting_list($waitList->id, $patient->id);
                        if (!empty($admission)) {
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><b> ADMISSION DETAILS
                                        </b></li>
                                </ol>
                            </nav>

                                <h4>Patient has been admitted, Do the UI</h4>


                        <?php }  ?>

                        <br/>  <br/>
                        <p class="text-info" style="font-size: larger"><code></code>
                             Done
                            By <?php echo $waitList->dr_seen ?>
                        </p>









                    </div>



