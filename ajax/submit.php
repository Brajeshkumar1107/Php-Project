<?php
require_once "../classes/Database.php";
require_once "../classes/Candidate.php";
require_once "../classes/CandidateManager.php";
require_once "../classes/Validation.php";

use App\Database\Database;
use App\Models\Candidate;
use App\Services\CandidateManager;

$conn = Database::getConnection();
$manager = new CandidateManager($conn);

// Server-side validation
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$age = $_POST['age'];
$gender = $_POST['gender'];

checkValidation($name, $email, $age, $gender);

$candidate = new Candidate(
    $name,
    $email,
    $age,
    $gender
);

if ($manager->add($candidate)) {
    echo json_encode(['success' => 'User added successfully']);
} else {
    $error = $manager->getLastError() ?: 'Failed to add user';
    echo json_encode(['error' => $error]);
}
