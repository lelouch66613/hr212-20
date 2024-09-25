<?php
$uploadDir = "uploads/";  // Specify the directory where files will be uploaded

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["upload"])) {
        // File upload handling
        $uploadedFile = $uploadDir . basename($_FILES['fileToUpload']['name']);

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadedFile)) {
            echo "File uploaded successfully.";
        } else {
            echo "Failed to upload file. Please try again.";
        }
    } elseif (isset($_POST["delete"])) {
        // File deletion handling
        $fileToDelete = $uploadDir . $_POST["fileToDelete"];

        if (file_exists($fileToDelete)) {
            unlink($fileToDelete);
            echo "File deleted successfully.";
        } else {
            echo "File not found. Please check the filename and try again.";
        }
    }
}

// List uploaded files
$fileList = glob($uploadDir . "*");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manipulation Admin</title>
</head>
<body>
    <h2>File Manipulation Admin</h2>

    <!-- File Upload Form -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Upload File:</label>
        <input type="file" name="fileToUpload" required>
        <input type="submit" name="upload" value="Upload">
    </form>

    <!-- File List -->
    <h3>Uploaded Files:</h3>
    <ul>
        <?php foreach ($fileList as $file): ?>
            <li><?php echo basename($file); ?>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="fileToDelete" value="<?php echo basename($file); ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>