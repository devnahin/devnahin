<?php
session_start();
require_once 'includes/header.php';
require_once 'classes/User.php';

// Instantiate User class
$user = new User();

// Get user data
$user_data = $user->getUserById($_SESSION['user_id']);
?>

<!-- Welcome page with navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Welcome, <?php echo $user_data['name']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <img src="uploads/images/<?php echo $user_data['image']; ?>" alt="Profile Image" class="rounded-circle" width="40" height="40">
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!-- User's information -->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="uploads/images/<?php echo $user_data['image']; ?>" alt="Profile Image" class="img-thumbnail" width="200" height="200">
        </div>
        <div class="col-md-8">
            <ul class="list-unstyled">
                <li>
                    <i class="fas fa-user"></i> Name: <?php echo $user_data['name']; ?>
                </li>
                <li>
                    <i class="fas fa-envelope"></i> Email: <?php echo $user_data['email']; ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
