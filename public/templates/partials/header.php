<?php
    require_once '../../app/core/App.php';
    App::init();

    $current = basename($_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="en" class="bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Temporary Tailwind connector -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title><?php echo htmlspecialchars(Helper::getPageTitle()); ?></title>
</head>

<!-- Document body -->
<body class="max-w-screen justify-center min-w-screen min-h-screen bg-slate-950 bg-[radial-gradient(125%_125%_at_50%_100%,_#000000_40%,_#350136_100%)] bg-[size:100%_100%]">

    <!-- Content wrapper, limits content to 1920px wide, centered -->
    <div class="lg:flex min-w-screen min-h-screen max-w-[1920px] justify-center">

        <!-- Header (all screens) -->
         <header class="z-40 w-full max-w-[1920px] lg:fixed lg:h-16 lg:pl-4 lg:pr-4 lg:pt-2 lg:pb-2 mb-4 lg:mb-0">
            <div class="flex flex-col lg:flex-row w-full bg-slate-950 lg:bg-sky-50/5 lg:backdrop-blur-xs lg:h-full lg:rounded-xl border-b-1 lg:border border-neutral-700 shadow-lg pr-1">
                <div class="hidden lg:flex items-center justify-center lg:justify-start lg:pl-3 lg:basis-64">
                    <h1 class="text-stone-50"><ion-icon name="speedometer-outline" class="mr-1"></ion-icon>Resource Monitor</h1>
                </div>
                <nav class="flex flex-col lg:flex-row items-center justify-center lg:basis-full">
                    <a href="home.php" class="font-bold rounded-full px-3 py-2 <?php echo $current === 'home.php' ? 'text-sky-500' : 'text-stone-50'; ?> hover:bg-gray-100 hover:text-gray-900">
                        Home
                    </a>
                    <a href="endpoint-management.php" class="font-bold rounded-full px-3 py-2 <?php echo $current === 'endpoint-management.php' ? 'text-sky-500' : 'text-stone-50'; ?> hover:bg-gray-100 hover:text-gray-900">
                        My Endpoints
                    </a>
                    <?php if (Helper::isAdmin()): ?>
                    <a href="user-management.php" class="font-bold rounded-full px-3 py-2 <?php echo $current === 'user-management.php' ? 'text-sky-500' : 'text-stone-50'; ?> hover:bg-gray-100 hover:text-gray-900">
                        Users
                    </a>
                    <?php endif; ?>
                </nav>
                <div class="flex items-center justify-center mb-2 lg:mb-0 lg:basis-64">
                    <div class="mx-auto flex max-w-sm items-center mt-3 lg:mt-0">
                    <div>
                        <p class="text-stone-50"><?php echo htmlspecialchars(Helper::currentUser()['username']); ?>
                        <a href="logout.php"><button class="rounded-full bg-sky-500 hover:bg-sky-700 ml-1 pl-3 pr-3 pt-1 pb-1">Log out</button></a></p>
                    </div>
                </div>
                </div>
            </div>
        </header>
