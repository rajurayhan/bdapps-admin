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

  // Get all contents 
  $sql = "SELECT * FROM contents";
  if($result = $pdo->query($sql)){
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $num_rows = count($rows);
    // echo $num_rows;
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    

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

            <h2>Contents</h2>       
            <hr>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Content Type</th>
                  <th>Content</th>
                  <th>Length</th>
                  <th>Status</th>
                  <th>Language</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($num_rows>0){
                    foreach($rows as $key=>$row){
                      if($row->content_status){
                        $status = 'Not Sent';
                      }
                      else{
                        $status = 'Sent';
                      }
                      echo '<tr>';
                        echo '<td>'.($key+1).'</td>';
                        echo '<td>'.$row->content_type.'</td>';
                        echo '<td>'.$row->content.'</td>';
                        echo '<td>'.strlen($row->content).'</td>';
                        echo '<td>'.$status.'</td>';
                        echo '<td>'.$row->content_lang.'</td>';
                        echo '<td><a href="edit.php?id='.$row->id.'"><button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button></a></td>';
                        echo '<td><button onclick="deleteItem('. $row->id .')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button></td>';
                        // echo '<td><a href="delete.php?id='.$row->id.'"><button onclick="deleteItem('. $row->id .')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button></a></td>';
                      echo '</tr>';
                    }
                    
                  }
                ?>
              </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" ></script>
    

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $('.table').DataTable();
        });
        function deleteItem(id){
          if (confirm("Are you sure?")) {
              window.location.href = "delete.php?id="+id;
          }
        }
    </script>
</body>

</html>