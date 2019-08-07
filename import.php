<?php
  // Init session
  session_start();

  // Include db config
  require_once 'db.php';

  // Validate login
  if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header('location: login.php');
    exit;
  }
$conn = mysqli_connect("localhost", "root", "", "bdaps");

// if (isset($_POST["import"])) {

//     $allowed =  array('csv');
//     $fileName = $_FILES["file"]["name"];
//     $ext = pathinfo($fileName, PATHINFO_EXTENSION);
//     $fileName = $_FILES["file"]["tmp_name"];
//     // echo $ext;
//     if(!in_array($ext,$allowed) ) {
        
//         // exit();
//         // header('Location: import.php');
//         $type = "danger";
//         $message = "Problem in Importing CSV Data";
//     }
    
//     // $fileName = $_FILES["file"]["tmp_name"];
    
//     else{
//         if ($_FILES["file"]["size"] > 0) {
        
//             $file = fopen($fileName, "r");

//             $loop = 0;
            
//             while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
//                 $sqlInsert = "INSERT into contents (applicationId, keyword, content_type, content, content_status, content_lang, date_added)
//                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "')";
//                 $result = mysqli_query($conn, $sqlInsert);
//                 $loop++;
                
//                 if (! empty($result)) {
//                     $type = "success";
//                     $message = "$loop contents Imported into the Database";
//                 } else {
//                     $type = "danger";
//                     $message = "Problem in Importing CSV Data";
//                 }
//             }
//         }
//     }
// }

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");

        $total = 0;

        $status = 1;
        $date   = date('Y-m-d h:i:s');
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into contents (applicationId, keyword, content_type, content, content_status, content_lang, date_added)
                    values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $status . "','" . $column[4] . "','" . $date . "')";
            $result = mysqli_query($conn, $sqlInsert);

            $total++;
            //echo $column[4];    
            
            if (! empty($result)) {
                $type = "success";
                $message = $total." Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>BD Apps Pro || Admin Panel</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- DataTables -->    

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <a href="index.php"><h3>BDApps PRO</h3></a>
            </div>

            <ul class="list-unstyled components">
                <p>Hello <?php echo $_SESSION['name'] ?></p>
                <li>
                    <a href="import.php">Import</a>
                </li>
                <li>
                    <a href="#">Add</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <!-- <span>Toggle Sidebar</span> -->
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                              <a href="logout.php" class="btn btn-danger">Logout</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <h2>Import From CSV</h2>
            <div id="response" class="alert alert-<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
            <hr>

            <form class="form-horizontal" action="" method="post" name="uploadCSV" enctype="multipart/form-data">
                <div class="input-row">
                    <!-- <label class="col-md-4 control-label">Choose CSV File</label>  -->
                    <input type="file" name="file" id="file" accept=".csv">
                    <button type="submit" id="submit" name="import" class="btn-info btn-submit">Import</button>
                    <br />

                </div>
                <div id="labelError"></div>
            </form>
            
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    
    

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $("#frmCSVImport").on(
            "submit",
            function() {

                $("#response").attr("class", "");
                $("#response").html("");
                var fileType = ".csv";
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
                        + fileType + ")$");
                if (!regex.test($("#file").val().toLowerCase())) {
                    $("#response").addClass("error");
                    $("#response").addClass("display-block");
                    $("#response").html(
                            "Invalid File. Upload : <b>" + fileType
                                    + "</b> Files.");
                    return false;
                }
                return true;
            });
        });
    </script>
</body>

</html>