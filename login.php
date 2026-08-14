<?php

declare(strict_types=1);

session_start();
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

if (!empty($_SESSION['user_id'])) redirect('index.php');

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $statement = $pdo->prepare('SELECT id, name, username, password FROM users WHERE username = ? LIMIT 1');
        $statement->execute([$username]);
        $user = $statement->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect('index.php');
        }
        $error = 'Invalid username or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Madrasa Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="grid min-h-screen place-items-center bg-gradient-to-br from-green-950 via-green-900 to-slate-900 p-4">
<main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-2xl bg-green-100 text-2xl text-green-700"><i class="fa-solid fa-mosque"></i></div>
        <h1 class="text-2xl font-bold text-slate-900">Madrasa Management System</h1>
        <p class="mt-2 text-sm text-slate-500">Sign in to manage your madrasa</p>
    </div>
    <?php if ($error): ?><div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="space-y-5">
        <label class="block text-sm font-medium">Username<input name="username" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5 outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100"></label>
        <label class="block text-sm font-medium">Password<input type="password" name="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5 outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100"></label>
        <button class="w-full rounded-lg bg-green-700 py-3 font-semibold text-white hover:bg-green-800"><i class="fa-solid fa-right-to-bracket mr-2"></i>Login</button>
    </form>
    <p class="mt-6 text-center text-xs text-slate-400">Demo login: admin / password</p>
</main>
</body>
</html>
