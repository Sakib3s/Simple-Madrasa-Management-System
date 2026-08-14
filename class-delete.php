<?php

require __DIR__.'/includes/auth.php';require __DIR__.'/config/database.php';require __DIR__.'/includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){try{$pdo->prepare('DELETE FROM classes WHERE id=?')->execute([(int)($_POST['id']??0)]);set_flash('success','Class deleted successfully.');}catch(PDOException $exception){set_flash('error','This class cannot be deleted while students or teachers are assigned to it.');}}redirect('classes.php');
