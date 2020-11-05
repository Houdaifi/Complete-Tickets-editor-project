<head>
    
    <title>Ticket</title>

    <?php 
        include "header.php";
    ?>

    <!-- CSS link -->
    <link rel="stylesheet" href="CSS/see.css">

</head>

    <script>
        $(document).ready(function() {
            
            $('img').on('click', function() {
            $("#last_div").css("visibility", "hidden");
            $('#overlay')
            .css({backgroundImage: `url(${this.src})`})
            .addClass('open')
            .one('click', function() {
                 $(this).removeClass('open');
                 $("#last_div").css("visibility", "visible"); 
                 });
            });

            $('#comment-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url : "comment.php",
                    data : $(this).serialize(),
                    method : "POST",
                    dataType: "json",
                    beforeSend: function(){
                        $("#submit").attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        $("#submit").attr('disabled', false);
                        if (data.comment) {
                            var row = '<span class="text-muted">' + '<strong style="color:#07689f"> ' + data.user + '</strong>' + '</span>'
                            + '<small class="text-muted" style="margin-left:5px";>' + data.date + '</small>'
                            + '<p>' + data.comment + '</p>' + '<hr>';
                            $("#section1").prepend(row);
                            $("#comment").val("");
                            $("#submit")[0].reset();
                        }else if (data.error) {
                            $("#submit").attr('disabled', false);
                            $('#p-field').html(data.error);
                        }
                    }  

                });
            });
            $("#statut").change(function(){
                $("#edit-form").show();
            });
            $("#edit-form").submit(function(event){
                event.preventDefault();
                var statut = $("#statut").val();
                var edit = $("#edit").val();
                var ticket = $("#ticket").val();
                $.ajax({
                    url : "edit.inc.php",
                    method : "POST",
                    data : {
                        statut : statut,
                        edit : edit,
                        ticket : ticket
                    }
                });
            });
        });
    </script>

<body>

    <?php 
        
        include "database.php";
        
        $ticketid = $_GET['ticketid'];
        $ticketid = $conn->quote($ticketid);
        $sql = "SELECT * FROM tickets WHERE ticketid=$ticketid";
        $stmt=$conn->query($sql);
        $row = $stmt->fetch();
        if (!$row) {
            header("Location:main.php");
            exit();
        }
    ?>
    
<div class="container contact">
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-9">
			<div class="contact-form">
				<div class="form-group">
				  <label class="control-label col-sm-2">Title:</label>
				  <div class="col-sm-10">          
					<input type="text" class="form-control" disabled="disabled" value="<?php echo $row['title']; ?>">
                  </div>
                  <br>
                  <div class="form-group">
				  <label class="control-label col-sm-2" >Description:</label>
				  <div class="col-sm-10">
					<textarea class="form-control" rows="5" disabled="disabled"><?php echo $row['descr']; ?></textarea>
                  </div>
                </div>
                <?php 
                $description = $row['descr'];
                $valid = preg_match_all('/(?>(?>([a-f0-9]{1,4})(?>:(?1)){7}|(?!(?:.*[a-f0-9](?>:|$)){8,})((?1)(?>:(?1)){0,6})?::(?2)?)|(?>(?>(?1)(?>:(?1)){5}:|(?!(?:.*[a-f0-9]:){6,})(?3)?::(?>((?1)(?>:(?1)){0,4}):)?)?(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?4)){3}))/iD', $description, $resulta);
                    if ($valid) {

                    $ch = curl_init();

                        // set URL and other appropriate options
                        $r = array_shift($resulta);
                        
                        $v = curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/$r[0]");
                        
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);

                        // grab URL and pass it to the browser
                        $var = curl_exec($ch);
                        $var1 = json_decode($var);
                        
                    echo '<div class="form-group">
                    <label class="control-label col-sm-4" >IP Country:</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" rows="2" disabled="disabled">';
                      if (!empty($var1->country)) {
                          $resulta = $var1->country;
                        echo $resulta; 
                      }else {
                          echo "No country found for this IP";
                      }
                       
                       echo '</textarea>
                    </div>
                  </div>';
                  
                  // close cURL resource, and free up system resources
                  curl_close($ch);

                }?>
               
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" >Category:</label>
				  <div class="col-sm-10">
                      <?php
                        $sql = "SELECT * FROM categories";
                        $stmt = $conn->query($sql);
                        while ($roww = $stmt->fetch()) {
                            if ($roww['category_id'] == $row['Category']) {
                                echo '<input type="text" class="form-control" disabled="disabled" value="'.$roww['category_name'].'">';
                            }
                        }
                      ?>
				  </div>
                </div>
                <div class="form-group">
				  <label class="control-label col-sm-2" >By:</label>
				  <div class="col-sm-10">          
                  <?php
                        $sql = "SELECT id, user FROM users";
                        $stmt = $conn->query($sql);
                        while ($raw = $stmt->fetch()) {
                            if ($raw['id'] == $row['author_id']) {
                                echo '<input type="text" class="form-control" disabled="disabled" value="'.$raw['user'].'">';
                            }
                        }
                    ?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2">Statut:</label>
				  <div class="col-sm-10">
                  <input id="ticket" value="<?php echo $_GET['ticketid']; ?>" type="hidden">
                        <?php
                            
                            if ($_SESSION['team'] == "support") {
                                echo '<div class="form-group">';
                                echo '<select id="statut" name="statut" class="form-control">';
                                            
                                $category_statut = array('Open', 'Processing', 'Close');
                                foreach($category_statut as $cs){
                                    $selected = "";
                                    if ($cs == $row['Statut']) {
                                        $selected = "selected='selected'";
                                    }
                                    echo "<option $selected>$cs</option>";
                                }
                                    
                                echo '</select>';   
                                echo '<form style="padding-top:20px; display:none" id="edit-form">';
                                echo '<input type="submit" id="edit" class="btn btn-warning pull-right img" value="Edit" />';        
                                echo '</form>';
                                
                            echo '</div>';
                            }else {
                                echo '<input type="email" class="form-control" name="email" disabled="disabled" value="'.$row["Statut"].'">';
                            }
                            echo '<div id="overlay"></div>';
                            if (is_null($row['images'])) {
                                echo '';
                            }else {
                                echo '<img style="margin:20px 0;" id="image" src="uploads/'.$row['images'].'" alt="ticket image">';
                            }
                            
                        ?>
                    <br>
                    <label class="control-label" style="color: grey;">Created at: <?php echo $row['Created']; ?></label>
                    <br>
                    <label class="control-label" style="color: grey;">Uploaded at: <?php echo $row['Updated']; ?></label>
                </div>
                </div>
                <hr>
                <div id="container" class="container">
    
                <?php

                        $sql = "SELECT c.*, u.id, u.user FROM comments c
                        INNER JOIN users u ON u.id=c.userid
                        WHERE ticket_id = $ticketid
                        ORDER BY submit_date DESC";
                        $stmt=$conn->query($sql);

                ?>

                <div class="row bootstrap snippets bootdeys">
                    <div class="col-md-8 col-sm-12">
                        <div class="comment-wrapper">
                         <div id="section1">
                                    <?php 
                                        include "ago.php";
                                        while ($Row = $stmt->fetch() ){ 

                                            echo '<span class="text-muted">';
                                            echo '<strong style="color:#07689f">';
                                            echo $Row['user'];
                                            echo "</strong>";
                                            echo "</span>";
                                            
                                            echo '<small class="text-muted" style="margin-left:5px";>';
                                            echo  time_elapsed_string($Row['submit_date']);
                                            echo "</small>";
                                            echo "<p>";
                                            echo $Row['comment'];
                                            echo "</p> <hr>";
                                        
                                    }
                                        ?>                                    
                                </div>
                                <div id="last_div">
                                <div style="margin-bottom: 10px;" class="panel-heading">
                                    Comment panel:
                                </div>
                                <div class="panel-body">
                                    <form action="comment.php" method="POST" id="comment-form">
                                    <input id="ticketid" name="ticketid" type="hidden" value="<?php echo $_GET['ticketid']; ?>">
                                    <textarea name="comment" style="margin-bottom: 10px;" id="comment" class="form-control" placeholder="write a comment..." rows="3"></textarea>
                                    
                                    <p style="color: red;" id="p-field"></p>
                                    <input style="background-color: #07689f; color:white" name="submit" type="submit" id="submit" class="btn" value="Post" />
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>

				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>