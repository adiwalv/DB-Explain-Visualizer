<?php
session_start();
require('lib/definitions.php');
$find_query = makeString($_POST["find_query"]);
$sort_query = makeString($_POST["sort_query"]);
if($find_query==NULL){
$find_query="{}";
}
if($sort_query==NULL){
$sort_query="{}";
}
if($_POST["limit_query"]==NULL){
$limit_query="";
} else {
$limit_query = (int)$_POST["limit_query"];
}
$query = "\"db.{$_POST["collection_name"]}.find({$find_query}).sort({$sort_query}).limit({$limit_query}).explain('allPlansExecution');\"";
$cmd = "mongo localhost/{$_POST["db_name"]} --eval ".$query;
$output = shell_exec($cmd);
file_put_contents($file, $output);
deleteRubbish($file);
$output = createExplain();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>DB Visualizer
    </title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="css/font.css" rel="stylesheet" type="text/css">
    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <!-- Bootstrap DatePicker Css -->
    <link href="../../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <!-- Wait Me Css -->
    <link href="plugins/waitme/waitMe.css" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />


<link rel="stylesheet" href="css/vtree.css" type="text/css"/>

<script src="js/d3.js" charset="utf-8"></script>
<script src="js/vtree.js"></script>
        <script src="js/createExplain.js"></script>



  </head>
  <body class="theme-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
      <div class="loader">
        <div class="preloader">
          <div class="spinner-layer pl-red">
            <div class="circle-clipper left">
              <div class="circle">
              </div>
            </div>
            <div class="circle-clipper right">
              <div class="circle">
              </div>
            </div>
          </div>
        </div>
        <p>Please wait...
        </p>
      </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay">
    </div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
      <div class="search-icon">
        <i class="material-icons">search
        </i>
      </div>
      <input type="text" placeholder="START TYPING...">
      <div class="close-search">
        <i class="material-icons">close
        </i>
      </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
          </a>
          <a href="javascript:void(0);" class="bars">
          </a>
          <a class="navbar-brand" href="index.php">DB Visualizer
          </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <!-- #END# Notifications -->
          <!-- Tasks -->
        </div>
      </div>
    </nav>
    <!-- #Top Bar -->
    <section>
      <!-- Left Sidebar -->
      <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        </div>
      <!-- #User Info -->
      <!-- Menu -->
      <div class="menu">
        <ul class="list">
          <li class="header">MAIN NAVIGATION
          </li>
          <li class="active">
            <a href="index.php">
              <i class="material-icons">home
              </i>
              <span>Home
              </span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="material-icons">update
              </i>
              <span>Navigation route #2
              </span>
            </a>
          </li>
          <li class="header">Seperator
          </li>
          <li>
            <a href="javascript:void(0);">
              <i class="material-icons col-red">email
              </i>
              <span>Placeholder for other functionality
              </span>
            </a>
          </li>
        </ul>
      </div>
      <!-- #Menu -->
      <!-- Footer -->
      <div class="legal">
        <div class="copyright">
          <a href="http://github.com/adiwalv">Github Link
          </a>
        </div>
        <div class="version">
          <b>Version: 
          </b> 1.0
        </div>
      </div>
      <!-- #Footer -->
      </aside>
    <!-- #END# Left Sidebar -->
    </section>
  <section class="content">
    <div class="container-fluid">
      <div class="block-header">
        <h2>DASHBOARD
        </h2>
      </div>
      <!-- <div class="body">
<ol class="breadcrumb breadcrumb-bg-pink">
<li><a href="index.php"><i class="material-icons">home</i> Home</a></li>
<li><a href="text.php"><i class="material-icons">input</i> Input</a></li>
<li class="active"><i class="material-icons">list_alt</i> Explain Result</li>
</ol>
</div> -->
      <!-- Widgets -->
      <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-3 bg-pink hover-zoom-effect">
            <div class="icon">
              <i class="material-icons">description
              </i>
            </div>
            <div class="content">
              <div class="text">Documents Checked
              </div>
              <div class="number count-to" data-from="0" data-to="<?php echo getValue($output,"totalDocsExamined");?>" data-speed="1000" data-fresh-interval="20">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-3 bg-cyan hover-zoom-effect">
            <div class="icon">
              <i class="material-icons">alarm
              </i>
            </div>
            <div class="content">
              <div class="text">Query Time(ms)
              </div>
              <div class="number count-to" data-from="0" data-to="<?php echo getValue($output,"executionTimeMillis");?>" data-speed="1000" data-fresh-interval="20">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-3 bg-light-green hover-zoom-effect">
            <div class="icon">
              <i class="material-icons">reply
              </i>
            </div>
            <div class="content">
              <div class="text">Documents Returned
              </div>
              <div class="number count-to" data-from="0" data-to="<?php echo getValue($output,"nReturned");?>" data-speed="1000" data-fresh-interval="20">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-3 bg-orange hover-zoom-effect">
            <div class="icon">
              <i class="material-icons">vpn_key
              </i>
            </div>
            <div class="content">
              <div class="text">Index Keys Examined
              </div>
              <div class="number count-to" data-from="0" data-to="<?php echo getValue($output,"totalKeysExamined");?>" data-speed="1000" data-fresh-interval="20">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- #END# Widgets -->
      <!-- Select -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <div class="row clearfix">
                <div class="col-xs-12 col-sm-6">
                  <h2>Explain
                  </h2>
                  <br>
                  <small>
                    <b>
                      <?php echo $query?>
                    </b>
                  </small>
                </div>
                <div class="col-xs-12 col-sm-6 align-right">
                  <div class="switch panel-switch-btn">
        <button  class="btn btn-primary m-t-15 waves-effect"   data-toggle="modal" data-target="#largeModal1">View Flattened JSON
                    </button>
                    <button class="btn btn-primary m-t-15 waves-effect" data-toggle="modal" data-target="#largeModal">Show Raw JSON
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="body">
              <div class="row clearfix">
       <div id = "container"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- #END# Select -->
        <!-- Large Size -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="largeModalLabel">Raw JSON
                </h3>
              </div>
              <div class="modal-body">
                <?php  showRawJSON();?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                </button>
              </div>
            </div>
          </div>
        </div>



        <div class="modal fade" id="largeModal1" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h3 class="modal-title" id="largeModalLabel">Flattened Json
        </h3>
        </div>
        <div class="modal-body">

<?php
       displayExplain($output);
       ?>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
        </button>
        </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Jquery Core Js -->
  <script src="plugins/jquery/jquery.min.js">
  </script>
  <!-- Bootstrap Core Js -->
  <script src="plugins/bootstrap/js/bootstrap.js">
  </script>
  <!-- Select Plugin Js -->
  <script src="plugins/bootstrap-select/js/bootstrap-select.js">
  </script>
  <!-- Slimscroll Plugin Js -->
  <script src="plugins/jquery-slimscroll/jquery.slimscroll.js">
  </script>
  <!-- Waves Effect Plugin Js -->
  <script src="plugins/node-waves/waves.js">
  </script>
  <!-- Jquery CountTo Plugin Js -->
  <script src="plugins/jquery-countto/jquery.countTo.js">
  </script>
  <!-- Morris Plugin Js -->
  <script src="plugins/raphael/raphael.min.js">
  </script>
  <script src="plugins/morrisjs/morris.js">
  </script>
  <!-- ChartJs -->
  <script src="plugins/chartjs/Chart.bundle.js">
  </script>
  <!-- Flot Charts Plugin Js -->
  <script src="plugins/flot-charts/jquery.flot.js">
  </script>
  <script src="plugins/flot-charts/jquery.flot.resize.js">
  </script>
  <script src="plugins/flot-charts/jquery.flot.pie.js">
  </script>
  <script src="plugins/flot-charts/jquery.flot.categories.js">
  </script>
  <script src="plugins/flot-charts/jquery.flot.time.js">
  </script>
  <!-- Sparkline Chart Plugin Js -->
  <script src="plugins/jquery-sparkline/jquery.sparkline.js">
  </script>
  <!-- Custom Js -->
  <script src="js/admin.js">
  </script>
  <script src="js/pages/index.js">
  </script>
  <!-- Demo Js -->
  <script src="js/demo.js">
  </script>
  </body>
</html>
