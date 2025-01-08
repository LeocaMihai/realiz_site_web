<?php

class ProfilePicture {
  
    public function save($requestFile) {
        if (isset($requestFile) && $requestFile['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = basename($requestFile['name']);
            $targetFilePath = $uploadDir . uniqid() . "_" . $fileName;
    
            if (move_uploaded_file($requestFile['tmp_name'], $targetFilePath)) {
                return $targetFilePath;
            }
        }
    }

    public function deleteIfExists($picturePath) {
        if (file_exists($picturePath)) {
            if (unlink($picturePath)) {
                echo "File deleted successfully.";
            } else {
                echo "File could not be deleted.";
            }
        }
    }

}
?>
