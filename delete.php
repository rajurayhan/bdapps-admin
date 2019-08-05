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
    $sql = "DELETE FROM contents WHERE id =".$_GET['id'];
    // echo $sql;
    if($result = $pdo->query($sql)){
    //   echo 'Deleted!';
        header('Location: index.php');
    }
    header('Location: index.php');
?>