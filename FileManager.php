<?php

class FileManager
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function uploadFile($user_id, $file)
    {
        $target_dir = "uploads/";
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $randomFileName = uniqid('file_', true) . '.' . $fileExtension;
        $target_file = $target_dir . $randomFileName;
        $uploadOk = 1;

        // Allow below file formats
        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png'
        ];
        if (! in_array($fileExtension, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $stmt = $this->pdo->prepare("INSERT INTO files (user_id, file_name, file_path) VALUES (?, ?, ?)");
                $stmt->execute([
                    $user_id,
                    $randomFileName,
                    $target_file
                ]);
                return true;
            } else {
                return false;
            }
        }
    }

    public function getFilesByUser($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM files WHERE user_id = ?");
        $stmt->execute([
            $user_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
