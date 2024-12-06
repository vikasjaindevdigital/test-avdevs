<?php
include 'db.php';
if (!isset($_SESSION['avdevs_user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $user_id = $_SESSION['avdevs_user_id'];
    $file = $_FILES['file'];

    // Validate file (check for valid file types)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $error = "Invalid file type!";
    }else{
         // Define the upload directory
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . basename($file['name']);

            // Move file to the upload directory
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Insert file details into the database
                $query = "INSERT INTO uploads (user_id, file_name, file_path) VALUES ('$user_id', '{$file['name']}', '$filePath')";
                if ($conn->query($query)) {
                    $message = "File uploaded successfully!";
                } else {
                    $error = "Error saving file info to database: " . $conn->error;
                }
            } else {
                $error = "Error uploading file!";
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
 <h4>Upload File *Png,jpeg,Gif </h4>
<!-- File upload form -->
<form method="POST" enctype="multipart/form-data">
    <input class="form-control input-sm chat-input"  type="file" name="file" required><br>
    <button class="btn btn-primary btn-md"  type="submit">Upload</button>
    <a href="<?php echo $baseUrl ?>/logout.php" class="btn btn-primary btn-md" type="submit">Logout</a>
</form>

<?php
include 'footer.php';
?>