<?php
require_once "../classes/Database.php";
require_once "../classes/CandidateManager.php";

use App\Database\Database;
use App\Services\CandidateManager;

$conn = Database::getConnection();
$manager = new CandidateManager($conn);

$user = $manager->getById($_GET['id']);
echo json_encode($user);
?>