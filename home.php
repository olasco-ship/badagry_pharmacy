<?php
require_once("includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to(emr_lucid . "/index.php");
}


require('layout/header.php');
?>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <!--                        <div class="col-lg-6 col-md-8 col-sm-12">-->
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                    class="fa fa-arrow-left">
                            </i></a> OBAFEMI AWOLOWO UNIVERSITY TEACHING HOSPITAL COMPLEX</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Electronic Medical Record</li>
                        <li class="breadcrumb-item">Main Dashboard</li>

                    </ul>
                </div>

            </div>
        </div>

        <div class="row clearfix">

            <div class="col-lg-9 col-md-12">
                <div class="card">
                    <div class="body">
                        <div id="demo" class="carousel slide" data-ride="carousel">

                            <ul class="carousel-indicators">
                                <li data-target="#demo" data-slide-to="0" class="active"></li>
                                <li data-target="#demo" data-slide-to="1"></li>
                                <li data-target="#demo" data-slide-to="2"></li>
                            </ul>

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="carousel/1.png" alt="Pharmacy" width="1100" height="500">
                                </div>
                                <div class="carousel-item">
                                    <img src="carousel/ross.jpg" alt="Pharmacy" width="1100" height="500">
                                </div>
                                <div class="carousel-item">
                                    <img src="carousel/2.jpg" alt="Pharmacy" width="1100" height="500">
                                </div>
                            </div>

                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>


                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-md-12">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                                <div id="top_counter1" class="carousel vert slide" data-ride="carousel"
                                     data-interval="2500">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="icon"><i class="fa fa-user"></i></div>
                                            <div class="content">
                                                <div class="text">Total Patient</div>
                                                <h5 class="number">215</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="icon"><i class="fa fa-user"></i></div>
                                            <div class="content">
                                                <div class="text">New Patient</div>
                                                <h5 class="number">21</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="top_counter2" class="carousel vert slide" data-ride="carousel"
                                     data-interval="2100">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="icon"><i class="fa fa-user-md"></i></div>
                                            <div class="content">
                                                <div class="text">Laboratory</div>
                                                <h5 class="number">06</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="icon"><i class="fa fa-user-md"></i></div>
                                            <div class="content">
                                                <div class="text">Radiology</div>
                                                <h5 class="number">04</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="icon"><i class="fa fa-user-md"></i></div>
                                            <div class="content">
                                                <div class="text">Treatment</div>
                                                <h5 class="number">23</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                                <div id="top_counter3" class="carousel vert slide" data-ride="carousel"
                                     data-interval="2300">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="icon"><i class="fa fa-eye"></i></div>
                                            <div class="content">
                                                <div class="text">Total Visitors</div>
                                                <h5 class="number">10K</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="icon"><i class="fa fa-eye"></i></div>
                                            <div class="content">
                                                <div class="text">Today Visitors</div>
                                                <h5 class="number">142</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="icon"><i class="fa fa-eye"></i></div>
                                            <div class="content">
                                                <div class="text">Month Visitors</div>
                                                <h5 class="number">2,087</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="icon"><i class="fa fa-university"></i></div>
                                <div class="content">
                                    <div class="text">Revenue</div>
                                    <h5 class="number">₦18,925</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon"><i class="fa fa-thumbs-o-up"></i></div>
                                <div class="content">
                                    <div class="text">Happy Patients</div>
                                     <h5 class="number">528</h5>
                                </div>
                                <hr>
                                <div class="icon"><i class="fa fa-smile-o"></i></div>
                                <div class="content">
                                    <div class="text">Smiley Faces</div>
                                       <h5 class="number">2,528</h5>
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

require('layout/footer.php');