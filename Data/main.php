<!DOCTYPE html>

<head>
    
    <title>Home</title>

    <?php
        include "header.php";
    ?>
    
    <link rel="stylesheet" href="CSS/main.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

</head>
<body>

<script>
$(document).ready(function(){
    
    $('[data-toggle="tooltip"]').tooltip();
    

	$(document).on('click', '.edit', function(){
        var $element  = $(this);
        var ticketid = $element.attr('data-id');

        $.ajax({
            url : "edit.php",
            method : "POST",
            data : {
                ticketid : ticketid
            }
        });

    });
    $('#dtBasicExample').dataTable( {
        "columnDefs": [
        { "orderable": true, "targets": 2 }
            ]
    } );
    
	$(document).on("click", ".delete", function(){
        var $el = $(this);
        var ticketid = $el.attr("data-id");

        var confirmalert = confirm("Are you sure?");
        if (confirmalert == true) {
        
        $.ajax({
            url : "delete.php",
            method : "POST",
            data : {
                ticketid : ticketid,
            },
            success: function(response){
                
                if (response == 1) {

                    $el.parents("tr").remove();
                }else{
                    alert('Invalid');
                }
            }
        });
        }
    });
});

</script>
            <div class="container">

                <div class="row">
                    <div ><h1>Welcome <span style="color:#17a2b8"><b><?php echo $user ?></b></span></h1></div>
                </div>
                <br>
                <div class="row d-flex justify-content-between mb-3">
                    <h2>Tickets</h2>
                </div>
                <div class="row">
                    <table id="dtBasicExample"  class="table table-bordered table-striped table-md table-fluid">
                        <thead class="thead">
                            <tr>

                                <th>Title</th>
                                <th style="width: 20%;">Description</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>By</th>
                                <th>Created at</th>
                                <th>Uploaded at</th>
                                <?php
                                    if ($_SESSION['team'] == "support") {
                                        echo "<th>Actions</th>";
                                    }else {
                                        echo "<th style='width: 12%'>Actions</th>";
                                    }
                                ?>
        
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //conx db 
                                require "database.php";

                                //query select ... 
                                if ($_SESSION['team'] == 'admin') {
                                    $sql = "SELECT t.*,u.user as author_name,c.category_name FROM tickets t
                                    INNER JOIN users u ON u.id= t.author_id
                                    INNER JOIN categories c ON c.category_id=t.Category
                                    ORDER BY Created DESC";

                                } elseif ($_SESSION['team'] == "support"){
                                    $sql = "SELECT t.*,u.user as author_name,c.category_name FROM tickets t
                                    INNER JOIN users u ON u.id= t.author_id
                                    INNER JOIN categories c ON c.category_id=t.Category
                                    ORDER BY CASE Statut
                                    WHEN 'Open' THEN 1
                                    WHEN 'Processing' THEN 2
                                    WHEN 'Close' THEN 3
                                    END" ;
                                    
                                } elseif ($_SESSION['team'] == "manager"){
                                    $sql = "SELECT t.*,u.user as author_name,u.managerID as manager,c.category_name FROM tickets t
                                    INNER JOIN users u ON u.id= t.author_id
                                    INNER JOIN categories c ON c.category_id=t.Category
                                    WHERE id = '$userid'
                                    OR managerID= '$userid'
                                    ORDER BY Created DESC";
                                    
                                }
                                else {
                                    $sql = "SELECT t.*,u.user as author_name,u.managerID as manager,c.category_name FROM tickets t
                                    INNER JOIN users u ON u.id= t.author_id
                                    INNER JOIN categories c ON c.category_id=t.Category
                                    WHERE user = '$user'
                                    ORDER BY Created DESC";
                                }

                                    $stmt = $conn->query($sql);

                                    while ( $row = $stmt->fetch() ){

                                        echo "<tr>";
                                        // echo "<td>{$row['ticketid']}</td>";
                                        echo "<td>{$row['title']}</td>";
                                        echo "<td>{$row['descr']}</td>";
                                        echo "<td class='{$row['Statut']}' >{$row['Statut']}</td>";
                                        echo "<td>{$row['category_name']}</td>";
                                        echo "<td>{$row['author_name']}</td>";
                                        echo "<td>{$row['Created']}</td>";
                                        echo "<td>{$row['Updated']}</td>";

                                        if ( $_SESSION['team'] == "support"){
                                            echo '<td>
                                                <a class="see" title="See" style="color:inherit; text-align:center; margin:auto" href="see.php?ticketid='.$row['ticketid'].'" data-toggle="tooltip" data-id="'.$row['ticketid'].'"><i class="fas fa-eye"></i></a>
                                                </td>';
                                        }else {
                                            echo '<td>
                                                <a class="see" title="See" style="color:inherit" href="see.php?ticketid='.$row['ticketid'].'" data-toggle="tooltip" data-id="'.$row['ticketid'].'"><i class="fas fa-eye"></i></a>
                                                <a style="color:&#xE254" href="edit.php?ticketid='.$row['ticketid'].'" class="edit" title="Edit" data-toggle="tooltip" ><i class="material-icons">&#xE254;</i></a>
                                                <a class="delete" title="Delete" data-toggle="tooltip" data-id="'.$row['ticketid'].'"><i class="material-icons">&#xE872;</i></a>
                                                </td>';
                                        }
                                        echo "</tr>";
                                }
                            ?>           
                        </tbody>
                    </table>
                    
                </div>
        </div>

</body>

</html>