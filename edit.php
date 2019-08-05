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
    $sql = "SELECT * FROM contents WHERE id =".$_GET['id']." LIMIT 1";
    // echo $sql;
    if($result = $pdo->query($sql)){
      $row = $result->fetch(PDO::FETCH_OBJ);
    }

    if (isset($_POST["update"])) {
        $data = [
            'content_type'      => $_POST['content_type'],
            'content_lang'      => $_POST['content_lang'],
            'content_status'    => $_POST['content_status'],
            'content'           => $_POST['content'],
            'id'                => $_GET['id']
        ];
        $sql = "UPDATE contents SET content_type=:content_type, content_lang=:content_lang, content_status=:content_status, content=:content WHERE id=:id";
        $stmt= $pdo->prepare($sql);
        if($stmt->execute($data)){
            // echo 'Updated!';
            header('Location: index.php');
        }
        else{
            echo 'Something went wrong!';
        }

        // var_dump($data);

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

            <h2>Edit Content</h2>       
            <hr>
            <div>
                <form class="form-horizontal" action="" method="post" name="editContent" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="content_type">Content Type</label>
                        <select name="content_type" id="content_type" class="form-control" style="width: 30%">
                            <option value="Love Jokes">Love Jokes</option>
                            <option value="Love Tips">Love Tips</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="content_status">Content Status</label>
                        <select name="content_status" id="content_status" class="form-control" style="width: 30%">
                            <option value="0">Sent</option>
                            <option value="1">Not Sent</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="content_lang">Content Language</label>
                        <select name="content_lang" id="content_lang" class="form-control" style="width: 30%">
                            <option value="bangla">Bangla</option>
                            <option value="english">English</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="" cols="10" rows="10" class="form-control"><?php echo $row->content; ?></textarea>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    <button type="submit" id="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
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
            

            $('#content_type').val("<?php echo $row->content_type ?>");
            $('#content_lang').val("<?php echo $row->content_lang ?>");
            $('#content_status').val("<?php echo $row->content_status ?>");
        });
    </script>
</body>

</html>