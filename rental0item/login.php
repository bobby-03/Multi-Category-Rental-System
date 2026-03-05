<?php 
session_start();
if(isset($_SESSION['login_id'])) header("location:index.php"); // Redirect if already logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | RentIt</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="display: flex; align-items: center; justify-content: center; height: 100vh; background: #f4f7f6;">

    <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Rent<span style="color: #007bff;">It</span> Login</h2>
        <form id="login-form">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Username</label>
                <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <button type="submit" style="width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Login</button>
        </form>
        <div style="text-align: center; margin-top: 15px;">
            <a href="index.php" style="color: #666; text-decoration: none; font-size: 14px;">Back to Home</a>
        </div>
    </div>

    <script>
        $('#login-form').submit(function(e){
            e.preventDefault();
            // Show a loading state
            $(this).find('button').attr('disabled', true).text('Logging in...');
            
            $.ajax({
                url: 'ajax.php?action=login',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err);
                    alert("An error occurred.");
                    $('#login-form').find('button').removeAttr('disabled').text('Login');
                },
                success: function(resp){
                    if(resp == 1){
                        location.href = 'index.php'; // Redirect on success
                    } else {
                        alert("Incorrect username or password.");
                        $('#login-form').find('button').removeAttr('disabled').text('Login');
                    }
                }
            });
        });
    </script>
</body>
</html>