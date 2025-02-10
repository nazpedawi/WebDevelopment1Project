<?php
require_once 'BaseModel.php';
require_once 'dto/UserDTO.php';

class UserModel extends BaseModel {

    public function createUser(string $firstName, string $lastName, string $username, string $password, string $email, string $role = 'RegularUser'): bool {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO Users (firstName, lastName, username, password, email, role)
                  VALUES (:firstName, :lastName, :username, :password, :email, :role)";
        
        $stmt = self::$pdo->prepare($query);
    
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
    
        try {
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function authenticateUser(string $username, string $password): ?UserDTO
{
    $query = "SELECT * FROM Users WHERE username = :username";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    
    $row = $stmt->fetch();
    if ($row) {
        
        if (password_verify($password, $row['password'])) {
            
            $role = Role::from($row['role']);
            
            return new UserDTO(
                (int) $row['user_id'],
                (string) $row['firstName'],
                (string) $row['lastName'],
                (string) $row['username'],
                (string) $row['password'],
                (string) $row['email'],
                $role
            );
        }
    }
    return null;
}

}
