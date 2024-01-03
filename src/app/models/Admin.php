<?php
require_once 'Database.php';


class Admin
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function authenticate($username, $password)
    {
        $query = "SELECT * FROM admin_table WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);

        if (!($stmt->execute())) {
            return "Error executing query.";
        }

        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $admin['password'])) {
                return ['success' => true, 'data' => $admin];
            } else {
                return "Invalid password.";
            }
        } else {
            return "Username not found.";
        }
    }

    public function removeSession()
    {
        // Unset all session variables
        $_SESSION = array();
        // Finally, destroy the session.
        session_destroy();
    }

    public function createAccount($username, $name, $hashedPassword)
    {
        if ($this->isUsernameExist($username)) {
            return "Username already exists";
        }

        $query = "INSERT INTO admin_table (name, username, password) VALUES (:name, :username, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return "Register Success";
        } else {
            return "Register Failed";
        }
    }


    private function isUsernameExist($username) {
        $query = "SELECT * FROM admin_table WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}