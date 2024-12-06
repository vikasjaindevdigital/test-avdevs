<?php
include 'db.php';
if (isset($_SESSION['avdevs_user_id'])) {
    header('Location: upload.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if user already exists with MySQLi prepared statements
        $avstmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $avstmt->bind_param("s", $email); // 's' for string
        $avstmt->execute();
        $avstmt->store_result();

        if ($avstmt->num_rows > 0) {
            // User exists
            $error = "User with this email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert query with prepared statement
            $avstmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $avstmt->bind_param("ss", $email, $hashedPassword); // 'ss' for two strings
            
            if ($avstmt->execute()) {
                $message =  "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error =  "Error: " . $avstmt->error;
            }
        }
        // Close the statement
        $avstmt->close();
    }
}
?>

<?php
include 'header.php';
?>
<!-- Registration form -->
<?php if(isset($message)){ ?>
   <div class="alert alert-success">
   <strong><?php echo $message; ?>
 </div>
 <?php  } ?>
 <?php if(isset($error)){ ?>
   <div class="alert alert-danger">
   <strong><?php echo $error; ?>
 </div>
 <?php  } ?>
 <h4>Register </h4>

<form method="POST">
    <input class="form-control input-sm chat-input"  type="email" name="email" placeholder="Email" required><br>
    <input class="form-control input-sm chat-input"  type="password" name="password" placeholder="Password" required><br>
    <button class="btn btn-primary btn-md" type="submit">Register</button>
    <a href="<?php echo $baseUrl ?>/login.php" class="btn btn-primary btn-md">Login</a>

</form>
<?php
include 'footer.php';
?>