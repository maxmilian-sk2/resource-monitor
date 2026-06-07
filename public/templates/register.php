<?php
require_once '../../app/core/App.php';
App::init();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $adminToken = trim($_POST['admin_token'] ?? '');

    if ($username !== '' && $password !== '') {
        if ($adminToken !== '' && $adminToken !== Config::ADMIN_TOKEN) {
            $error = 'Incorrect admin token.';
        } else {
            $role = ($adminToken === Config::ADMIN_TOKEN) ? 'admin' : 'user';

            $user = new User();
            if ($user->create($username, $password, $role)) {
                Redirect::redirect('login.php');
                exit;
            }

            $error = 'Could not create account (is the username taken?).';
        }
    } else {
        $error = 'Username and password are required.';
    }
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

<body class="min-h-screen bg-slate-950 bg-[radial-gradient(125%_125%_at_50%_100%,_#000000_40%,_#350136_100%)] bg-[size:100%_100%] flex items-center justify-center">

    <div class="md:w-full max-w-sm bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-8">
        <h1 class="text-stone-50 text-2xl font-bold mb-1 flex items-center gap-2">
            <ion-icon name="speedometer-outline"></ion-icon> Resource Monitor
        </h1>
        <p class="text-gray-400 text-sm mb-6">Create a new account</p>

        <hr class="border-neutral-700 mb-6">

        <?php if ($error !== ''): ?>
            <p class="text-red-400 text-sm mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="flex flex-col gap-4">
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" placeholder="username" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Admin Token (optional)</label>
                <input type="password" name="admin_token" placeholder="••••••••" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600">
            </div>

            <p class="text-gray-500 text-sm text-center mt-1"><button type="submit" class="mt-2 rounded-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 transition-colors pl-12 pr-12">Register</button></p>
        </form>

        <p class="text-gray-500 text-sm text-center mt-5">Already have an account? <a href="login.php" class="text-sky-400 hover:text-sky-300">Log In</a></p>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
