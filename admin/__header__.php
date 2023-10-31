<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tanzy's Admin</title>
    <link rel="shortcut icon" href="../static/img/tanzy_icon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="../static/css/loader.css">
    <link rel="stylesheet" href="../static/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  

</head>
<style>

</style>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">

                <div class="card sticky-top">
                    <div class="card-header">
                        <center>
                            <h4>
                                <a href="../index.html" class="brand">Tanzy Admin</a>
                            </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        Welcome, <b> <?php echo $_SESSION['username']; ?></b>!
                        <div class="card my-3">
                            <div class="card-header">
                                <h6>Menu</h6>
                            </div>
                            <div class="card-body">
                                <div class="nav-item">
                                    <a class="nav-link text-truncate" href="items.php"><i class="fa fa fa-shopping-basket"></i> <span class="d-none d-sm-inline">Items</span></a>
                                </div>

                                <div class="nav-item">
                                    <a class="nav-link text-truncate" href="categories.php"><i class="fa fa fa-tasks"></i> <span class="d-none d-sm-inline">Categories</span></a>
                                </div>

                                <div class="nav-item">
                                    <a class="nav-link text-truncate" href="orders.php"><i class="fa fa fa-inbox"></i> <span class="d-none d-sm-inline">Orders</span></a>
                                </div>

                                <div class="nav-item">
                                    <a class="nav-link text-truncate" href="inventory.php"><i class="fa fa-archive"></i> <span class="d-none d-sm-inline">Inventory</span></a>
                                </div>

                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa fa-bar-chart"></i> <span class="d-none d-sm-inline">Reports</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="sales_report.php">Sales Report</a>
                                        <a class="dropdown-item" href="savings_report.php">Savings Report</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="nav-item ">
                            <a class="nav-link btn-block btn btn-info text-white" href="../index.html"><span class="fa fa-arrow-left"></span> Back to Website</a>
                        </div>
                        <div class="nav-item ">
                            <button class="btn-block btn btn-outline-danger " onclick="logout()">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9" style="border-left:1px solid lightgrey">