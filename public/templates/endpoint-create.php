<?php
require_once '../../app/core/App.php';
App::init();

if (!Helper::isLoggedIn()) {
    Redirect::redirect('login.php');
    exit;
}

$endpoint = new Endpoint();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $host = trim($_POST['host'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $api_token = trim($_POST['api_token'] ?? '');

    if ($name !== '' && $host !== '' && isset(Endpoint::TYPES[$type])) {
        $endpoint->create(Helper::currentUser()['id'], $name, $host, $type, $api_token);
        Redirect::redirect('endpoint-management.php');
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
            <p class="text-gray-100 font-bold text-xl">Add Endpoint</p>
        </div>

        <form method="POST" class="flex flex-col gap-4 p-6 max-w-md">
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" placeholder="Server 1 CPU" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Host</label>
                <input type="text" name="host" value="<?php echo htmlspecialchars($_POST['host'] ?? ''); ?>" placeholder="localhost:8000" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm font-mono focus:outline-none focus:border-sky-500 placeholder-gray-600" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">Type</label>
                <select name="type" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm focus:outline-none focus:border-sky-500">
                    <?php foreach (Endpoint::TYPES as $value => $label): ?>
                        <option value="<?php echo htmlspecialchars($value); ?>" <?php echo (($_POST['type'] ?? '') === $value) ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-gray-400 text-sm">API Token</label>
                <input type="text" name="api_token" value="<?php echo htmlspecialchars($_POST['api_token'] ?? ''); ?>" placeholder="API token" class="bg-slate-900 border border-neutral-700 rounded-full px-3 py-2 text-stone-50 text-sm font-mono focus:outline-none focus:border-sky-500 placeholder-gray-600">
            </div>

            <div class="flex gap-2 mt-2">
                <button type="submit" class="rounded-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-6 transition-colors">Save Endpoint</button>
                <a href="endpoint-management.php" class="rounded-full border border-neutral-600 hover:border-neutral-400 text-gray-300 hover:text-white py-2 px-6 transition-colors">Cancel</a>
            </div>
        </form>

    </div>
    </div>

    </div>
</main>

<?php include 'partials/footer.php'; ?>
