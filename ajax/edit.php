<?php
require_once "../classes/Database.php";
require_once "../classes/Candidate.php";
require_once "../classes/CandidateManager.php";

use App\Database\Database;
use App\Models\Candidate;
use App\Services\CandidateManager;

$conn = Database::getConnection();
$manager = new CandidateManager($conn);

$id = $_POST['id'];

$candidate = new Candidate(
    $_POST['name'],
    $_POST['email'],
    $_POST['age'],
    $_POST['gender']
);

$manager->update($id, $candidate);
