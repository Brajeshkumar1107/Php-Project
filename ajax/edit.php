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

$id = $_POST['id'];

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

if ($manager->update($id, $candidate)) {
    echo json_encode(['success' => 'User updated successfully']);
} else {
    $error = $manager->getLastError() ?: 'Failed to update user';
    echo json_encode(['error' => $error]);
}
