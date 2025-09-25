<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByUsernameOrEmail($identifier)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->execute([$identifier, $identifier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $hashedPassword)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword]);
    }
    
    public function updatePassword($email, $hashedPassword)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password=? WHERE email=?");
        return $stmt->execute([$hashedPassword, $email]);
    }

    public function findById($id)
{
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function updateProfile($id, $username, $email, $phone, $location)
{
    $stmt = $this->pdo->prepare(
        "UPDATE users SET username = ?, email = ?, phone = ?, location = ? WHERE id = ?"
    );
    return $stmt->execute([$username, $email, $phone, $location, $id]);
}
}