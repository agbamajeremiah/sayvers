<!-- Test -->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    if(!isset($this->session->token) || $this->session->logged_in !== TRUE){
        redirect(base_url()."admin\login");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <title>Sayvers | Admin</title>
    <link rel="shortcut icon" href="<?php echo  base_url('images/sayver_logo.png'); ?>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=PT+Sans&display=swap');
        body{
            font-family: 'PT Sans', sans-serif;
            font-size: 15px;
        }
        .bg-main{
            background: #2F55D4;
            color: #FFF;
        }
        .h-7{
            height: 7vh;
        }
        .mt-50{
            margin-top: 50px;
        }
        .mt-30{
            margin-top: 30px;
        }
        .side_admin_bar{
            margin-top: 7vh;
            min-height: 93vh;
            background-color: rgba(0,0,0,.05);
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            overflow-x: hidden;
        }
        .main{
            margin-top: 7vh;
            margin-left: 250px
        }
        .btn-sm{
            width: 75px;
        }
        @media screen and (max-width: 800px) {
            .side_admin_bar {
                width: 130px;
            }
            .main{
                margin-left: 130px
            }
        }
         @media screen and (max-width: 480px) {
            .side_admin_bar {
                width: 130px;
            }
            .main{
                margin-left: 130px
            }
            .btn-sm{
                padding: .25rem .5rem;
                font-size: .675rem;
                line-height: 1.2;
                border-radius: .2rem;
                width: 65px;
            }
        }
        .field_error{
            font-size: 12px;
        }
        .alert_block{
            width: 150px;
        }
        /*side-nav dropdown*/
        .sidenav {
          padding-top: 20px;
        }
        /* Style the sidenav links and the dropdown button */
        .sidenav a, .dropdown-btn 
        {
            padding: 6px 8px;
            font-family: 'PT Sans', sans-serif;
            text-decoration: none;
            font-size: 14px;
            color: #212529;
            display: block;
            border: none;
            background: none;
            width:100%;
            text-align: left;
            cursor: pointer;
            outline: none;
            transition: all 0.3s;
        }
        .dropdown-btn:focus{
            outline: none;
        }
        /* On mouse-over */
        .sidenav a:hover, .dropdown-btn:hover {
            color: #2F55D4;
        }
        .sidenav a span{
            margin-right: 5px;
        }
        /* Add an active class to the active dropdown button */
        .active {
            color: #2F55D4;
            border: none;
        }
        .dropdown-container {
            display: none;
            padding-left: 8px;
            transition: linear 0.3s;
        }
        .dropdown-container a{
            font-size: 13px;
         }
        .fa-caret-down {
            float: right;
            padding-top: 4px;
            padding-right: 8px;
        }
        table{
            table-layout:fixed;
        }
        .table td, .table th {
            padding: .5rem;
            vertical-align: center !important;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
            word-wrap:break-word;
        }
        .table th{
            text-align: center;
        }
        .post_img{
            width: 70px;
            height: 40px;
        }
        /* Main section */
        .bg-light-grey{
            background-color: rgba(0,0,0,.05);
        }
        /* Manage users btn */
        .block-user-btn:focus, .unblock-user-btn:focus{
            box-shadow: none;
        }
        body.modal-open .modal {
            display: flex !important;
            height: 60%;
        } 
        body.modal-open .modal .modal-dialog {
            margin: auto;
        }
        .btn:focus{
            box-shadow: none;
        }
        .btn-block{
			background-color: #2F55D4;
		}
        .btn-block:focus{
			box-shadow: none;
		}
        .fund_message{
			font-size: 12px;
			width: 200px;
		}
		.form-control:focus {
			color: #495057;
			background-color: #fff;
			border-color: #2F55D4;
			outline: 0;
			box-shadow: none;
		}
        .fund-message{
            font-size: 12px;
			width: 200px;
        }
        .card-bg-none{
            background-color: inherit;
            border: none;
        }
        .update-btn{
            font-size: 13px;
            color: #FFF;
            background-color: #2F55D4;
        }
        .update-btn:hover {
            color: #6c757d;
            text-decoration: none;
        }
        .update-btn:focus{
            box-shadow: none;
        }
            
    </style>
  </head>
  <body>
        <div class="container-fluid">
            <section class= "">
                <div class="navbar fixed-top navbar-light row h-7 bg-main">
                    <div class="ml-auto">
                    <div class="mr-5"><h6><?php echo $this->session->username; ?></h6></div>
                        
                    </div>
                </div>
            </section >
            <section>
                <div class="row">
                    <section class="side_admin_bar h-93">
                            <div class="sidenav">
                                <div><a href="dashboard"><span>Dashboard</span></a></div>

                                <button class="dropdown-btn">Users
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-container">
                                    <a href="<?php echo base_url(); ?>admin/users">Manage Users</a>
                                </div>
                                <button class="dropdown-btn">Wallet
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-container">
                                    <a href="<?php echo base_url(); ?>admin/withdrawals">Manage Withdrawals</a>
                                    <a href="<?php echo base_url(); ?>admin/wallets">View Wallets</a>

                                </div>
                               
                                <div class="settings-btn"></div><a href="settings"><span>Settings</span></a>

                                <div class="logout-btn"></div><a href="logout"><span>Logout</span></a>
                        </div>
                    </section>
                    <section class="main w-100">
                    <!--include here-->