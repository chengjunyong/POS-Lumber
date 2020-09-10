<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Voler</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">
  <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">
  <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>
<body>
  <div id="app">
    <div id="sidebar" class='active'>
      <div class="sidebar-wrapper active">
        <div class="sidebar-header">
          <img src="assets/images/logo.svg" alt="" srcset="">
        </div>
        <div class="sidebar-menu">
          <ul class="menu">
            <li class='sidebar-title'>Main Menu</li>
            <li class="sidebar-item {{ $current == 'index' ? 'active' : '' }}" >
              <a href="{{ route('getIndex') }}" class='sidebar-link'>
                <i data-feather="home" width="20"></i> 
                <span>Dashboard</span>
              </a>
            </li> 

            <li class="sidebar-item {{ $current == 'company' ? 'active' : '' }} has-sub" >
              <a href="#" class='sidebar-link'>
                <i data-feather="user-check" width="20"></i> 
                <span>Company</span>
              </a>
              <ul class="submenu {{ $current == 'company' ? 'active' : '' }}">
                <li>
                    <a href="{{ route('getCompany') }}">Company List</a>
                </li>
                <li>
                    <a href="{{ route('getAddProfile') }}">Add Company Profile</a>
                </li>
              </ul>
            </li>   
 
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
      </div>
    </div>
    <div id="main">
  <!-- <nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav> -->
  <div class="main-content container-fluid">