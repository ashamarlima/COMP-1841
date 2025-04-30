<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>    
<a href="home.php" class="btn btn-primary">Home</a>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Category Management</a>
  
    </div>
</nav>

<div class="container category-management">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

 
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <h4>Add New Category</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="category_manage.php">
                <div class="row g-3 align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="cat_id" class="form-control" placeholder="ID (A-Z)" 
                               maxlength="1" required pattern="[A-Z]" title="Single uppercase letter">
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="cat_name" class="form-control" placeholder="Category Name" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="add_category" class="btn btn-primary w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

 
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Existing Categories</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="15%">ID</th>
                        <th>Name</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= htmlspecialchars($cat['id']) ?></td>
                        <td>
                            <form method="POST" action="category_manage.php" class="d-inline">
                                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($cat['id']) ?>">
                                <div class="input-group">
                                    <input type="text" name="new_name" value="<?= htmlspecialchars($cat['name']) ?>" 
                                           class="form-control" required>
                                    <button type="submit" name="update_category" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </td>
                        <td class="action-buttons">
                            <form method="POST" action="category_manage.php" 
                                  onsubmit="return confirm('Delete this category?');" class="d-inline">
                                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($cat['id']) ?>">
                                <button type="submit" name="delete_category" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>
</html>
