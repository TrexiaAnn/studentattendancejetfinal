<?php
session_start();
require_once('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user data
$user_id = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Handle form submission for updating user information
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    // Update user information in the database
    $update_sql = "UPDATE users SET fname = '$fname', email = '$email' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        // Refresh user data after update
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['success_message'] = "User information updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating user information: " . mysqli_error($conn);
    }
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <!-- Add your CSS stylesheets and other meta tags here -->
</head>
<body>
    <div class="container">
        <h1 class="page-header text-center">My Account</h1>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="fname">Full Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['fname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Update Information</button>
                </form>
                <hr>
                <a href="?logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
