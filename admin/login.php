<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['username'])) {
    header('Location:items.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tanzy's Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="../static/css/loader.css">
    <link rel="stylesheet" href="../static/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>

<body>

    <div class="col-lg-4 offset-lg-4 mt-5">

        <div class="card p-3" style="margin-top: 150px;">
            <center>
                <h4>
                    <a href="../index.html" class="brand">Tanzy Admin</a>
                </h4>
            </center>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-user"></i>
                    </span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>
                <input type="password" class="form-control" id="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
            </div>
            <div class="input-group">
                <input type="button" class="submitBtn form-control btn-primary" id="loginBtn" value="Submit">
            </div>

        </div>
    </div>
</body>

<div class="blur-loader" style="display: none;">
    <div class="loader"></div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->


<script>
    $(document).ready(function() {
        $('#username').focus();
    });

    $('#username').on('input', function() {
        var value = $(this).val();
        var lowercaseValue = value.toLowerCase();
        $(this).val(lowercaseValue);
    });

    // Bind 'paste' event to the #username field
    $('#username').on('paste', function(e) {
        e.preventDefault(); // Prevent pasting
        var text = (e.originalEvent || e).clipboardData.getData('text/plain');
        text = text.toLowerCase();
        document.execCommand('insertText', false, text);
    });


    $('#loginBtn').click(function() {
        username = $('#username').val();
        password = $('#password').val();

        if (username.length <= 0) {
            toastr.error("Please Enter Username");
        } else if (password.length <= 0) {
            toastr.error("Please Enter Password");
        } else {
            $.ajax({
                type: 'POST',
                url: '../backend/requestHandler.php',
                data: {
                    action: 'login',
                    username: username,
                    password: btoa(password),
                },
                success: function(result) {
                    result = $.parseJSON(result);
                    if (result['status'] == true) {
                        window.location = 'items.php';
                    } else {
                        toastr.error(result['message']);
                    }
                },
                error: function(error) {
                    toastr.error("Cannot Login, Please try again.")
                }

            });
        }
    });





    // loader function 

    function showLoader() {
        $('.blur-loader').css('display', 'block');
    }

    function hideLoader() {
        $('.blur-loader').css('display', 'none');
    }

    // ajaxFunction


    $(document).ready(function() {
        $(document).ajaxStart(function() {
            // Function to execute when an AJAX request starts
            showLoader();
        });

        $(document).ajaxStop(function() {
            // Function to execute when all AJAX requests have completed
            hideLoader();
        });
    });
</script>

</html>