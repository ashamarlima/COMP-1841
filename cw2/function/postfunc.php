<?php
function insertCard($pdo, $name, $description, $imagePath, $category, $userId) {
    // Verify category exists
    $catCheck = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $catCheck->execute([$category]);
    if (!$catCheck->fetch()) {
        throw new Exception('Invalid category selected');
    }

    $query = 'INSERT INTO `tblcard` (Name, Description, Image, Category, user_id) 
              VALUES (:name, :description, :imagePath, :category, :userId)';
    $parameters = [
        ':name' => $name,
        ':description' => $description,
        ':imagePath' => $imagePath,
        ':category' => $category,
        ':userId' => $userId
    ];
    query($pdo, $query, $parameters);
}

function validateImage($image) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $detectedType = finfo_file($fileInfo, $image['tmp_name']);
    finfo_close($fileInfo);

    if (!in_array($detectedType, $allowedTypes)) {
        throw new Exception('Invalid image type. Only JPG, PNG, and GIF are allowed');
    }

    $fileExt = pathinfo($image['name'], PATHINFO_EXTENSION);
    return uniqid('img_', true) . '.' . $fileExt;
}

function moveUploadedImage($image, $targetDir, $filename) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $imagePath = $targetDir . $filename;
    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        throw new Exception('Failed to move uploaded file');
    }
    return $imagePath;
}

function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function getCardById($pdo, $id) {
    $query = 'SELECT tblcard.*, users.username, categories.name AS category_name
              FROM `tblcard` 
              LEFT JOIN users ON tblcard.user_id = users.id
              LEFT JOIN categories ON tblcard.Category = categories.id
              WHERE tblcard.Id = :id';
    $parameters = [':id' => $id];
    $result = query($pdo, $query, $parameters);
    return $result->fetch();
}

function getAllCategories($pdo) {
    $query = 'SELECT * FROM categories ORDER BY name';
    $result = query($pdo, $query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function updateCard($pdo, $id, $name, $description, $category, $imagePath = null)
 {

    $catCheck = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $catCheck->execute([$category]);
    if (!$catCheck->fetch()) {
        throw new Exception('Invalid category selected');
    }

    if ($imagePath) {
        $query = 'UPDATE `tblcard` SET 
                 Name = :name, 
                 Description = :description, 
                 Image = :imagePath, 
                 Category = :category 
                 WHERE Id = :id';
        $parameters = [
            ':name' => $name,
            ':description' => $description,
            ':imagePath' => $imagePath,
            ':category' => $category,
            ':id' => $id
        ];
    } else {
        $query = 'UPDATE `tblcard` SET 
                 Name = :name, 
                 Description = :description, 
                 Category = :category 
                 WHERE Id = :id';
        $parameters = [
            ':name' => $name,
            ':description' => $description,
            ':category' => $category,
            ':id' => $id
        ];
    }
    query($pdo, $query, $parameters);
}

function getAllCards($pdo) {
    $query = 'SELECT tblcard.*, users.username, categories.name AS category_name
              FROM `tblcard` 
              LEFT JOIN users ON tblcard.user_id = users.id
              LEFT JOIN categories ON tblcard.Category = categories.id
              ORDER BY tblcard.Id DESC';
    $result = query($pdo, $query);
    return $result->fetchAll(PDO::FETCH_ASSOC) ?: []; // Return empty array if no results
}
function verifyPostOwnership($pdo, $postId, $userId) {
    $query = 'SELECT user_id FROM `tblcard` WHERE Id = :id';
    $parameters = [':id' => $postId];
    $result = query($pdo, $query, $parameters);
    $post = $result->fetch();
    
    return ($post && $post['user_id'] == $userId);
}

function addCategory($pdo, $id, $name) {
    // Validate category ID format (single uppercase letter)
    if (!preg_match('/^[A-Z]$/', $id)) {
        throw new Exception('Category ID must be a single uppercase letter (A-Z)');
    }

    $query = 'INSERT INTO categories (id, name) VALUES (:id, :name)';
    $parameters = [
        ':id' => $id,
        ':name' => $name
    ];
    query($pdo, $query, $parameters);
}

function updateCategory($pdo, $id, $newName) {
    $query = 'UPDATE categories SET name = :name WHERE id = :id';
    $parameters = [
        ':id' => $id,
        ':name' => $newName
    ];
    query($pdo, $query, $parameters);
}

function deleteCategory($pdo, $id) {
    // First check if category is in use
    $inUse = $pdo->prepare("SELECT COUNT(*) FROM tblcard WHERE Category = ?");
    $inUse->execute([$id]);
    if ($inUse->fetchColumn() > 0) {
        throw new Exception('Cannot delete category - it is being used by posts');
    }

    $query = 'DELETE FROM categories WHERE id = :id';
    $parameters = [':id' => $id];
    query($pdo, $query, $parameters);
}
function rowcount( $pdo, $query){
    $stmt = $pdo -> prepare ($query);
    $stmt -> execute();
    return $stmt -> rowcount();
}

function countUsersByRole($pdo, $role = null) {
    if ($role) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
        $stmt->execute([$role]);
    } else {
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    }
    return $stmt->fetchColumn();
}
function getCount($pdo, $table) {
    $query = "SELECT COUNT(*) FROM `$table`";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}


 

if (!function_exists('query')) {
    function query($pdo, $sql, $parameters = []) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($parameters);
        return $stmt;
    }
}


function getAllUsers($pdo) {
    $query = 'SELECT id, username, email, role FROM users ORDER BY id DESC';
    $result = $pdo->query($query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addUser($pdo, $username, $email, $password, $role) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $email, $hashedPassword, $role]);
}

function updateUser($pdo, $id, $username, $email, $password = null) {
    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = 'UPDATE `users` SET username = :username, email = :email, password = :password WHERE id = :id';
        $parameters = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':id' => $id
        ];
    } else {
        $query = 'UPDATE `users` SET username = :username, email = :email WHERE id = :id';
        $parameters = [
            ':username' => $username,
            ':email' => $email,
            ':id' => $id
        ];
    }
    query($pdo, $query, $parameters);
}

function deleteUser($pdo, $id) {
    $query = 'DELETE FROM `users` WHERE id = :id';
    query($pdo, $query, [':id' => $id]);
}

function validateUserInput($username, $email, $password = null, $confirm_password = null) {
    if (empty($username)) {
        throw new Exception('Username is required');
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Valid email is required');
    }
    
    if ($password !== null) {
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }
     
    }
}
function showMessage() {
    $output = '';
    if (isset($_SESSION['success'])) {
        $output .= '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        $output .= '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
    return $output;
}
function sendMessage($pdo, $role, $user_id, $message) {
    try {
        $stmt = $pdo->prepare("INSERT INTO messages (role, user_id, message) VALUES (:role, :user_id, :message)");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error sending message: " . $e->getMessage());
    }
}

// Function to retrieve messages
function getMessages($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT messages.id, messages.role, messages.user_id, messages.message, users.username
                               FROM messages
                               JOIN users ON messages.user_id = users.Id
                               ORDER BY messages.id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error retrieving messages: " . $e->getMessage());
    }
}
?>
