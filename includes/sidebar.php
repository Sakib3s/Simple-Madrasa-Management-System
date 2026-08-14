<?php

$links = [
    ['index.php', 'fa-gauge', 'Dashboard'],
    ['students.php', 'fa-user-graduate', 'Students'],
    ['teachers.php', 'fa-chalkboard-user', 'Teachers'],
    ['classes.php', 'fa-school', 'Classes'],
    ['attendance.php', 'fa-calendar-check', 'Attendance'],
    ['fees.php', 'fa-money-bill', 'Fees'],
];
?>
<div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/40 lg:hidden"></div>
<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 -translate-x-full bg-madrasa-900 text-white transition-transform lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/10 px-6">
        <span class="grid h-9 w-9 place-items-center rounded-lg bg-white text-madrasa-700"><i class="fa-solid fa-mosque"></i></span>
        <div><p class="font-bold">Madrasa</p><p class="text-xs text-green-200">Management System</p></div>
    </div>
    <nav class="space-y-1 p-4">
        <?php foreach ($links as [$url, $icon, $label]): ?>
            <a href="<?= e($url) ?>" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm <?= $currentPage === $url ? 'bg-white/15 font-semibold text-white' : 'text-green-100 hover:bg-white/10' ?>">
                <i class="fa-solid <?= e($icon) ?> w-5"></i><?= e($label) ?>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="absolute bottom-0 w-full border-t border-white/10 p-4 text-xs text-green-200">Learn. Serve. Grow.</div>
</aside>
