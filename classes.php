<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php'; require __DIR__ . '/config/database.php'; require __DIR__ . '/includes/functions.php';
$title='Classes'; $classes=$pdo->query('SELECT c.*, COUNT(s.id) AS student_count FROM classes c LEFT JOIN students s ON s.class_id=c.id GROUP BY c.id ORDER BY c.class_name')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center"><p class="text-sm text-slate-500">Organize students into learning groups.</p><a href="class-add.php" class="rounded-lg bg-green-700 px-4 py-2.5 text-center text-sm font-semibold text-white"><i class="fa-solid fa-plus mr-2"></i>Add Class</a></div>
<div class="rounded-xl bg-white shadow-sm"><?php if(!$classes): ?><p class="p-10 text-center text-sm text-slate-500">No classes found.</p><?php else: ?><div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Class Name</th><th class="px-5 py-3">Description</th><th class="px-5 py-3">Students</th><th class="px-5 py-3">Actions</th></tr></thead><tbody><?php foreach($classes as $class): ?><tr class="border-t"><td class="px-5 py-3 font-medium"><?=e($class['class_name'])?></td><td class="px-5 py-3"><?=e($class['description'])?></td><td class="px-5 py-3"><?=e($class['student_count'])?></td><td class="px-5 py-3"><a class="mr-3 text-green-700" href="class-edit.php?id=<?=$class['id']?>"><i class="fa-solid fa-pen"></i></a><form class="inline" method="post" action="class-delete.php"><input type="hidden" name="id" value="<?=$class['id']?>"><button data-confirm="Are you sure you want to delete this class?" class="text-red-600"><i class="fa-solid fa-trash"></i></button></form></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
