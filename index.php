<?php
session_start();
require('lib/definitions.php');
$error = "";
function makeDir($path)
{
return is_dir($path) || mkdir($path);
}
makeDir('uploads');
if(!empty($_FILES['uploaded_file']))
{
$path = "uploads/";
$path = $path . basename( $_FILES['uploaded_file']['name']);
if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path) && checkExtension($path)) {
$new_name = "uploads/temp.json" ;
rename( $path, $new_name) ;
deleteRubbish($new_name);
$output = createExplain();
$_SESSION["output"] = $output;
$_SESSION["file"] = $_FILES['uploaded_file']['name'];
//print_r( $_SESSION["output"]);
header('Location: file.php');
} else{
$error = "There was an error uploading the file, please try again and make sure you only upload a json file!";
}
}
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
    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="logo">
        <a href="index.php">DB
          <b>Visualizer
          </b>
        </a>
        <small>Mongo DB explain() explained
        </small>
      </div>
      <div class="card">
        <div class="body">
          <form action="text.php" method="POST">
            <div class="msg">Select the database you want to connect to
            </div>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">book
                </i>
              </span>
              <div class="form-line">
                <select class="form-control show-tick" name = "db_name" required="true">
                  <option value="">-- Select Database  --
                  </option>                                                                      
                  <?php
require('./config/config.php');
foreach($connection->listDatabases() as $database)
{
echo "<option value = \"{$database->getName()}\">{$database->getName()}</option>";
}
?>
                </select>
              </div>
            </div>
            <button class="btn btn-block btn-lg bg-green waves-effect" type="submit">CONNECT
            </button>
          </form>
          <form  enctype="multipart/form-data" action="index.php" method="POST">
            <center>
              <h3>Or
              </h3>
            </center>
            <div class="msg">
              <span title="Click ?  to see how to create explain files using mongo"> Select file for explain()                                                                                                                                    
                <button type="button" class="btn bg-blue btn-circle waves-effect waves-circle waves-float waves-light" data-toggle="modal" data-target="#largeModal" >                                  
                  <i class="material-icons">live_help
                  </i>
                </button>
              </span>
            </div>
            <input type="file" name="uploaded_file" required>
            </input>
          <br />
          <button class="btn btn-block btn-lg bg-red waves-effect" type="submit">SEE RESULTS
          </button>
          <br>
          <font color="red">
            <?php echo $error;?>
          </font>
          </form>
      </div>
    </div>
    <!-- Large Size -->
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="largeModalLabel">How to create a explain() file
            </h3>
          </div>
          <div class="modal-body">
            <h4>                             Type the command below in the terminal:
            </h4>
            <h5>                                              mongo localhost/dbName --eval "db.collectionName.find({query}).sort({query}).limit(limit_no).explain('allPlansExecution')" > fileName.json
            </h5>
                                                                                                   Fill the correct values depending on your database, and then select this newly generated file via the filepicker!
<br><br>
    <h4>Alternatively if this does not work</h4>
    Create a fileName.js file with your query For eg. db.collectionName.find({query}).sort({query}).limit(limit_no).explain('allPlansExecution')  inside the function printjson(). Like this: <h6>printjson(db.collectionName.find({query}).sort({query}).limit(limit_no).explain('allPlansExecution'))</h6>
                                                                                                                                                                                                                                                       Save this file. And then in the terminal type: <h6>mongo dbname fileName.js > fileName.json </h6> 
                                                                                                                                                                                                                                                                                                                           And then select this .json file via the file picker.
<br><br>
    <center><h4>You can also checkout some sample plans in the samplePlans folder in the root directory of this project!</h4>
    <h4>Thank You!</center></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
            </button>
          </div>
        </div>
      </div>
    </div>
    <script src="plugins/jquery/jquery.min.js">
    </script>
    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js">
    </script>
    <script src="plugins/bootstrap-select/js/bootstrap-select.js">
    </script>
    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js">
    </script>
    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js">
    </script>
    <!-- Custom Js -->
    <script src="js/admin.js">
    </script>
    <script src="js/pages/examples/sign-up.js">
    </script>
  </body>
</html>
