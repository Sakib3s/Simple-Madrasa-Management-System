<?php

declare(strict_types=1);
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';
$title = 'Teachers';
$search = trim($_GET['search'] ?? '');
$statement = $pdo->prepare('SELECT t.*, c.class_name FROM teachers t LEFT JOIN classes c ON c.id=t.class_id WHERE t.name LIKE ? OR t.phone LIKE ? ORDER BY t.id DESC');
$like = "%{$search}%"; $statement->execute([$like, $like]); $teachers = $statement->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center"><p class="text-sm text-slate-500">Manage teaching staff and assigned classes.</p><a href="teacher-add.php" class="rounded-lg bg-green-700 px-4 py-2.5 text-center text-sm font-semibold text-white"><i class="fa-solid fa-plus mr-2"></i>Add Teacher</a></div>
<div class="rounded-xl bg-white shadow-sm"><form class="flex gap-2 border-b p-4"><input name="search" value="<?= e($search) ?>" placeholder="Search by name or phone" class="flex-1 rounded-lg border px-3 py-2.5 text-sm"><button class="rounded-lg border px-4 text-sm">Search</button></form><?php if (!$teachers): ?><p class="p-10 text-center text-sm text-slate-500">No teachers found.</p><?php else: ?><div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Name</th><th class="px-5 py-3">Phone</th><th class="px-5 py-3">Subject</th><th class="px-5 py-3">Class</th><th class="px-5 py-3">Actions</th></tr></thead><tbody><?php foreach ($teachers as $teacher): ?><tr class="border-t"><td class="px-5 py-3 font-medium"><?= e($teacher['name']) ?></td><td class="px-5 py-3"><?= e($teacher['phone']) ?></td><td class="px-5 py-3"><?= e($teacher['subject']) ?></td><td class="px-5 py-3"><?= e($teacher['class_name'] ?? 'Unassigned') ?></td><td class="px-5 py-3"><a class="mr-3 text-green-700" href="teacher-edit.php?id=<?= $teacher['id'] ?>"><i class="fa-solid fa-pen"></i></a><form class="inline" method="post" action="teacher-delete.php"><input type="hidden" name="id" value="<?= $teacher['id'] ?>"><button data-confirm="Are you sure you want to delete this teacher?" class="text-red-600"><i class="fa-solid fa-trash"></i></button></form></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
