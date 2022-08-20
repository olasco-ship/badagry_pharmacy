<?php
/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 4/1/2019
 * Time: 9:25 AM
 */
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}


$index = 1;

$user = User::find_by_id($session->user_id);


require('../../layout/header.php');



?>


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Store Count </h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Drug Count History</li>
                         
                        </ul>
                    </div>
                
                </div>
            </div>



            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card patients-list">
                     
                        <div class="body">
                        
                            <a href="index.php" style="font-size: large">&laquo; Back</a>
                            <?php echo output_message($message); ?>
                            <ul class="nav nav-tabs-new2">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#All"> Drug Count History  </a></li>
                            </ul>
                            <div class="tab-content m-t-10 padding-0">
                                <div class="tab-pane table-responsive active show" id="All">
                                    <table class="table m-b-0 table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th> S/N</th>
                                            <th> Actual Drugs Counted  </th>
                                            <th> Exceptions </th>
                                            <th> Counted By </th>
                                            <th> Date </th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                    <?php
                                    
                                         $history = StoreCount::find_all_by_date();
                                          foreach($history as $h) {   ?>
                                            <tr>
                                                <td> <?php echo $index++ ?> </td>
                                                <td><?php echo $h->no_counted_items ?></td>
                                                <td><?php echo $h->no_incorrect_items  ?></td>
                                                <td><?php echo $h->counted_by ?></td>
                                                <td><?php $d_date = date('d/m/Y h:i a', strtotime($h->date)); echo $d_date ?></td>
                                                <td><a href="view_history.php?id=<?php echo $h->id ?>">View Details</a></td>
                                            </tr>
                                        <?php }  ?>

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





<?php

require('../../layout/footer.php');























