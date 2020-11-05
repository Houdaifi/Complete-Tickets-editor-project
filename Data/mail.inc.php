<?php

    use PHPMailer\PHPMailer\PHPMailer;
   
if (isset($_POST['send'])) {
    $From = $_POST['from'];
    $name = $_POST['name'];
    $subject = $_POST['Subject'];
    $desc = $_POST['description'];

    require_once "PHPMailer/src/PHPMailer.php";
    require_once "PHPMailer/src/SMTP.php";
    require_once "PHPMailer/src/Exception.php";

    $mail = new PHPMailer();
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host="smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "houdaifaamzil@gmail.com";
    $mail->Password = "";
    $mail->Port = "465";
    $mail->SMTPSecure = "ssl";

    // Email Settings
    $mail->isHTML(true);
    $mail->setFrom($From, $name);
    $mail->addAddress("houdaifaamzil@gmail.com");
    $mail->Subject = $subject;
    $mail->Body= $desc;

    if ($mail->send()) {
        $response =  "Email is sent";
        exit();
    }else {
        $response = "Something went wrong<br><br>".$mail->ErrorInfo;
        exit();
    }
    var_dump($response);
    exit();
   echo json_encode($response);
    
}

