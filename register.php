<?php
session_start();
require_once 'includes/header.php';
require_once 'classes/User.php';

// Instantiate User class
$user = new User();

// Handle form submission and validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form

    // Sanitize POST data
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    // Validate and store POST data
    $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'image' => $_FILES['image']['name'],
        'tmp_image' => $_FILES['image']['tmp_name'],
        'error' => '',
    ];

    // Validate name, email, and passwords
    // Add validation logic

    // Check if email already exists
    if ($user->findUserByEmail($data['email'])) {
        $data['error'] = 'Email is already taken';
    }

    // If no errors, register the user and upload the image
    if (empty($data['error'])) {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Upload image
        move_uploaded_file($data['tmp_image'], "uploads/images/{$data['image']}");

        // Register user
        if ($user->register($data)) {
            // Get user data by email to obtain the user_id
            $registered_user = $user->findUserByEmail($data['email']);

            // Set user_id in session
            $_SESSION['user_id'] = $registered_user['id'];

            header('Location: welcome.php');
            exit();
        } else {
            $data['error'] = 'Something went wrong. Please try again.';
        }
    }
}
?>

<!-- Registration form with Name, Email, Password, Confirm Password, and Image fields -->
<div class="container">
    <h2>Register</h2>
    <?php if (!empty($data['error'])): ?>
        <div class="alert alert-danger"><?php echo $data['error']; ?></div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <label for="image">Profile Image:</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
   
        </form>

        <!-- Add this line after the Register button -->
    <p>Already have an account? <a href="login.php">Login</a></p>


</div>

<?php require_once 'includes/footer.php'; ?>
