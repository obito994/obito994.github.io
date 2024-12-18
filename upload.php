<?php
if ($_FILES['file']['name']) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "File has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>