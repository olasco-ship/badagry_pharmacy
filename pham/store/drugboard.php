<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 5/18/2019
 * Time: 1:41 PM
 */


require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}


$user = User::find_by_id($session->user_id);

$items = PatientBill::get_bill();


if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    $drug        = $_POST['drug'];
    $quantity    = $_POST['quantity'];

    $counted_items = array();
    for ($x = 0; $x < count($drug); $x++) {
        $product           = Product::find_by_name($drug[$x]);
        $sumProductQty     = ProductBatch::sumProductQuantity($product->id);
        $counted_items[$x] = array(
            "name"       => $drug[$x], 
            'quantity'   => $quantity[$x],
            'system_qty' => $sumProductQty    // Try this also $product->total_quantity[$x]
        );
    }

 //   print_r($counted_items);  exit;

    $incorrect_items = array();
    $counter         = 0;
    foreach ($counted_items as $item) {
        $product         = Product::find_by_name($item['name']);
        $sumProductQty   = ProductBatch::sumProductQuantity($product->id);
        if ($sumProductQty != $item['quantity']){
            $counter++;
            $incorrect_items = array(
                "name"       => $item['name'], 
                'quantity'   => $item['quantity'],
                'system_qty' => $sumProductQty
            );
        }
    }


    $storeCount                     = new StoreCount();
    $storeCount->sync               = "off";
    $storeCount->counted_items      = json_encode($counted_items);
    $storeCount->no_counted_items   = count($counted_items);
    $storeCount->incorrect_items    = json_encode($incorrect_items);
    $storeCount->no_incorrect_items = $counter;      // count($incorrect_items);
    $storeCount->counted_by         = $user->full_name();
    $storeCount->remarks            = $_POST['remarks'];
    $storeCount->date               = strftime("%Y-%m-%d %H:%M:%S", time());
    $storeCount->save();
    PatientBill::clear_all_bill();
    redirect_to("history.php");


}



//PatientBill::clear_all_bill();


require('../layout/header.php');
?>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        Pharmacy </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Counted Drugs</li>
                    </ul>
                </div>
                
            </div>
        </div>

        <div class="row clearfix">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                   
                    <div class="body">

                        <div class="row clearfix">
                            <div class="col-sm-12">

                            <a href="update.php">Back</a>

                                <div>

                                    <table class="table table-bordered table-condensed table-hover">


                                        <thead>
                                            <tr>
                                                <th>Drug(s)</th>
                                                <th> Quantity</th>
                                                <!--
                                                <th>Carton(s)</th>
                                                <th>No. In Carton</th>
                                                <th>Unit Quantity</th>
                                                -->


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
                                                        <td><input type='text' class='form-control' name='quantity[]' value='' style='width:100px;'> </td>
                                                        <!--
                                                        <td><input type='text' class='form-control' name='carton[]' value='' style='width:100px;'></td>
                                                        <td>
                                                            <input type='text' class='form-control' name='no_carton[]' value='' style='width:100px;'>
                                                        </td>
                                                        <td><input type='text' class='form-control' name='quantity[]' value='' style='width:100px;'> </td>
                                                        -->
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td colspan="4"><textarea class='form-control' rows='2' cols='70' placeholder='Remarks' name='remarks'></textarea></td>
                                                </tr>
                       

                                                <tr>
                                                    <td colspan="4"><button type="submit" class="btn btn-success"> Save Report </button></td>
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
require('../layout/footer.php');
?>