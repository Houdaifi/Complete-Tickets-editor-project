<?php 
    
    if (isset($_POST['submit'])) {

        include "database.php";

        $username = $_POST['username'];
        $password = $_POST['password'];
        $manager = $_POST['manager'];
        $team = $_POST['team'];

        if (empty($username)) {
            echo "Username field empty";
            exit();
        }elseif (empty($password)) {
            echo "Password field empty";
            exit();
        }
        elseif ($team == "user" && empty($manager)) {
            echo "Managerid field empty";
            exit();
        }
        elseif (empty($team)) {
            echo "Team not selected";
            exit();
        }else {
            $sql = "SELECT * FROM users WHERE user =:username";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindValue('username', $username);

            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count > 0) {
                echo "User Name already taken";
                exit();
            }else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (user, pass, team, managerID) VALUES (:username, :pass, :team, :manager)";
                $stmt = $conn->prepare($sql);
                
                $stmt->bindValue('username', $username);
                $stmt->bindValue('pass', $hashedPassword);
                $stmt->bindValue('team', $team);
                $stmt->bindValue('manager', $manager);

                if ($team !== "user") {
                    $manager = 0;
                }

                $result = $stmt->execute();
                if ($result) {
                    echo "Added";
                    exit();
                }else {
                    echo "error";
                    exit();
                }
            }
        }
    }
