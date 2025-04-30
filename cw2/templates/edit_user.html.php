<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit User</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" 
                       value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
