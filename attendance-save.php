<?php

declare(strict_types=1);
require __DIR__.'/includes/auth.php';require __DIR__.'/config/database.php';require __DIR__.'/includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){$date=$_POST['attendance_date']??date('Y-m-d');$classId=(int)($_POST['class_id']??0);$statuses=$_POST['status']??[];$statement=$pdo->prepare('INSERT INTO attendance(student_id,attendance_date,status) VALUES(?,?,?) ON DUPLICATE KEY UPDATE status=VALUES(status)');foreach($statuses as $studentId=>$status)if(in_array($status,['Present','Absent','Leave'],true))$statement->execute([(int)$studentId,$date,$status]);set_flash('success','Attendance saved successfully.');redirect("attendance.php?date=".urlencode($date)."&class_id=".$classId);}redirect('attendance.php');
