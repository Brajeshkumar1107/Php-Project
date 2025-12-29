<?php

namespace App\Services;

use App\Models\Candidate;

class CandidateManager {
    private $conn;
    private $lastError;

    // Dependency Injection
    public function __construct($dbConnection) {
        $this -> conn = $dbConnection;
        $this->lastError = null;
    }

    public function getLastError() {
        return $this->lastError;
    }

    private function setLastError($error) {
        $this->lastError = $error;
    }

    private function emailExists($email, $excludeId = null) {
        $query = "SELECT id FROM users WHERE email = ? limit 100000";
        $params = [$email];
        $types = "s";
        if ($excludeId !== null) {
            $query .= " AND id != ?";
            $params[] = $excludeId;
            $types .= "i";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function  add(Candidate $candidate) {
        if ($this->emailExists($candidate->email)) {
            $this->setLastError('Email already exists');
            return false;
        }

        $stmt = $this -> conn -> prepare (
            "INSERT INTO users (name, email, age, gender) VALUES (?, ?, ?, ?)"
        );

        $stmt -> bind_param (
            "ssis",
            $candidate -> name,
            $candidate -> email,
            $candidate -> age,
            $candidate -> gender,
        );

        // print_r($candidate);

        $result = $stmt -> execute();
        if (!$result) {
            $this->setLastError('Failed to add user');
        }
        return $result;
    }


    public function delete($id) {
        $stmt = $this -> conn -> prepare(
            "DELETE FROM users WHERE id = ?"
        );
        $stmt -> bind_param("i", $id);
        return $stmt -> execute();
    }

    public function update($id, Candidate $candidate) {
        if ($this->emailExists($candidate->email, $id)) {
            $this->setLastError('Email already exists');
            return false;
        }

        $stmt = $this -> conn -> prepare(
            "UPDATE users SET name = ?, email = ?, age = ?, gender = ? WHERE id = ?"
        );

        $stmt -> bind_param(
            "ssisi",
            $candidate -> name,
            $candidate -> email,
            $candidate -> age,
            $candidate -> gender,
            $id
        );

        $result = $stmt -> execute();
        if (!$result) {
            $this->setLastError('Failed to update user');
        }
        return $result;
    }

    public function getAll() {
        $result = $this -> conn -> query(
            "SELECT * FROM users ORDER BY id DESC"
        );

        return $result -> fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this -> conn -> prepare("SELECT * FROM users WHERE id = ?");
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        return $stmt -> get_result() -> fetch_assoc();
    }
}



?>