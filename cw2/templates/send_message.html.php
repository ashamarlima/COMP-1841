<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Message</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="<?= $homeLink ?>" class="btn btn-primary">Home</a> 
    <div class="container">
       
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>


        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                <h4>Send a Message to Admin</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="send_message.php">
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="4" placeholder="Write your message..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header bg-info text-white">
                <h4>Messages</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($messages)): ?>
                    <ul class="list-group">
                        <?php foreach ($messages as $msg): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($msg['username']) ?> (<?= htmlspecialchars($msg['role']) ?>):</strong> 
                                <?= htmlspecialchars($msg['message']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No messages available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
