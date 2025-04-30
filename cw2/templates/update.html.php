<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Card</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <center>
        <div class="main">
            <form action="update1.php" method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" value="<?= htmlspecialchars($output['card']['Name']); ?>" name="name" id="name" class="form-control"><br>
                
                <label for="description">Description:</label>
                <input type="text" value="<?= htmlspecialchars($output['card']['Description']); ?>" name="description" id="description" class="form-control"><br>
                
                <label for="category">Category:</label>
                <select name="category" id="category" class="form-select">
                    <option value="" disabled>Select Category</option>
                    <?php foreach ($output['categories'] as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>" 
                            <?= ($cat['id'] == $output['card']['Category']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
                
                <label for="image">Image:</label>
                <div>
                    <input type="file" name="image" id="image" class="form-control">
                 
                    <?php if (!empty($output['card']['Image'])): ?>
                        <img src="<?= htmlspecialchars($output['card']['Image']); ?>" width='200px' height='70px' alt="Current image" class="mt-2">
                    <?php endif; ?>
                </div><br>
                
                <input type="hidden" name="Id" value="<?= htmlspecialchars($output['card']['Id']); ?>"> 
                <button type="submit" name="update" class='btn btn-primary m-2'>Update</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </center>
</body>
</html>
