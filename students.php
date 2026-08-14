<?php

declare(strict_types=1);

require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$title = 'Students';
$search = trim($_GET['search'] ?? '');
$sql = 'SELECT s.*, c.class_name FROM students s LEFT JOIN classes c ON c.id = s.class_id';
$params = [];
if ($search !== '') {
    $sql .= ' WHERE s.student_id LIKE ? OR s.name LIKE ? OR s.phone LIKE ?';
    $like = "%{$search}%";
    $params = [$like, $like, $like];
}
$sql .= ' ORDER BY s.id DESC';
$statement = $pdo->prepare($sql);
$statement->execute($params);
$students = $statement->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center"><div><p class="text-sm text-slate-500">Manage student records and enrollment status.</p></div><a href="student-add.php" class="rounded-lg bg-green-700 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-green-800"><i class="fa-solid fa-plus mr-2"></i>Add Student</a></div>
<div class="rounded-xl bg-white shadow-sm">
    <form class="flex gap-2 border-b p-4"><div class="relative flex-1"><i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400"></i><input name="search" value="<?= e($search) ?>" placeholder="Search by ID, name or phone" class="w-full rounded-lg border border-slate-300 py-2.5 pl-9 pr-3 text-sm"></div><button class="rounded-lg border px-4 text-sm font-medium hover:bg-slate-50">Search</button></form>
    <?php if (!$students): ?><div class="p-10 text-center text-sm text-slate-500"><i class="fa-solid fa-user-graduate mb-3 text-3xl text-slate-300"></i><p>No students found.</p><a href="student-add.php" class="mt-3 inline-block font-semibold text-green-700">Add Student</a></div><?php else: ?>
    <div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Student ID</th><th class="px-5 py-3">Name</th><th class="px-5 py-3">Father Name</th><th class="px-5 py-3">Class</th><th class="px-5 py-3">Phone</th><th class="px-5 py-3">Admission</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Actions</th></tr></thead><tbody><?php foreach ($students as $student): ?><tr class="border-t hover:bg-slate-50"><td class="px-5 py-3 font-medium"><?= e($student['student_id']) ?></td><td class="px-5 py-3"><?= e($student['name']) ?></td><td class="px-5 py-3"><?= e($student['father_name']) ?></td><td class="px-5 py-3"><?= e($student['class_name'] ?? 'Unassigned') ?></td><td class="px-5 py-3"><?= e($student['phone']) ?></td><td class="px-5 py-3"><?= e($student['admission_date']) ?></td><td class="px-5 py-3"><span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $student['status'] === 'Active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' ?>"><?= e($student['status']) ?></span></td><td class="px-5 py-3"><a class="mr-3 text-green-700 hover:text-green-900" href="student-edit.php?id=<?= $student['id'] ?>" title="Edit"><i class="fa-solid fa-pen"></i></a><form class="inline" method="post" action="student-delete.php"><input type="hidden" name="id" value="<?= $student['id'] ?>"><button data-confirm="Are you sure you want to delete this student?" class="text-red-600 hover:text-red-800" title="Delete"><i class="fa-solid fa-trash"></i></button></form></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
