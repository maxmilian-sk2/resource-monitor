<?php
    $uid = (int) $e->id;
?>
<!-- Docker containers component -->
<div class="flex flex-col justify-center items-center bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-5 rounded-xl size-80 lg:size-96">
    <p class="text-gray-100 font-bold text-2xl mb-2">Docker Containers:</p>
    <hr class="w-64 lg:w-80 border-t-2 border-gray-500 my-3">
    <p id="dockerTotal<?php echo $uid; ?>" class="text-gray-100 text-5xl font-bold">0</p>
    <p class="text-gray-500 text-sm mt-1">total containers</p>
    <hr class="w-64 border-t border-gray-700 my-3">
    <div class="flex flex-col gap-1 w-48">
        <div class="flex justify-between text-base">
            <span class="text-gray-400">Created</span>
            <span id="dockerCreated<?php echo $uid; ?>" class="text-gray-100 font-medium">0</span>
        </div>
        <div class="flex justify-between text-base">
            <span class="text-gray-400">Running</span>
            <span id="dockerRunning<?php echo $uid; ?>" style="color: #16a34a;" class="font-medium">0</span>
        </div>
        <div class="flex justify-between text-base">
            <span class="text-gray-400">Paused</span>
            <span id="dockerPaused<?php echo $uid; ?>" style="color: #eab308;" class="font-medium">0</span>
        </div>
        <div class="flex justify-between text-base">
            <span class="text-gray-400">Restarting</span>
            <span id="dockerRestarting<?php echo $uid; ?>" style="color: #eab308;" class="font-medium">0</span>
        </div>
        <div class="flex justify-between text-base">
            <span class="text-gray-400">Exited</span>
            <span id="dockerExited<?php echo $uid; ?>" style="color: #dc2626;" class="font-medium">0</span>
        </div>
        <div class="flex justify-between text-base">
            <span class="text-gray-400">Dead</span>
            <span id="dockerDead<?php echo $uid; ?>" style="color: #dc2626;" class="font-medium">0</span>
        </div>
    </div>

    <script>
        (function () {
            const base = <?php echo json_encode('http://' . $e->host); ?>;
            const token = <?php echo json_encode($e->api_token); ?>;

            const statuses = ["created", "running", "paused", "restarting", "exited", "dead"];

            const els = {
                created: document.getElementById("dockerCreated<?php echo $uid; ?>"),
                running: document.getElementById("dockerRunning<?php echo $uid; ?>"),
                paused: document.getElementById("dockerPaused<?php echo $uid; ?>"),
                restarting: document.getElementById("dockerRestarting<?php echo $uid; ?>"),
                exited: document.getElementById("dockerExited<?php echo $uid; ?>"),
                dead: document.getElementById("dockerDead<?php echo $uid; ?>")
            };
            const totalEl = document.getElementById("dockerTotal<?php echo $uid; ?>");

            function update() {
            Promise.all(statuses.map(s =>
                fetch(base + "/api/docker/containers/?targetStatus=" + s, { headers: { Authorization: token } })
                    .then(r => r.json())
                    .then(d => d.container_amount)
            ))
            .then(counts => {
                let total = 0;
                statuses.forEach((s, i) => {
                    els[s].textContent = counts[i];
                    total += counts[i];
                });
                totalEl.textContent = total;
            })
            .catch(() => {});
            }

            update();
            setInterval(update, 10000);
        })();
    </script>
</div>
