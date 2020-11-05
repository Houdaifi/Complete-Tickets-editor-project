<head>

<?php 
    require "header.php";
?>

    <title>Contact Us</title>
    <link rel="stylesheet" href="CSS/mail.css">
   
</head>

    <script>
        $(document).ready(function(){
            $('form').submit(function(e){
                e.preventDefault();
                var from = $("#From").val();
                var name = $("#name").val();
                var Subject = $("#Subject").val();
                var description = $("#description").val();
                var send = $("#send").val();

                $.ajax({
                url : "mail.inc.php",
                data : {
                    from : from,
                    name : name,
                    Subject : Subject,
                    description : description,
                    send : send
                },
                dataType : 'json',
                method : 'POST',
                success: function (response){
                    $("#p-field").html(response);
                }
            });
        });

    });
    </script>

<body>
    
<div class="container contact-form" style="background: #a2d5f2 !important;">
    <div class="card card-5">
        <div class="card-heading">
            <h2>Contact Us</h2>
        </div>
            <form action="mail.inc.php" method="post" enctype='multipart/form-data'>
                
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="From" id="From" class="form-control" placeholder="From" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="Subject" id="Subject" class="form-control" placeholder="Subject" value="" />
                        </div>
                        <p id="p-field" style="color: red; margin-top: 5px"></p>
                        <br>
                        <div class="form-group">
                            <input type="submit" name="send" id="send" class="btnContact" value="Send" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea id="description" name="description" class="form-control" placeholder="Description" style="width: 100%; height: 110px;"></textarea>
                        </div>
                    </div>
                </div>
            </form>
</div>

</body>
</html>