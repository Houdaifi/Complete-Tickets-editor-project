<?php 
    session_start();
    include "database.php";

    if (isset($_POST['comment'])) {
        
        $data = array(
            ':comment' => $_POST['comment'],
            ':userid' => $_SESSION['user_id'],
            ':ticketid' => $_POST['ticketid']
        );

        if (empty($_POST['comment']) || intval($_POST['ticketid']) <= 0 ) {
            $empty = array(
            'error' => "Please add your comment"
            );
            echo json_encode($empty);
            exit();
        }else {
            $sql = "INSERT INTO comments (userid, comment, ticket_id) VALUES (:userid, :comment, :ticketid)";
        $stmt = $conn->prepare($sql);
        
        $result = $stmt->execute($data);
        
        if ($result) {
           
            $output = array(
                'comment' => $_POST['comment'],
                'user' => $_SESSION['user'],
                'date' => date('Y-m-d h:i:s')
            );
            
            echo json_encode($output);
        }else{
            echo "Error";
            exit();
        }
    }
}