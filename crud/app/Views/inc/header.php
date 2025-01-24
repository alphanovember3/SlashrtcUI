<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="CodeIgniter 4 CRUD tutorial"/>
<meta name="author" content = "Ayush" />
<title>CodeIgniter CRUD </title>

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<!-- <script src="/assets/js/jquery.js"></script> -->
<!-- <script src="/assets/js/popper.js"></script> -->
<!-- <script src="/assets/js/bootstrapN.js"></script> -->
<!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css">  -->

<!-- <script src="/assets/js/main.js"></script> -->

<!-- <link rel="stylesheet" href="assets/css/style.css"> -->


<script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>

<script src="<?php echo base_url('assets/js/popper.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrapN.js') ?>"></script>


<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">


<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>"> 

<script src="<?php echo base_url('assets/js/main.js') ?>"></script>

<style>

    /* this is styling for the confirm modal */
        /* Custom styles for the modal */
        .modal-header {
            background-color: #059c3e;
            color: white;
        }
        .modal-footer {
            justify-content: space-between;
        }

        .myclass-defined{
           display: flex;
           gap: 10px;
            padding-top: 5px;
           align-items: center;
           padding-left: 30px;
        }

        .pager{

            background-color: #059c3e;
            color:rgb(87, 16, 145);
            font-size: larger;
        }
    </style>
</head>
<body>   