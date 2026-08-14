<?php

declare(strict_types=1);
require __DIR__.'/includes/auth.php';require __DIR__.'/config/database.php';require __DIR__.'/includes/functions.php';
$title='Add Class';$errors=[];$class=['class_name'=>'','description'=>''];
if($_SERVER['REQUEST_METHOD']==='POST'){$class['class_name']=trim($_POST['class_name']??'');$class['description']=trim($_POST['description']??'');if($class['class_name']==='')$errors[]='Class name is required.';if(!$errors){$pdo->prepare('INSERT INTO classes(class_name,description) VALUES(?,?)')->execute([$class['class_name'],$class['description']]);set_flash('success','Class added successfully.');redirect('classes.php');}}
require __DIR__.'/includes/header.php';require __DIR__.'/class-form.php';require __DIR__.'/includes/footer.php';
