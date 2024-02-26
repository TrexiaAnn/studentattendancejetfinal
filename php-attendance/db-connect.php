<?php
class DbConnection{

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'student_attendance';
    
    protected $connection;
    
    public function __construct(){

        if (!isset($this->connection)) {
            
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }  
            // Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    exit();
}

// Retrieve user details
$user_id = $_SESSION['user_id'];
$userDetails = $user->details("SELECT * FROM users WHERE id = $user_id");

// Handle form submission for updating user information
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    
    // Update user information in the database
    $update_sql = "UPDATE users SET fname = '$fname', email = '$email' WHERE id = '$user_id'";
    if ($user->getConnection()->query($update_sql)) {
        // Refresh user data after update
        $userDetails = $user->details("SELECT * FROM users WHERE id = $user_id");
        $_SESSION['success_message'] = "User information updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating user information: " . $user->getConnection()->error;
    }
}          
        }    
        
        return $this->connection;
    
    
    }
}
?>