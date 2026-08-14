<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$title = 'Add Student';
$classes = $pdo->query('SELECT id, class_name FROM classes ORDER BY class_name')->fetchAll();
$errors = [];
$student = ['student_id' => '', 'name' => '', 'father_name' => '', 'phone' => '', 'address' => '', 'class_id' => '', 'admission_date' => date('Y-m-d'), 'status' => 'Active'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($student as $field => $value) $student[$field] = trim($_POST[$field] ?? $value);
    if ($student['student_id'] === '' || $student['name'] === '' || $student['father_name'] === '' || $student['admission_date'] === '') $errors[] = 'Student ID, name, father name and admission date are required.';
    if (!$errors) {
        $statement = $pdo->prepare('INSERT INTO students (student_id, name, father_name, phone, address, class_id, admission_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->execute([$student['student_id'], $student['name'], $student['father_name'], $student['phone'], $student['address'], $student['class_id'] ?: null, $student['admission_date'], $student['status']]);
        set_flash('success', 'Student added successfully.');
        redirect('students.php');
    }
}
require __DIR__ . '/includes/header.php';
?>
<?php require __DIR__ . '/student-form.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
