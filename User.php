<?php

class User
{

    private $conn;

    private $table_name = "users";

    public $id;

    public $name;

    public $role_id;

    public $mobile;

    public $email;

    public $address;

    public $gender;

    public $date_of_birth;

    public $profile_picture;

    public $signature;

    public $username;

    public $password;

    public $approved;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function fetchAllUsers()
    {
        $query = "SELECT users.*, roles.role_name FROM " . $this->table_name . " INNER JOIN roles ON users.role_id = roles.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function createUser()
    {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, role_id=:role_id, mobile=:mobile, email=:email, address=:address, gender=:gender, date_of_birth=:date_of_birth, profile_picture=:profile_picture, signature=:signature, username=:username, password=:password, approved=:approved";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':role_id', $this->role_id);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        $stmt->bindParam(':profile_picture', $this->profile_picture);
        $stmt->bindParam(':signature', $this->signature);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':approved', $this->approved);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteUser()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function fetchProfile($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function updateProfile()
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name, mobile=:mobile, email=:email, address=:address, gender=:gender, date_of_birth=:date_of_birth, profile_picture=:profile_picture, signature=:signature WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        $stmt->bindParam(':profile_picture', $this->profile_picture);
        $stmt->bindParam(':signature', $this->signature);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateApprove()
    {
        $query = "UPDATE " . $this->table_name . " SET approved=:approved WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':approved', $this->approved);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function uploadFile($file, $target_dir)
    {
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }

    // employee
    public function fetchEmployees($search, $offset, $limit)
    {
        $sql = "SELECT * FROM employees WHERE
                    employee_name LIKE :search OR
                    designation LIKE :search OR
                    date_of_birth LIKE :search OR
                    date_of_joining LIKE :search OR
                    blood_group LIKE :search OR
                    mobile LIKE :search OR
                    email LIKE :search OR
                    address LIKE :search
                LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countEmployees($search)
    {
        $sql = "SELECT COUNT(id) FROM employees WHERE
                    employee_name LIKE :search OR
                    designation LIKE :search OR
                    date_of_birth LIKE :search OR
                    date_of_joining LIKE :search OR
                    blood_group LIKE :search OR
                    mobile LIKE :search OR
                    email LIKE :search OR
                    address LIKE :search";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>
