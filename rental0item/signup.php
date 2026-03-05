<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | RentIt</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="display: flex; align-items: center; justify-content: center; height: 100vh; background: #f4f7f6;">

    <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Create Account</h2>
        <form id="signup-form">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Username</label>
                <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <button type="submit" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Register</button>
        </form>
        <div style="text-align: center; margin-top: 15px;">
            <p style="font-size: 14px;">Already have an account? <a href="login.php" style="color: #007bff; text-decoration: none;">Login here</a></p>
        </div>
    </div>

    <script>
        $('#signup-form').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'ajax.php?action=signup',
                method: 'POST',
                data: $(this).serialize(),
                success: function(resp){
                    if(resp == 1){
                        alert("Account created! Redirecting...");
                        location.href = 'index.php';
                    } else if(resp == 2) {
                        alert("Username already exists.");
                    } else {
                        alert("An error occurred.");
                    }
                }
            });
        });
    </script>
</body>
</html>