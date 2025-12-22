<?php

namespace App\Services;

use App\Models\Candidate;

class CandidateManager {
    private $conn;

    // DI
    public function __construct($dbConnection) {
        $this -> conn = $dbConnection;
    }

    public function add(Candidate $candidate) {
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

        return $stmt -> execute();
    }


    public function delete($id) {
        $stmt = $this -> conn -> prepare(
            "DELETE FROM users WHERE id = ?"
        );
        $stmt -> bind_param("i", $id);
        return $stmt -> execute();
    }

    public function update($id, Candidate $candidate) {
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

        return $stmt -> execute();
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