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
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'error' => '',
    ];

    // Validate email and password
    // Add validation logic

    // Check if the user can log in
    if ($user->login($data['email'], $data['password'])) {
        // Get user data by email to obtain the user_id
        $logged_in_user = $user->findUserByEmail($data['email']);

        // Set user_id in session
        $_SESSION['user_id'] = $logged_in_user['id'];

        header('Location: welcome.php');
        exit();
    } else {
        $data['error'] = 'Invalid email or password';
    }
}
?>

<!-- Login form with Email and Password fields -->
<div class="container">
    <h2>Login</h2>
    <?php if (!empty($data['error'])): ?>
        <div class="alert alert-danger"><?php echo $data['error']; ?></div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
