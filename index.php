<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Ajax PHP</title>
</head>
<body>
    <div class="container">
        <br>
        <!-- Button trigger modal -->
        <button type="button" id="open-modal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add new
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="user-form">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username">
                            <span id="alert-username" class="text-danger"></span>

                            <br>
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span id="alert-password" class="text-danger"></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="send-request">Send Request</button>
                        <button type="button" class="btn btn-primary" id="update" style="display: none;">Update</button>
                    </div>
                </div>
            </div>
        </div> <!-- Modal -->

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="list-users">
                
            </tbody>
        </table>
        <!-- <button class="btn btn-info" id="refresh">refresh</button> -->
    </div>
</body>

<script>
    $("documemt").ready(function(){
        $("#open-modal").click(function(){
            // reset button
            $("#update").hide()
            $("#send-request").show()

            // reset form
            $("#user-form")[0].reset()
            $("#username").css('border', '1px solid #ced4da')
            $("#password").css('border', '1px solid #ced4da')
            $("#username").val("")
            $("#password").val("") 
            $("#alert-username").html("") 
            $("#alert-password").html("")
        })

        // first fetch data
        $.ajax({
            url: 'fetch.php',
            method: 'POST',
            success: function(values){
                $("#list-users").html(values)
            }
        })

        // $("#refresh").click(function(){
        //     $.ajax({
        //         url: 'fetch.php',
        //         method: 'POST',
        //         success: function(values){
        //             $("#list-users").html(values)
        //         }
        //     })
        // })

        // Validation form

        $("#send-request").click(function(){
            var username = $("#username").val()
            var password = $("#password").val()

            // Sending ajax request (insert user)

            if(username != '' && password != '' && password.length >= 8){
                $.ajax({
                    url: 'insert.php',
                    method: 'POST',
                    data: {username:username , password:password},
                    success: function(){
                        // swal("Good job!", "You clicked the button!", "success");
                        
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Signed in successfully'
                        })

                        // first fetch data
                        $.ajax({
                            url: 'fetch.php',
                            method: 'POST',
                            success: function(values){
                                $("#list-users").html(values)
                            }
                        })
                    }                    
                })
            }
            
            if(username == ''){
                $("#username").css('border', '1px solid red')
                $("#alert-username").html("this field is required...")
            }else{
                $("#username").css('border', '1px solid #71cdba')
                $("#alert-username").html("")
            }
            
            if(password == ''){
                $("#password").css('border', 'apx solid red')
                $("#alert-password").html("this field is required...")
            }

            if(password != ''){
                if(password.length < 8){
                    $("#alert-password").html("this field more than 8 characters...")
                }else{
                    $("#password").css('border', '1px solid #71cdba')
                    $("#alert-password").html("")
                }
            }

        })

        // Delete user
        $(document).on('click', '#delete-user', function(){            
            var id = $(this).val()
            $.ajax({
                url: 'delete.php',
                method: 'post',
                data: {id:id},
                success: function(){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in successfully'
                    })
                    $.ajax({
                        url: 'fetch.php',
                        method: 'POST',
                        success: function(values){
                            $("#list-users").html(values)
                        }
                    })
                }
            })
        })

        // Update user
        $(document).on('click', '#edit-user', function(){
            var id = $(this).val()
            $.ajax({
                url: 'fetchRow.php',
                method: 'post',
                data: {id:id},
                success: function(values){
                    var data = jQuery.parseJSON(values)                    
                    $("#username").val(data.username)
                    $("#password").val(data.password)
                    // $("#update").css('display', 'block')                    
                    // $("#send-request").css('display', 'none')
                    $("#update").show()
                    $("#send-request").hide()
                }
            })
        })

    })
</script>

</html>