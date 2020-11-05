<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Vegavest</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">
  <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">
  <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
</head>
<body>
  <div id="app">
    <div id="sidebar" class='active'>
      <div class="sidebar-wrapper active">
        <div class="sidebar-header">
          <img src="assets/images/logo.png" alt="" srcset="" style="height:1.8rem !important;">
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

            <li class="sidebar-item {{ $current == 'item' ? 'active' : '' }} has-sub" >
              <a href="#" class='sidebar-link'>
                <i data-feather="server" width="20"></i> 
                <span>Items</span>
              </a>
              <ul class="submenu {{ $current == 'item' ? 'active' : '' }}">
                <li>
                    <a href="{{ route('getProduct') }}">Product</a>
                </li>
                <li>
                    <a href="{{ route('getVariation') }}">Variation</a>
                </li>
              </ul>
            </li>

            <li class="sidebar-item {{ $current == 'invoice' ? 'active' : '' }} has-sub" >
              <a href="#" class='sidebar-link'>
                <i data-feather="file-text" width="20"></i> 
                <span>Invoice</span>
              </a>
              <ul class="submenu {{ $current == 'invoice' ? 'active' : '' }}">
                <li>
                    <a href="{{ route('getInvoice') }}">Generate Invoice</a>
                </li>
                <li>
                    <a href="{{route('getHistory')}}">History</a>
                </li>
              </ul>
            </li>

            <li class="sidebar-item {{ $current == 'credit_note' ? 'active' : '' }}" >
              <a href="{{ route('getCreditNote') }}" class='sidebar-link'>
                <i data-feather="file-minus" width="20"></i> 
                <span>Credit Note</span>
              </a>
            </li>  

            <li class="sidebar-item {{ $current == 'report' ? 'active' : '' }} has-sub" >
              <a href="#" class='sidebar-link'>
                <i data-feather="bar-chart-2" width="20"></i> 
                <span>Report</span>
              </a>
              <ul class="submenu {{ $current == 'report' ? 'active' : '' }}">
                <li>
                    <a href="{{ route('getCashBook') }}">Debtor Report</a>
                </li>
                <li>
                    <a href="{{ route('getMonthlyReport') }}">Monthly Report</a>
                </li>
                <li>
                    <a href="{{ route('getSpecifyDateReport') }}">Specify Date Report</a>
                </li>
                <li>
                    <a href="{{ route('getCompanyBasedReport') }}">Company Based Report</a>
                </li>
              </ul>
            </li> 

            <li class="sidebar-item {{ $current == 'payment' ? 'active' : '' }}" >
              <a href="{{ route('getPayment') }}" class='sidebar-link'>
                <i data-feather="dollar-sign" width="20"></i> 
                <span>Payment</span>
              </a>
            </li>     

          </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
      </div>
    </div>
    <div id="main">
      <nav class="navbar navbar-header navbar-expand navbar-light">
        <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
        <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>

  <div class="main-content container-fluid">