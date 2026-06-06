<?php
    $uid = (int) $e->id;
?>
<!-- Disk usage component -->
<div class="flex flex-col justify-center items-center bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-5 rounded-xl size-80 lg:size-96">
    <p class="text-gray-100 font-bold text-2xl mb-2">Disk Usage:</p>
    <hr class="w-64 lg:w-80 border-t-2 border-gray-500 my-3">
    <div>
        <div class="flex flex-col items-center gap-4">

            <!-- AI use disclaimer: the SVG below was created using generative AI! -->
            <svg width="288" height="40" viewBox="0 0 288 40">
                <!-- Gradient -->
                <defs>
                    <linearGradient id="diskLineGradient<?php echo $uid; ?>" x1="8" y1="0" x2="280" y2="0" gradientUnits="userSpaceOnUse">
                        <stop offset="10%" stop-color="#16a34a" />
                        <stop offset="50%" stop-color="#eab308" />
                        <stop offset="90%" stop-color="#dc2626" />
                    </linearGradient>
                </defs>
                <!-- Outline -->
                <path
                    d="M 8 20 L 280 20"
                    fill="none"
                    stroke="#1e293b"
                    stroke-width="16"
                    stroke-linecap="round"
                />
                <!-- Progress -->
                <path
                    id="diskLine<?php echo $uid; ?>"
                    d="M 8 20 L 280 20"
                    fill="none"
                    stroke="url(#diskLineGradient<?php echo $uid; ?>)"
                    stroke-width="16"
                    stroke-linecap="round"
                    class="transition-all duration-500"
                />
            </svg>

        </div>
    </div>
    <p id="diskValue<?php echo $uid; ?>" class="text-gray-100 text-2xl mt-2">0%</p>
    <hr class="w-64 border-t border-gray-700 my-3">
    <p class="text-gray-100 text-base mt-2"><span id="diskUsed<?php echo $uid; ?>" style="color: #16a34a;">0GiB</span> used, <span id="diskFree<?php echo $uid; ?>">0GiB</span> free</p>
    <p id="diskName<?php echo $uid; ?>" class="text-gray-100 text-base mt-2">&hellip;</p>
    <p class="text-gray-100 text-base mt-2"><span id="diskTotal<?php echo $uid; ?>">0GiB</span></p>

    <script>
        (function () {
            const base = <?php echo json_encode('http://' . $e->host); ?>;
            const token = <?php echo json_encode($e->api_token); ?>;

            const diskLine = document.getElementById("diskLine<?php echo $uid; ?>");
            const diskText = document.getElementById("diskValue<?php echo $uid; ?>");
            const diskUsed = document.getElementById("diskUsed<?php echo $uid; ?>");
            const diskFree = document.getElementById("diskFree<?php echo $uid; ?>");
            const diskName = document.getElementById("diskName<?php echo $uid; ?>");
            const diskTotal = document.getElementById("diskTotal<?php echo $uid; ?>");

            const diskLength = diskLine.getTotalLength();
            diskLine.style.strokeDasharray = diskLength;
            diskLine.style.strokeDashoffset = diskLength;

            function update() {
            fetch(base + "/api/sys/diskusage/?path=/", { headers: { Authorization: token } })
                .then(r => r.json())
                .then(d => {
                    const diskValue = d.disk_percent;

                    diskLine.style.strokeDashoffset = diskLength * (1 - diskValue / 100);
                    diskText.textContent = diskValue + "%";

                    diskUsed.textContent = d.disk_used_gb + "GiB";
                    diskFree.textContent = (Math.round((d.disk_total_gb - d.disk_used_gb) * 100) / 100) + "GiB";
                    diskName.textContent = d.disk_name;
                    diskTotal.textContent = d.disk_total_gb + "GiB";

                    let txtColor;
                    if (diskValue < 40) txtColor = "#16a34a";
                    else if (diskValue < 70) txtColor = "#eab308";
                    else txtColor = "#dc2626";
                    diskUsed.style.color = txtColor;
                })
                .catch(() => {});
            }

            update();
            setInterval(update, 10000);
        })();
    </script>
</div>
