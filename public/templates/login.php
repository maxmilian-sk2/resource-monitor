<?php
require_once '../../app/core/App.php';
App::init();

if (Helper::isLoggedIn()) {
    Redirect::redirect('home.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = new User();
    $u = $user->findByUsername($username);

    if ($u && password_verify($password, $u->password)) {
        $_SESSION['user'] = [
            'id' => $u->id,
            'username' => $u->username,
            'role' => $u->role,
        ];
        Redirect::redirect('home.php');
        exit;
    }

    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title><?php echo htmlspecialchars(Helper::getPageTitle()); ?></title>
</head>

<body class="min-h-screen bg-slate-950 bg-[radial-gradient(circle_at_10%_80%,#1e1b4b,transparent_15%),radial-gradient(circle_at_100%_15%,#4a044e,transparent_20%)] flex items-center justify-center">

    <div class="md:w-full max-w-sm bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-8">
        <h1 class="text-stone-50 text-2xl font-bold mb-1 flex items-center gap-2">
            <ion-icon name="speedometer-outline"></ion-icon> Resource Monitor
        </h1>
        <p class="text-gray-400 text-sm mb-6">Sign in to your account</p>

        <hr class="border-neutral-700 mb-6">

        <?php if ($error !== ''): ?>
            <p class="text-red-400 text-sm mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="flex flex-col gap-4">
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Username</label>
                <input type="text" name="username" placeholder="username" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>

            <p class="text-gray-500 text-sm text-center mt-1"><button type="submit" class="mt-2 rounded-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 transition-colors pl-12 pr-12">Log In</button></p>
        </form>

        <p class="text-gray-500 text-sm text-center mt-5">Don't have an account? <a href="register.php" class="text-sky-400 hover:text-sky-300">Register</a></p>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
