<?php

include 'db.php';
if (isset($_SESSION['avdevs_user_id'])) {
    header('Location: upload.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
    // Query to get user details
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['avdevs_user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header('Location: upload.php');
            exit;
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "User not found!";
    }
  }
}
?>
<?php
include 'header.php';
?>
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
<h4>Login</h4>
<form method="POST">
    <input class="form-control input-sm chat-input"  type="email" name="email" placeholder="Email" required><br>
    <input class="form-control input-sm chat-input"  type="password" name="password" placeholder="Password" required><br>
    <button class="btn btn-primary btn-md" type="submit">Login</button>
    <a href="<?php echo $baseUrl ?>/register.php" class="btn btn-primary btn-md">Register</a>
</form>
<?php
include 'footer.php';
?>
