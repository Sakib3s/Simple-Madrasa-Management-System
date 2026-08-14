<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statement = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $statement->execute([(int) ($_POST['id'] ?? 0)]);
    set_flash('success', 'Student deleted successfully.');
}
redirect('students.php');
