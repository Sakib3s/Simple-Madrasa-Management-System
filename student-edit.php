<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);
$statement = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$statement->execute([$id]);
$student = $statement->fetch();
if (!$student) { set_flash('error', 'Student not found.'); redirect('students.php'); }
$title = 'Edit Student';
$classes = $pdo->query('SELECT id, class_name FROM classes ORDER BY class_name')->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['student_id','name','father_name','phone','address','class_id','admission_date','status'] as $field) $student[$field] = trim($_POST[$field] ?? '');
    if ($student['student_id'] === '' || $student['name'] === '' || $student['father_name'] === '' || $student['admission_date'] === '') $errors[] = 'Student ID, name, father name and admission date are required.';
    if (!$errors) {
        $statement = $pdo->prepare('UPDATE students SET student_id=?, name=?, father_name=?, phone=?, address=?, class_id=?, admission_date=?, status=? WHERE id=?');
        $statement->execute([$student['student_id'], $student['name'], $student['father_name'], $student['phone'], $student['address'], $student['class_id'] ?: null, $student['admission_date'], $student['status'], $id]);
        set_flash('success', 'Student updated successfully.');
        redirect('students.php');
    }
}
require __DIR__ . '/includes/header.php';
require __DIR__ . '/student-form.php';
require __DIR__ . '/includes/footer.php';
