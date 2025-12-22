<?php
class AdminDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAdminByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($adminData) {
            return new Admin($adminData['id'], $adminData['username'], $adminData['password']);
        } else {
            return null;
        }
    }

    public function doesAdminExist($username) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function createAdmin($username, $password) {
        if ($this->doesAdminExist($username)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
        $stmt = $this->pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    public function changePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); 
        $stmt = $this->pdo->prepare("UPDATE admins SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>