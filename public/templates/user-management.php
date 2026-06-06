<?php
require_once '../../app/core/App.php';
App::init();

if (!Helper::isAdmin()) {
    Redirect::redirect('home.php');
    exit;
}

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($id > 0) {
        $user->delete($id);
    }
    Redirect::redirect('user-management.php');
    exit;
}

$users = $user->all();

include 'partials/header.php';
?>

<!-- Main content -->
<main class="flex flex-col lg:flex-row lg:pt-24 w-full max-w-[1920px]">

    <div class="w-full lg:pl-4 lg:pr-4 lg:pt-2 lg:pb-2">

    <div class="bg-sky-50/5 backdrop-blur-xs lg:rounded-xl border border-neutral-700 shadow-lg overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-700">
            <p class="text-gray-100 font-bold text-xl">User Management</p>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="hidden md:table-header-group">
                <tr class="border-b border-neutral-700 text-gray-400">
                    <th class="px-6 py-3 font-medium">Username</th>
                    <th class="px-6 py-3 font-medium">Password Hash</th>
                    <th class="px-6 py-3 font-medium">Role</th>
                    <th class="px-6 py-3 font-medium"></th>
                </tr>
            </thead>
            <tbody class="block md:table-row-group">

                <?php foreach ($users as $u): ?>
                    <!-- User -->
                    <tr class="block md:table-row border-b border-neutral-800 px-2 py-3 md:p-0 hover:bg-sky-50/5 transition-colors">
                        <td class="flex justify-between items-center px-4 py-1.5 md:table-cell md:px-6 md:py-4 text-stone-50 font-medium">
                            <span class="text-gray-500 font-normal md:hidden">Username</span><?php echo htmlspecialchars($u->username); ?>
                        </td>
                        <td class="flex justify-between items-center px-4 py-1.5 md:table-cell md:px-6 md:py-4 text-gray-400 font-mono">
                            <span class="text-gray-500 font-sans md:hidden">Password Hash</span><?php echo htmlspecialchars(substr($u->password, 0, 24)); ?>&hellip;
                        </td>
                        <td class="flex justify-between items-center px-4 py-1.5 md:table-cell md:px-6 md:py-4">
                            <span class="text-gray-500 md:hidden">Role</span>
                            <?php if ($u->role === 'admin'): ?>
                                <span class="bg-sky-500/20 text-sky-400 text-xs font-bold px-2 py-0.5 rounded-full">admin</span>
                            <?php else: ?>
                                <span class="bg-gray-500/20 text-gray-400 text-xs font-bold px-2 py-0.5 rounded-full">user</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 pt-2 pb-3 md:table-cell md:px-6 md:py-4">
                            <div class="flex gap-2 justify-end">
                                <a href="user-edit.php?id=<?php echo $u->id; ?>" class="flex items-center gap-1 rounded-lg border border-neutral-600 hover:border-neutral-400 text-gray-300 hover:text-white text-xs px-2.5 py-1 transition-colors"><ion-icon name="pencil-outline"></ion-icon> Edit</a>
                                <form method="POST" onsubmit="return confirm('Delete this user?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $u->id; ?>">
                                    <button type="submit" class="flex items-center gap-1 rounded-lg border border-red-900 hover:border-red-600 text-red-500 hover:text-red-400 text-xs px-2.5 py-1 transition-colors"><ion-icon name="trash-outline"></ion-icon> Delete </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($users)): ?>
                    <tr class="block md:table-row">
                        <td colspan="4" class="px-6 py-4 text-gray-400 text-center">No users yet.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

    </div>
    </div>

    </div>
</main>

<?php include 'partials/footer.php'; ?>
