<?php
    include "database.php";
    session_start();
    
    session_destroy();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="CSS/index.css">

    <script>
    $(document).ready(function(){
      $('form').submit(function(event){
        event.preventDefault();
        var username = $("#username").val();
        var password = $("#password").val();
        var remember = $("#remember").is(':checked');
        var submit = $("#submit").val();

        $.ajax({
          "url" : "login.php",
          data : {
            username : username,
            password : password,
            remember : remember,
            submit : submit
          },
          method : "POST"
        }).done(function(respond){
          if (respond === "OK") {
            window.location.href = ("main.php");
          }else if (respond === "Invalid Username!") {
            $('#p-field').html(respond);
          }
          else{
            $('#p-field').html(respond);
          }
        });
      });
    });
    </script>

</head>
<body>
    
<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Welcome!</h3>
              <form action="login.php" method="POST">
                <div class="form-label-group">
                  <input type="text" id="username" class="form-control" placeholder="Username" required autofocus name="username" <?php if (isset($_COOKIE['name'])) {

                    echo 'value='.$_COOKIE['name'].'';
                    
                  } ?>>
                  <label for="inputEmail">Username</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="password" class="form-control" placeholder="Password" required name="password" <?php if (isset($_COOKIE['password'])) {

                    echo 'value='.$_COOKIE['password'].'';

                    } ?>>
                  <label for="inputPassword">Password</label>
                </div>
                
                <p id="p-field" style="color: red; text-align: center"></p>
                
                    <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["name"]) && $_COOKIE["name"] != "") { ?> checked <?php } ?>/>
                    <label for="remember">Remember me</label>
                
                
                <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" name="submit" id="submit">Sign in</button>
                <div class="text-center">
                  <a class="small" href="#">Forgot password?</a></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>