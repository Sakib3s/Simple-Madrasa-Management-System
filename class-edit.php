<?php

declare(strict_types=1);
require __DIR__.'/includes/auth.php';require __DIR__.'/config/database.php';require __DIR__.'/includes/functions.php';
$id=(int)($_GET['id']??0);$statement=$pdo->prepare('SELECT * FROM classes WHERE id=?');$statement->execute([$id]);$class=$statement->fetch();if(!$class){set_flash('error','Class not found.');redirect('classes.php');}$title='Edit Class';$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){$class['class_name']=trim($_POST['class_name']??'');$class['description']=trim($_POST['description']??'');if($class['class_name']==='')$errors[]='Class name is required.';if(!$errors){$pdo->prepare('UPDATE classes SET class_name=?,description=? WHERE id=?')->execute([$class['class_name'],$class['description'],$id]);set_flash('success','Class updated successfully.');redirect('classes.php');}}
require __DIR__.'/includes/header.php';require __DIR__.'/class-form.php';require __DIR__.'/includes/footer.php';
