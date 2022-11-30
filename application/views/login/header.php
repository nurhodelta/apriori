<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title><?php echo $title; ?></title>

    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon"> -->

    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/dist/css/bootstrap.min.css'); ?>"> 
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css'); ?>"> 
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css'); ?>"> 
    <link rel="stylesheet" href="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.css'); ?>"> 
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">  
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,500,700' rel='stylesheet' type='text/css'>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="hold-transition login-page"> 

  <span class="base_url" data-value="<?= base_url(); ?>">
  <div id="loader">
  	<div id="loader-image"><i class="fa fa-spinner fa-spin"></i></div>
  </div>