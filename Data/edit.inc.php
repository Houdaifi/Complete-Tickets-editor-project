<?php 

include "database.php";
    
if (isset($_POST['title'])) {
    
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $statut = $_POST['statut'];
    $ticketid = $_POST['ticketid'];

    $file = $_FILES['image'];

    $fileName = basename($_FILES['image']['name']);
    $fileTmpName = $_FILES['image']['tmp_name'];

    $fileNewName = uniqid('', true)."-".$fileName;

    $path = "uploads/".$fileNewName;

    move_uploaded_file($fileTmpName, $path);

    $sql = "UPDATE tickets SET title=:title, descr=:descr, category=:category, Statut=:statut, Updated=NOW(), images=:img WHERE ticketid=:ticketid";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue('title', $title);
    $stmt->bindValue('descr', $desc);
    $stmt->bindValue('category', $category);
    $stmt->bindValue('statut', $statut);
    $stmt->bindValue('ticketid', $ticketid);
    $stmt->bindValue('img', $fileNewName);

    $result= $stmt->execute();
    if ($result) {
        $data = "Modified";
    }else {
        $data = "Error";
    }
    echo json_encode($data);

}elseif (isset($_POST['edit'])) {
    
    $statut = $_POST['statut'];
    $ticket = $_POST['ticket'];

    $sql = "UPDATE tickets SET Statut=:statut WHERE ticketid=:ticket";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue('statut', $statut);
    $stmt->bindValue('ticket', $ticket);

    $stmt->execute();
}