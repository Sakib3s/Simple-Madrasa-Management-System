<?php

require __DIR__ . '/includes/auth.php'; require __DIR__ . '/config/database.php'; require __DIR__ . '/includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){$pdo->prepare('DELETE FROM teachers WHERE id=?')->execute([(int)($_POST['id']??0)]);set_flash('success','Teacher deleted successfully.');} redirect('teachers.php');
