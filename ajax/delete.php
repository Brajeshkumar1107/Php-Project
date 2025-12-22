<?php
require_once "../classes/Database.php";
require_once "../classes/CandidateManager.php";

use App\Database\Database;
use App\Services\CandidateManager;

$conn = Database::getConnection();
$manager = new CandidateManager($conn);

$id = $_GET['id'];
$manager->delete($id);
