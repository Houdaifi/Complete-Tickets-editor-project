<head>

    <?php
        include "header.php";
    ?>

    <!-- Title Page-->
    <title>Register Form</title>

    <link href="CSS/sign.css" rel="stylesheet">
</head>

    <script>
        $(document).ready(function(){
            $('#Add-btn').parent().remove();
            $('form').submit(function(e){
                e.preventDefault();
                var username = $("#username").val();
                var password = $("#password").val();
                var manager = $("#manager").val();
                var team = $("#team").val();
                var submit = $("#submit").val();

                $.ajax({
                    "url" : "sign-up.inc.php",
                    data : {
                        username: username,
                        password: password,
                        manager: manager,
                        team: team,
                        submit: submit
                    },
                    method: "POST"
                }).done(function(respond){
                    if (respond === "Username field empty") {
                        $('#p-field').html(respond);
                    }else if (respond === "Password field empty") {
                        $('#p-field').html(respond);
                    }
                    else if (respond === "Managerid field empty") {
                        $('#p-field').html(respond);
                    }
                    else if (respond === 'Team not selected') {
                        $('#p-field').html(respond);
                    }else if (respond === "User Name already taken") {
                        $('#p-field').html(respond);
                    }else if (respond === "Added") {
                        $('#p-field').css('color', 'green');
                        $('#p-field').html(respond);
                    }else if (respond === "error") {
                        $('#p-field').html(respond);
                    }
                });

            });
            $("#team").change(function(){
                var val = $(this).val();
                if (val === "user") {
                    $("#manager-field").show();
                }else{
                    $("#manager-field").hide();
                    // $("#manager").val('');
                }
            });
            
        });
    </script>

<body>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Registration Form</h2>
                </div>
                <div class="card-body">
                    <form action="sign-up.inc.php" method="POST">
                        <div class="form-row m-b-55">
                            <div class="name">User Name</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-8">
                                            <input class="input--style-5" type="text" name="username" id="username">
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="form-row">
                            <div class="name">Password</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="password" name="password" id="password">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="name">Team</div>
                            <div class="value">
                                <div class="input-group">
                                <select name="team" id="team">
                                            <option value="" disabled="disabled" selected="selected">Choose Team</option>
                                <?php 
                                    $managers_name = array("support", "manager", "user");
                                    foreach ($managers_name as $statut) {
                                        echo '<option value="'.$statut.'">'.$statut.'</option>';
                                    }
                                ?>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>

                        <div style="display: none;" id="manager-field" class="form-row">
                            <div class="name">Manager</div>
                                <select name="manager" id="manager">
                                <option value="" disabled="disabled" selected="selected">Choose Manager</option>
                                        <?php

                                            include "database.php";

                                            $sql = "SELECT id, user FROM users WHERE team='manager'";
                                            $stmt = $conn->query($sql);
                                                
                                            while ($result = $stmt->fetch()) {
            
                                                echo '<option value='.$result['id'].'>'.$result['user'].'</option>';
                                            }

                                        ?>
                                        
                                        </select>
                            
                        </div>
                        <p id="p-field" style="color: red;"></p><br>
                        <div>
                            <button class="btn btn--radius-2 btn--red" type="submit" name="submit" id="submit">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>>