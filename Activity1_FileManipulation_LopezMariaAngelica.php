<?php

if (isset($_POST['create_file'])) {
    create_file($_POST['c_filename']);
} elseif (isset($_POST['rename_file'])) {
    rename_file($_POST['old_filename'], $_POST['new_filename']);
} elseif (isset($_POST['delete_file'])) {
    delete_file($_POST['d_filename']);
} 

function create_file($filename) {
    if (file_exists($filename)) {
        echo "Error: File already exists.";
    } else {
        try {
            $file = fopen($filename, "w");
            fclose($file);
            echo "File created successfully.";

            // Create backup
            backup_file($filename);
        } catch (Exception $e) {
            echo "Error creating file: " . $e->getMessage();
        }
    }
}

function rename_file($old_filename, $new_filename) {
    if (!file_exists($old_filename)) {
        echo "Error: File does not exist.";
    } elseif (file_exists($new_filename)) {
        echo "Error: New filename already exists.";
    } else {
        try {
            rename($old_filename, $new_filename);
            echo "File renamed successfully.";

            // Delete old backup
            delete_backup($old_filename);

            // Create new backup
            backup_file($new_filename);
        } catch (Exception $e) {
            echo "Error renaming file: " . $e->getMessage();
        }
    }
}

function delete_file($filename) {
    if (!file_exists($filename)) {
        echo "Error: File does not exist.";
    } else {
        try {
            unlink($filename);
            echo "File deleted successfully.";

            // Delete backup
            delete_backup($filename);
        } catch (Exception $e) {
            echo "Error deleting file: " . $e->getMessage();
        }
    }
}

function backup_file($filename) {
    $backup_filename = $filename . ".bak";
    copy($filename, $backup_filename);
}

function delete_backup($filename) {
    $backup_filename = $filename . ".bak";
    if (file_exists($backup_filename)) {
        unlink($backup_filename);
    }
}


?>

<form action="" method="post">

    <div class="contain">
        <div class="butons">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
           <center> <input type="text" name="c_filename" placeholder="filename.txt">
            <input type="submit" name="create_file" value="Create"><br><br>
            <input type="text" name="d_filename" placeholder="Enter filename to delete">
            <input type="submit" name="delete_file" value="Delete"><br><br>
            <input type="text" name="old_filename" placeholder="Enter filename to rename">
            <input type="text" name="new_filename" placeholder="Enter new file name">
            <input type="submit" name="rename_file" value="Rename">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h2> Submitted by: Lopez Maria Angelica </h2>
          </center>
        </div>
    </div>


</form>
