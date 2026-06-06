<?php
require_once '../../app/core/App.php';
App::init();

if (!Helper::isAdmin()) {
    Redirect::redirect('home.php');
    exit;
}

$user = new User();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    Redirect::redirect('user-management.php');
    exit;
}

$u = $user->find($id);

if (!$u) {
    Redirect::redirect('user-management.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $role = trim($_POST['role'] ?? 'user');
    $password = $_POST['password'] ?? '';

    if ($username !== '') {
        $user->update($id, $username, $password, $role);
        Redirect::redirect('user-management.php');
        exit;
    }
}

include 'partials/header.php';
?>

<!-- Main content -->
<main class="flex flex-col lg:flex-row lg:pt-24 w-full max-w-[1920px]">

    <div class="w-full lg:pl-4 lg:pr-4 lg:pt-2 lg:pb-2">

    <div class="bg-sky-50/5 backdrop-blur-xs lg:rounded-xl border border-neutral-700 shadow-lg overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-700">
            <p class="text-gray-100 font-bold text-xl">Edit User</p>
        </div>

        <form method="POST" class="flex flex-col gap-4 p-6 max-w-md">
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? $u->username); ?>" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Role</label>
                <select name="role" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500">
                    <option value="user" <?php echo (($_POST['role'] ?? $u->role) === 'user') ? 'selected' : ''; ?>>user</option>
                    <option value="admin" <?php echo (($_POST['role'] ?? $u->role) === 'admin') ? 'selected' : ''; ?>>admin</option>
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">New Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600">
            </div>

            <div class="flex gap-2 mt-2">
                <button type="submit" class="rounded-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-6 transition-colors">Update User</button>
                <a href="user-management.php" class="rounded-full border border-neutral-600 hover:border-neutral-400 text-gray-300 hover:text-white py-2 px-6 transition-colors">Cancel</a>
            </div>
        </form>

    </div>
    </div>

    </div>
</main>

<?php include 'partials/footer.php'; ?>
