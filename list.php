<?php
require_once "classes/Database.php";
require_once "classes/CandidateManager.php";

use App\Database\Database;
use App\Services\CandidateManager;

$conn = Database::getConnection();
$manager = new CandidateManager($conn);
$users = $manager->getAll();
?>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
        <td><?php echo htmlspecialchars($user['age']); ?></td>
        <td><?php echo htmlspecialchars($user['gender']); ?></td>
        <td>
            <button onclick="editUser(<?php echo $user['id']; ?>)">Edit</button>
            <button onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
