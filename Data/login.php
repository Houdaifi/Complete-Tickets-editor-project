<?php 

if (isset($_POST['submit'])) {

    include "database.php";

    $username = $_POST['username'];
    $password = $_POST['password'] ;
    $remember = $_POST['remember'];

     if (empty($username) || empty($password)) {
        echo "Please fill all fields";
        exit();
    }else {
        $username = $conn->quote($username);
        $sql = "SELECT * FROM users WHERE user=$username";
        $stmt =$conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row < 0) {
            echo "Invalid Username!";
        }
        else {
          
            if ((isset($remember)) && $remember == 'true'){
                setcookie('name', $row['user'], time()+3600);
                setcookie('password', $password, time()+3600);
            }else {
                setcookie ("name",""); 
                setcookie ("password","");
            }

        $validpassword = password_verify($password, $row['pass']);
            if ($validpassword == true) {
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user'] = $row['user'];
                $_SESSION['team'] = $row['team'];
                $_SESSION['manager'] = $row['managerID'];
                echo "OK";
                exit();
            }   
            else {
                echo "Invalid username or password";
                exit();
            }
        }
    }
}