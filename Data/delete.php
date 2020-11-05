<?php

    include "database.php";

    if (isset($_POST['ticketid'])) {

        $ticketid = $_POST['ticketid'];

        $sql = "DELETE FROM tickets WHERE ticketid='$ticketid'";
        $stmt = $conn->query($sql);
        echo 1;
        exit();
    }else {
        echo 0;
        exit();
    }

?>