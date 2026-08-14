<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php'; require __DIR__ . '/config/database.php'; require __DIR__ . '/includes/functions.php';
$id=(int)($_GET['id']??0); $statement=$pdo->prepare('SELECT * FROM teachers WHERE id=?'); $statement->execute([$id]); $teacher=$statement->fetch(); if(!$teacher){set_flash('error','Teacher not found.');redirect('teachers.php');}
$title='Edit Teacher'; $classes=$pdo->query('SELECT id,class_name FROM classes ORDER BY class_name')->fetchAll(); $errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){foreach(['name','phone','subject','class_id'] as $field)$teacher[$field]=trim($_POST[$field]??'');if($teacher['name']===''||$teacher['subject']==='')$errors[]='Name and subject are required.';if(!$errors){$pdo->prepare('UPDATE teachers SET name=?,phone=?,subject=?,class_id=? WHERE id=?')->execute([$teacher['name'],$teacher['phone'],$teacher['subject'],$teacher['class_id']?:null,$id]);set_flash('success','Teacher updated successfully.');redirect('teachers.php');}}
require __DIR__ . '/includes/header.php'; require __DIR__ . '/teacher-form.php'; require __DIR__ . '/includes/footer.php';
