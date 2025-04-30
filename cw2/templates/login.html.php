<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../function/style.css">
    <title>Login System</title>

</head> 
<body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        <form action="../login_check.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>