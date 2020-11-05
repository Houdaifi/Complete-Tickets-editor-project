<?php 
session_start();
include "database.php";

if (isset($_POST['title'])) {

    $title = $_POST['title'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    
    $file = $_FILES['image'];
    $fileName = basename($_FILES['image']['name']);
    $filetmpName = $_FILES['image']['tmp_name'];

    if (!empty($fileName)) {
        $fileNewName = uniqid('', true)."-".$fileName;
    }else {
        $fileNewName = NULL;
    }
    
    $path = "uploads/".$fileNewName;
    
    if (empty($title) || empty($desc) || empty($category)) {
        $data = "Please fill all fields";
        echo json_encode($data);
        exit();
    }else{

        move_uploaded_file($filetmpName, $path);

        $sql = "INSERT INTO tickets (title, descr, Category, Statut, author_id, images) VALUES (:title, :descr, :category, :statut, :author_id, :images)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue('title', $title);
        $stmt->bindValue('descr', $desc);
        $stmt->bindValue('category', $category);
        $stmt->bindValue('statut', 'Open');
        $stmt->bindValue('author_id', $_SESSION['user_id']);
        $stmt->bindValue('images', $fileNewName);

        $result = $stmt->execute();
        if ($result) {
            $data = "Created";
        }else{
            $data = "Error";
        }
        echo json_encode($data);
    }
}