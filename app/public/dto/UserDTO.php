<?php

class UserDTO {
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $password;
    private string $email;
    private Role $role;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $username,
        string $password,
        string $email,
        Role $role
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }

    public function getUserId(): int {
        return $this->id;
    }

    public function setUserId(int $id): void {
        $this->id = $id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getRole(): Role {
        return $this->role;
    }

    public function setRole(Role $role): void {
        $this->role = $role;
    }
}

enum Role: string {
    case RegularUser = 'RegularUser';
    case Admin = 'Admin';
}
