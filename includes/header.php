<?php

declare(strict_types=1);

$currentPage = basename($_SERVER['PHP_SELF']);
$flash = get_flash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(page_title($title ?? 'Admin')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { madrasa: { 50: '#f0fdf4', 600: '#16a34a', 700: '#15803d', 900: '#14532d' } } } }
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800">
<div class="min-h-screen">
    <?php require __DIR__ . '/sidebar.php'; ?>
    <main class="lg:ml-64">
        <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b bg-white px-4 shadow-sm sm:px-6">
            <div class="flex items-center gap-3">
                <button id="menu-button" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-madrasa-700">Admin panel</p>
                    <h1 class="text-lg font-bold"><?= e($title ?? 'Dashboard') ?></h1>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="hidden text-slate-500 sm:inline"><?= e($_SESSION['user_name'] ?? 'Administrator') ?></span>
                <a href="logout.php" class="text-slate-500 hover:text-red-600" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </header>
        <section class="p-4 sm:p-6">
            <?php if ($flash): ?>
                <div class="flash-message mb-5 rounded-lg border px-4 py-3 text-sm <?= $flash['type'] === 'success' ? 'border-green-200 bg-green-50 text-green-800' : 'border-red-200 bg-red-50 text-red-800' ?>">
                    <i class="fa-solid <?= $flash['type'] === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?> mr-2"></i><?= e($flash['message']) ?>
                </div>
            <?php endif; ?>
