<?php
    session_start();
    $userid = $_SESSION['user_id'];
    $user = $_SESSION['user'];
    $manager = $_SESSION['manager'];

    if (!isset($_SESSION['user'])) {
      header("Location:index.php");
      exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/header.css">

</head>

<body>
  
<nav style="background-color: #e3f2fd !important;" class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="main.php">Ticket</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="main.php">Home<span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
      <?php 
          if ($_SESSION['team'] == "support") {
              echo "";
          }else {
              echo '<a class="nav-link" href="insert.php">Add Ticket</a>';
          }
      ?>
      </li>
     
      <li class="nav-item">
        <a class="nav-link" href="mail.php">Contact Us</a>
      </li>
    </ul>

  </div>

  <div class="d-flex justify-content-end row">
      <a class ="btn" href="sign-up.php">
          <?php
              if ($_SESSION['team'] == "admin") {
                  echo '<button style="background-color: #07689f;" type="button" class="btn btn-secondary" id="Add-btn">Add Users</button>';
              }
          ?>
      </a>
      <a class ="btn" href="logout.php">
          <button style="background-color: #ffc93c;" type="button" class="btn">Log Out</button>
      </a>
  </div>
                
</nav>
<br>

</body>
</html>