<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/24/2019
 * Time: 9:19 AM
 */

require_once "../../includes/initialize.php";



if (is_post()) {

    if (isset($_POST['save_drug'])) {
        //   $items = TestBill::get_bill();
        $items = PatientBill::get_bill();
        $item = $items[0];

        redirect_to("index.php");
    }
}

PatientBill::clear_all_bill();


require '../../layout/header.php';


?>


<input type="hidden" value="<?= $_GET['id'] ?>" id="pat_hide_id" />
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                    Store Count
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Update Store Count</li>
                    </ul>
                </div>
              
            </div>
        </div>


        <div class="row clearfix">

            <div class="col-md-12">
                <div class="card">

                    <div class="body">

                        <div class="col-lg-12 col-md-12">

                            <a href="../store/index.php" style="font-size: large">Back</a>

                            <ul class="nav nav-tabs-new2">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#new_treatment"> Count Drugs </a></li>
                            </ul>

                            <div class="card">
                                <div class="body">
                                    <?php
                                    if (!empty($message)) { ?>
                                        <div id="success" class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?php echo output_message($message); ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="new_treatment">
                                            <div class="tab-pane show active" id="TodayVitals">
                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <h5> Enter Counted Drugs </h5>
                                                        <form id="formUpdate">
                                                            <div class=" form-group">
                                                                <input type="text" placeholder="Name Of Drug" name="txtProduct" id="txtProduct" autocomplete="off" class="typeahead" />
                                                                <button type="submit" id="submit" class="btn btn-lg btn-info" data-loading-text="Searching...">Search
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-sm-12" id="save_page">
                                                        <?php
                                                        echo PatientBill::save_page();
                                                        ?>
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
        </div>
    </div>

</div>

<?php
require '../../layout/footer.php';
?>


<script>
    $(document).ready(function() {

        $('#formUpdate')
            .on('submit', function($ev){
                $ev.preventDefault();
                var name      = $('#formUpdate input#txtProduct').val();
                var stationId = $('#formUpdate input#stationId').val();
                $.post('drug_cart.php', {name: name, stationId: stationId})
                    .done(function (data) {
                        //      $("#check").html(data.bill);
                        $("#save_page").html(data.save_bill);
                        $("#flow_one").html(data.flow);
                        //    $('#txtProduct').focus();
                        $('#txtProduct').val('');
                    });
            });

        $(".addBut").click(function() {
            if ($("#add_wall_balance").val() > 0) {
                $("#myModal2").modal({
                    backdrop: "static"
                });
                //    var totBalance = ($("#wall_balance").val() != "") ? $("#wall_balance").val() : 0;
                //    var tot = 0;
                //    var addWall = ($("#add_wall_balance").val() != "") ? $("#add_wall_balance").val() : 0;
                //    tot = parseInt(totBalance) + parseInt(addWall);
                //    $("#wall_balance").val(tot);
                //    $("#add_wall_balance").val(0);

                $.ajax({
                    url: 'test_bill.php',
                    data: {
                        id: $("#pat_hide_id").val(),
                        first_name: $("#first_name").val(),
                        last_name: $("#last_name").val()
                    },
                    type: "GET",
                    success: function(data) {
                        console.log(data.lastBill.id);
                        if (data.status == "Done") {
                            $("#lastPaymentId").val(data.lastBill.id);
                        }
                    }
                });
            } else {
                alert("Please fill amount to be paid!!");
                return false;
            }
        });

        $(".ClosePayment").click(function() {
            //alert($("#add_wall_balance").val());
            $(".page-loader-wrapper").show();
            $.ajax({
                url: 'test_bill_new.php',
                data: {
                    ids: $("#lastPaymentId").val(),
                    code: $("#codeFour").val(),
                    total_price: $("#add_wall_balance").val()
                },
                type: "GET",
                success: function(data) {
                    //$("#closeBut").trigger("click");
                    if (data.status) {
                        var totBalance = ($("#wall_balance").val() != "") ? $("#wall_balance").val() : 0;
                        var tot = 0;
                        var addWall = ($("#add_wall_balance").val() != "") ? $("#add_wall_balance").val() : 0;
                        tot = parseInt(totBalance) + parseInt(addWall);
                        $("#wall_balance").val(tot);
                        $("#add_wall_balance").val(0);
                        $(".page-loader-wrapper").hide();
                    } else {
                        alert("No success due to error!!");
                        $(".page-loader-wrapper").hide();
                    }
                }
            });
            $("#myModal2").modal('toggle');
        });

        $(".nav-link-goto").click(function() {
            $(".titleData").show();
        });

        $(".gotoEdit").click(function() {
            $(".nav-link-goto").trigger("click");
            $(".titleData").hide();
        });


        // Search Ward according to location
        $(".bed_location_id_doctors").change(function() {
            var urls = $(".urlWard").val();
            //'../revenue/beds.php',
            $.ajax({
                url: "dashboard.php",
                data: {
                    ward_id: $(this).val()
                },
                type: "GET",
                success: function(data) {
                    $(".ward_id").empty();
                    $(".ward_id").html(data);

                },
                error: function(error) {
                    alert("Error in connection");
                }
            });
        });


        $(".ward_change_nurse").change(function() {
            $.ajax({
                url: 'patient_detail.php',
                data: {
                    location_id: $(".bed_location_id_nurse").val(),
                    ward_id_change_room: $(this).val()
                },
                type: "GET",
                success: function(data) {
                    $(".room_no_nurse").empty();
                    $(".room_no_nurse").html(data);

                },
                error: function(error) {
                    alert("Error in connection");
                }
            });
        });


        // Room number according to bed jquery
        $(".room_no_nurse").change(function() {
            //alert($(this).children("option:selected").html());
            var typeLog = $(".typeLogin").val();
            var patId = $("#pat_hide_id").val();
            $.ajax({
                url: 'patient_detail.php',
                data: {
                    bed_location_id: $(".bed_location_id_nurse").val(),
                    bed_ward_id_change_room: $(".ward_change_nurse").val(),
                    room_no_id: $(this).children("option:selected").html(),
                    patientId: patId,
                    room_no_main_id: $(this).children("option:selected").val()
                },
                type: "GET",
                success: function(data) {
                    $(".bed_no").empty();
                    $(".bed_no").html(data);

                },
                error: function(error) {
                    alert("Error in connection");
                }
            });
        });








    });
</script>