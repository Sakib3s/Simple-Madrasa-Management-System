<?php

declare(strict_types=1);

require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$title = 'Dashboard';
$counts = [
    'students' => (int) $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'Active'")->fetchColumn(),
    'teachers' => (int) $pdo->query('SELECT COUNT(*) FROM teachers')->fetchColumn(),
    'classes' => (int) $pdo->query('SELECT COUNT(*) FROM classes')->fetchColumn(),
    'present' => (int) $pdo->query("SELECT COUNT(*) FROM attendance WHERE attendance_date = CURDATE() AND status = 'Present'")->fetchColumn(),
];
$recentStudents = $pdo->query('SELECT s.student_id, s.name, c.class_name, s.admission_date FROM students s LEFT JOIN classes c ON c.id = s.class_id ORDER BY s.id DESC LIMIT 5')->fetchAll();
$attendanceSummary = $pdo->query("SELECT status, COUNT(*) AS total FROM attendance WHERE attendance_date = CURDATE() GROUP BY status")->fetchAll();
$summary = ['Present' => 0, 'Absent' => 0, 'Leave' => 0];
foreach ($attendanceSummary as $row) $summary[$row['status']] = (int) $row['total'];
$recentFees = $pdo->query('SELECT f.fee_month, f.paid_amount, f.status, s.name FROM fees f JOIN students s ON s.id = f.student_id ORDER BY f.id DESC LIMIT 5')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
<?php foreach ([['students','Total Students','fa-user-graduate','green'],['teachers','Total Teachers','fa-chalkboard-user','blue'],['classes','Total Classes','fa-school','violet'],['present',"Today's Present",'fa-calendar-check','amber']] as [$key,$label,$icon,$color]): ?>
    <div class="rounded-xl bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="text-sm text-slate-500"><?= e($label) ?></span><span class="grid h-10 w-10 place-items-center rounded-lg bg-<?= $color ?>-100 text-<?= $color ?>-700"><i class="fa-solid <?= $icon ?>"></i></span></div><p class="mt-3 text-3xl font-bold"><?= $counts[$key] ?></p></div>
<?php endforeach; ?>
</div>
<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <div class="rounded-xl bg-white shadow-sm"><div class="flex items-center justify-between border-b p-5"><h2 class="font-bold">Recent Students</h2><a href="students.php" class="text-sm font-semibold text-green-700">View all</a></div>
        <?php if (!$recentStudents): ?><p class="p-6 text-sm text-slate-500">No students found.</p><?php else: ?><div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Student</th><th class="px-5 py-3">Class</th><th class="px-5 py-3">Admission</th></tr></thead><tbody><?php foreach ($recentStudents as $student): ?><tr class="border-t"><td class="px-5 py-3"><p class="font-medium"><?= e($student['name']) ?></p><p class="text-xs text-slate-500"><?= e($student['student_id']) ?></p></td><td class="px-5 py-3"><?= e($student['class_name'] ?? 'Unassigned') ?></td><td class="px-5 py-3"><?= e($student['admission_date']) ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
    </div>
    <div class="rounded-xl bg-white shadow-sm"><div class="border-b p-5"><h2 class="font-bold">Today's Attendance</h2></div><div class="grid grid-cols-3 gap-3 p-5"><?php foreach ($summary as $label => $total): ?><div class="rounded-lg bg-slate-50 p-4 text-center"><p class="text-2xl font-bold"><?= $total ?></p><p class="mt-1 text-xs text-slate-500"><?= e($label) ?></p></div><?php endforeach; ?></div></div>
</div>
<div class="mt-6 rounded-xl bg-white shadow-sm"><div class="border-b p-5"><h2 class="font-bold">Recent Fee Payments</h2></div><?php if (!$recentFees): ?><p class="p-6 text-sm text-slate-500">No fee payments found.</p><?php else: ?><div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Student</th><th class="px-5 py-3">Month</th><th class="px-5 py-3">Paid</th><th class="px-5 py-3">Status</th></tr></thead><tbody><?php foreach ($recentFees as $fee): ?><tr class="border-t"><td class="px-5 py-3"><?= e($fee['name']) ?></td><td class="px-5 py-3"><?= e($fee['fee_month']) ?></td><td class="px-5 py-3"><?= number_format((float) $fee['paid_amount'], 2) ?></td><td class="px-5 py-3"><span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $fee['status'] === 'Paid' ? 'bg-green-100 text-green-700' : ($fee['status'] === 'Partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>"><?= e($fee['status']) ?></span></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
