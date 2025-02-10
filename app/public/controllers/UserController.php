<?php

require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../dto/UserDTO.php");

class UserController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = htmlspecialchars($_POST['firstName']);
            $lastName = htmlspecialchars($_POST['lastName']);
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];
            $email = htmlspecialchars($_POST['email']);
            
            // Default role is 'RegularUser'
            $role = isset($_POST['role']) ? $_POST['role'] : 'RegularUser';

            $success = $this->userModel->createUser($firstName, $lastName, $username, $password, $email, $role);
            
            if ($success) {
                header("Location: /");
                exit;
            } else {
                echo "Error creating user.";
            }
        }
    }

    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];

        // Call the model to authenticate the user
        $user = $this->userModel->authenticateUser($username, $password);

        if ($user) {
            // If authentication is successful, start a session
            $_SESSION['user'] = [
                'id' => $user->getUserId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()->value
            ];
            header("Location: /");
            exit;
        } else {
            // Redirect to login page with an error message in the query string
            $_SESSION['login_error'] = 'Invalid username or password. Please try again.';
            header("Location: /login");
            exit;
        }
    }
}

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }

}