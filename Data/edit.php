<head>     
        <!-- Title Page-->
        <title>Edit ticket</title>

        <?php 
            include "header.php";
        ?>

    <link rel="stylesheet" href="CSS/insert.css">
    <!------ Include the above in your HEAD tag ---------->
    
    </head>
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
            var output = document.getElementById('preview');
            output.style.visibility = "visible";
            output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
    <script>
        $(document).ready(function(){
            
            $('form').submit(function(e){
                e.preventDefault();
                var fd = new FormData(this);

                $.ajax({
                    url : "edit.inc.php",
                    data : fd,
                    dataType : 'json',
                    contentType : false,
                    cache : false,
                    processData : false,
                    type : 'POST',
                    success:function(response){
                        if (response == "Modified") {
                            $('#p-field').html(response).css('color','green');
                        }else{
                            $('#p-field').html(response);
                        }
                    }
                })
            });
        });
    </script>

    <body>  

        <?php
            
            include "database.php";

            $ticketid = $_GET['ticketid'];
            $ticketid=$conn->quote($ticketid);
            $sql = "SELECT * FROM tickets WHERE ticketid=$ticketid";
            $stmt=$conn->query($sql);
            $row = $stmt->fetch();
            $disable = "";
                if ($_SESSION['team'] == "support") {
                    $disable = "disabled='disabled'";
                }
            if (!$row) {
                header("Location: main.php");
                exit();
            }
      
        ?>

<div class="container contact-form" style="background: #a2d5f2 !important;">
    <div class="card card-5">
        <div class="card-heading">
            <h2>Edit Ticket</h2>
        </div>
    
            <form action="edit.inc.php" method="post" enctype='multipart/form-data' runat="server">
            
            
               
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="title" id="title" <?= $disable ?> class="form-control" placeholder="Title*" value="<?php echo $row['title']; ?>" />
                        </div>
                            
                        <div class="form-group">
                            <select  <?= $disable ?> id="category" name="category" class="form-control">
                                <?php

                                        $sql = "SELECT * FROM categories";
                                        $stmt = $conn->query($sql);
                                        while ($roww = $stmt->fetch()) {
                                            $selected = "";
                                            if ($roww['category_id'] == $row['Category']) {
                                                $selected = "selected='selected'";
                                            }
                                            
                                        echo "<option $selected value='{$roww['category_id']}'>{$roww['category_name']}</option>";
                                    }

                                ?>
                            </select>
                        </div>
                        <input id="ticketid" name="ticketid" value="<?php echo $row['ticketid']; ?>" type="hidden">
                        <div class="form-group">
                            <select id="category-statut" name="statut" class="form-control">
                               
                                <?php
                                    // open proc close 
                                    $category_statut = array('Open', 'Processing', 'Close');
                                    foreach($category_statut as $cs){
                                        $selected = "";
                                        if ($cs == $row['Statut']) {
                                            $selected = "selected='selected'";
                                        }
                                        echo "<option $selected>$cs</option>";
                                    }
                                ?>

                            </select>
                        </div>
                        <div class="file-upload-wrapper">
                            <input type="file" name="image" id="image" accept="image/*" onchange="loadFile(event)" />
                            <br>
                            <br>
                            <img style= "max-width: 160px; max-height: 120px; border: none; visibility: hidden" src="#" alt="preview" id="preview"/>
                        </div>
                       
                        <p id="p-field" style="color: red; margin-top: 20px"></p>
                        <div class="form-group">
                            <input type="submit" name="btnEdit" id="btnEdit" class="btnContact" value="Submit" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea id="description" name="description" <?= $disable ?> class="form-control" placeholder="Description*" style="width: 100%; height: 150px;" ><?php echo $row['descr']; ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
</div>
</div>
</body>
</html>