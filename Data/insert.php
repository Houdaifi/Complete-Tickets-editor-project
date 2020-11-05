<head>
    
    <title>Create ticket</title>
    <?php
        include "header.php";
    ?>

    <link rel="stylesheet" href="CSS/insert.css">
    
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
                var formdata = new FormData(this);
                $.ajax({
                    url : "insert.inc.php",
                    data : formdata,
                    dataType : 'json',
                    contentType : false,
                    cache : false,
                    processData : false,
                    type : 'POST',
                    success: function (data) {
                        if (data == "Created") {
                            $('#p-field').html(data).css('color','green');
                        }else if (data == "Please fill all fields" ) {
                            $('#p-field').html(data);
                        }else{
                            $('#p-field').html(data);
                        }
                    }
                })
            });
            function readURL(input) {  
                $('#preview').show();
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                    $('#preview')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }      
        });
    </script>
    
    <body>  

<div class="container contact-form" style="background: #a2d5f2 !important;">
    <div class="card card-5">
        <div class="card-heading">
            <h2>Create Ticket</h2>
        </div>
            <form action="insert.inc.php" method="post" enctype='multipart/form-data'>
                
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title*" value="" />
                        </div>
                        <div class="form-group">
                            <select id="category" name="category" class="form-control">
                                <option class="hidden" selected disabled>Ticket category</option>
                                <?php
                                    
                                    include "database.php";

                                    $sql = "SELECT * FROM categories";
                                    $stmt = $conn->query($sql);
                                    while ($row = $stmt->fetch()) {
                                        echo "<option value='{$row['category_id']}' >{$row['category_name']}</option>";
                                    }

                                ?>
                            </select>
                        </div>
                        <!-- Upload image input-->
                        <br>
                        <div class="file-upload-wrapper">
                            <input type="file" name="image" id="image" onchange="loadFile(event)" value="" />
                            <br>
                            <br>
                            <img style= "max-width: 160px; max-height: 120px; border: none; visibility: hidden;" src="#" alt="preview" id="preview"/>
                        </div> 
                        
                        <p id="p-field" style="color: red; margin-top: 5px"></p>
                        <div class="form-group">
                            <input type="submit" name="btnSubmit" id="btnSubmit" class="btnContact" value="Create" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea id="description" name="description" class="form-control" placeholder="Description*" style="width: 100%; height: 110px;"></textarea>
                        </div>
                    </div>
                </div>
            </form>
</div>

</body>
</html>