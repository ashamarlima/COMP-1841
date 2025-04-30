<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System Dashboard</title>
    <link rel ="stylesheet" href="../function/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <h4 class="text-center text-white">School System</h4>
                <ul class="nav flex-column">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="send_message.php">Emails</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="templates/login.html.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome to the School System</h1>
            </div>
            
            <div class="all">
                <h1>All users <br>
                <span><?php echo $allUsersCount; ?></span></h1>
            </div>
            
            <div>
                <div class="stu">
                    <h1>All students <br>
                    <span><?php echo $studentsCount; ?></span></h1>
                </div>

                <div class="teach">
                    <h1>All teachers <br>
                    <span><?php echo $teachersCount; ?></span></h1>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>