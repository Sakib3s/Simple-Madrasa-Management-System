<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php'; require __DIR__ . '/config/database.php'; require __DIR__ . '/includes/functions.php';
$title = 'Add Teacher'; $classes = $pdo->query('SELECT id,class_name FROM classes ORDER BY class_name')->fetchAll(); $errors=[]; $teacher=['name'=>'','phone'=>'','subject'=>'','class_id'=>''];
if ($_SERVER['REQUEST_METHOD']==='POST') { foreach ($teacher as $field=>$value) $teacher[$field]=trim($_POST[$field]??$value); if ($teacher['name']===''||$teacher['subject']==='') $errors[]='Name and subject are required.'; if (!$errors) { $pdo->prepare('INSERT INTO teachers (name,phone,subject,class_id) VALUES (?,?,?,?)')->execute([$teacher['name'],$teacher['phone'],$teacher['subject'],$teacher['class_id']?:null]); set_flash('success','Teacher added successfully.'); redirect('teachers.php'); } }
require __DIR__ . '/includes/header.php';
?>
<?php require __DIR__ . '/teacher-form.php'; require __DIR__ . '/includes/footer.php'; ?>
