<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>DB Visualizer
    </title>
    <!-- Favicon-->
    <link rel="icon" href="favicons/favicon.ico" type="image/x-icon">
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
              <span>Select DB
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
<ol class="breadcrumb breadcrumb-bg-blue">
<li><a href="index.php"><i class="material-icons">home</i> Home</a></li>
<li><a href="text.php"><i class="material-icons">input</i> Input</a></li>
</ol>
</div> -->
    </div>
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#home_with_icon_title" data-toggle="tab">
                  <i class="material-icons">movie
                  </i> Projection
                </a>
              </li>
              <li role="presentation">
                <a href="#profile_with_icon_title" data-toggle="tab">
                  <i class="material-icons">add
                  </i> Aggregate
                </a>
              </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                <h2>
                  Instructions
                </h2>
                <h5> 
                  <ul>
                    <li>Only provide the query.
                    </li>
                    <li>For example: for db.collectionName.find({query}):
                    </li>
                    <ul>
                      <li>Select collectionName from the list and then input the {query} in the text box, curly braces included 
                    </ul>
                  </ul>
                </h5>
                <br>
                <p>
                <form action="query.php" method="post">
                  <form class="form-horizontal">
                    <div class="row clearfix">
                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="collection_name">Collection:
                        </label>
                      </div>
                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                          <div class="form-line">
                            <select class="form-control show-tick" name ="collection_name" required="true"> 
                              <option value="">-- Select Collection  --
                              </option>
                              <?php
require('./config/config.php');
$db_name = $_POST["db_name"];
$db = $connection->selectDatabase($db_name);
foreach ($db->listCollections() as $collection) {
echo "<option value = \"{$collection->getName()}\">{$collection->getName()}</option>"; 
}?>
                            </select>    
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="find_query">Find:
                        </label>
                      </div>
                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" name="find_query" class="form-control" placeholder="Enter what you'd type in find()" >
                          </div>
                          <div class="help-info">Find Query.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="sort_query">Sort:
                        </label>
                      </div>
                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" name="sort_query" class="form-control" placeholder="Enter what you'd type in sort()">
                          </div>
                          <div class="help-info">Sort Query.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="limit_query">Limit:
                        </label>
                      </div>
                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group form-float">
                          <div class="form-line">
                            <input type="number" class="form-control" name="limit_query">
                            <label class="form-label">Enter what you\'d type in limit()
                            </label>
                          </div>
                          <div class="help-info">Limit query has to be a number only.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                        <input type="hidden" value="<?php echo $db_name ?>" name="db_name" />
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT
                        </button>
                        <br>
                        <br>
                      </div>
                    </div>
                  </form>
                  </p>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                <h2>
                  Instructions
                </h2>
                <h5> 
                  <ul>
                    <li>Only provide the query.
                    </li>
                    <li>For example: for db.collectionName.aggregate({query}):
                    </li>
                    <ul>
                      <li>Select collectionName from the list and then input the {query} in the text box, curly braces and square bracket included 
                    </ul>
                  </ul>
                </h5>
                <br>
                <p>
                <form action="aggregate.php" method="post">
                  <form class="form-horizontal">
                    <div class="row clearfix">
                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="collection_name">Collection:
                        </label>
                      </div>
                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                          <div class="form-line">
                            <select class="form-control show-tick" name ="collection_name" required="true"> 
                              <option value="">-- Select Collection  --
                              </option>
                              <?php
require('./config/config.php');
$db_name = $_POST["db_name"];
$db = $connection->selectDatabase($db_name);
foreach ($db->listCollections() as $collection) {
echo "<option value = \"{$collection->getName()}\">{$collection->getName()}</option>"; 
}?>
                            </select>    
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="find_query">Aggregate:
                        </label>
                      </div>
                      <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" name="aggregate_query" class="form-control" placeholder="Enter what you'd type in aggregate()" >
                          </div>
                          <div class="help-info">Aggregate Query.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                        <input type="hidden" value="<?php echo $db_name ?>" name="db_name" />
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT
                        </button>
                        <br>
                        <br>
                      </div>
                    </div>
                  </form>
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
