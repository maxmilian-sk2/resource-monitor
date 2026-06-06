<?php
    $uid = (int) $e->id;
?>
<!-- Docker volumes component -->
<div class="flex flex-col justify-center items-center bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-5 rounded-xl size-80 lg:size-96">
    <p class="text-gray-100 font-bold text-2xl mb-2">Docker Volumes:</p>
    <hr class="w-64 lg:w-80 border-t-2 border-gray-500 my-3">
    <p id="volumeTotal<?php echo $uid; ?>" class="text-gray-100 text-5xl font-bold">0</p>
    <p class="text-gray-500 text-sm mt-1">total volumes</p>

    <script>
        (function () {
            const base = <?php echo json_encode('http://' . $e->host); ?>;
            const token = <?php echo json_encode($e->api_token); ?>;

            function update() {
            fetch(base + "/api/docker/volumes/", { headers: { Authorization: token } })
                .then(r => r.json())
                .then(d => {
                    document.getElementById("volumeTotal<?php echo $uid; ?>").textContent = d.volume_amount;
                })
                .catch(() => {});
            }

            update();
            setInterval(update, 10000);
        })();
    </script>
</div>
