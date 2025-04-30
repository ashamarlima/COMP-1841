<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="d-flex justify-content-start align-items-start">
    <a href="<?= $homeLink ?>" class="btn btn-primary">Home</a>
</div>
<div class="container mt-4">
    <h2 class="text-center">Posts</h2>

 
    <form action="insert.php" method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select name="category" id="category" class="form-select" required>
                <option value="" disabled selected>Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>
        <button type="submit" name="upload" class="btn btn-primary">Upload</button>
    </form>

    <h2 class="text-center">Uploaded </h2>

    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">User</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Category</th>
                <th scope="col">Image</th>
                <th scope="col">Delete</th>
                <th scope="col">Update</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($cards) > 0): ?>
                <?php foreach ($cards as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id']) ?></td>
                        <td><?= isset($row['username']) ? htmlspecialchars($row['username']) : 'Unknown' ?></td>
                        <td><?= htmlspecialchars($row['Name']) ?></td>
                        <td><?= htmlspecialchars($row['Description']) ?></td>
                        <td>
                            <a href="?category=<?= htmlspecialchars($row['Category']) ?>" class="category-link">
                                <?= htmlspecialchars($row['category_name'] ?? $row['Category']) ?>
                            </a>
                        </td>
                        <td><img src="<?= htmlspecialchars($row['Image']) ?>" width='200px' height='70px' alt="Item image"></td>
                        <td>
                            <a href="delete.php?Id=<?= htmlspecialchars($row['Id']) ?>"
                               class="btn btn-danger"
                               onaclick="return confirm('Are you sure you want to delete this item?')">
                                Delete
                            </a>
                        </td>
                        <td>
                            <a href="update.php?Id=<?= htmlspecialchars($row['Id']) ?>" class="btn btn-warning">
                                Update
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
