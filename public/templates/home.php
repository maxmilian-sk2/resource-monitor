<?php
require_once '../../app/core/App.php';
App::init();

if (!Helper::isLoggedIn()) {
    Redirect::redirect('login.php');
    exit;
}

$endpoint = new Endpoint();
$endpoints = $endpoint->all(Helper::currentUser()['id']);

$monitorPartials = [
    'disk' => 'partials/monitors/disk.php',
    'cpu' => 'partials/monitors/cpu.php',
    'ram' => 'partials/monitors/ram.php',
    'docker_containers' => 'partials/monitors/docker-containers.php',
    'docker_networks' => 'partials/monitors/docker-networks.php',
    'docker_volumes' => 'partials/monitors/docker-volumes.php',
];

include_once 'partials/header.php';
?>


<!-- Main content -->
<main class="flex flex-col lg:flex-row lg:pt-24 max-w-screen">

    <!-- Grid wrapper -->
    <div class="w-full md:pl-18 lg:pl-24 xl:pr-8 2xl:pr-12 flex flex-row grid md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 place-content-around lg:place-content-start gap-6">

        <?php foreach ($endpoints as $e): ?>
            <?php if (isset($monitorPartials[$e->type])): ?>
                <?php include $monitorPartials[$e->type]; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Add monitor component -->
        <a href="endpoint-create.php" class="flex flex-col justify-center items-center bg-sky-50/5 backdrop-blur-xs rounded-xl border border-dashed border-neutral-700 shadow-lg p-5 rounded-xl size-80 lg:size-96 hover:bg-sky-50/10 hover:border-neutral-500 transition-colors cursor-pointer">
            <ion-icon name="add-circle-outline" class="text-gray-500 size-12"></ion-icon>
            <p class="text-gray-500 text-base mt-3">Add Monitor</p>
        </a>

    </div>
</main>

<?php
include 'partials/footer.php';
?>
