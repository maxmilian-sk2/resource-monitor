<?php
    $uid = (int) $e->id;
?>
<!-- RAM usage component -->
<div class="flex flex-col justify-center items-center bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-5 rounded-xl size-80 lg:size-96">
    <p class="text-gray-100 font-bold text-2xl mb-2">RAM Usage:</p>
    <hr class="w-64 lg:w-80 border-t-2 border-gray-500 my-3">
    <div>

        <div class="flex flex-row items-center gap-4">

            <!-- AI use disclaimer: the SVG below was created using generative AI! -->
            <svg width="150" height="150" viewBox="0 0 150 150">
                <!-- Outline -->
                <circle
                cx="80"
                cy="80"
                r="60"
                fill="none"
                stroke="#1e293b"
                stroke-width="12"
                />
                <!-- Progress -->
                <circle
                id="RAMcircleGauge<?php echo $uid; ?>"
                cx="80"
                cy="80"
                r="60"
                fill="none"
                stroke="green"
                stroke-width="12"
                stroke-linecap="round"
                transform="rotate(-90 80 80)"
                class="transition-all duration-500"
                />
            </svg>

            <p class="text-gray-100"><span id="RAMUsed<?php echo $uid; ?>" style="color: #16a34a;">0GB</span> used<br><span id="RAMFree<?php echo $uid; ?>">0GB</span> free</p>

        </div>

    </div>
    <p id="RAMvalue<?php echo $uid; ?>" class="text-gray-100 text-2xl mt-2">0%</p>
    <hr class="w-64 border-t border-gray-700 my-1 lg:my-3">
    <p class="text-gray-100 text-base mt-2"><span id="RAMTotal<?php echo $uid; ?>">0GB</span></p>

    <script>
        (function () {
            const base = <?php echo json_encode('http://' . $e->host); ?>;
            const token = <?php echo json_encode($e->api_token); ?>;

            const RAMcircle = document.getElementById("RAMcircleGauge<?php echo $uid; ?>");
            const RAMtext = document.getElementById("RAMvalue<?php echo $uid; ?>");
            const RAMusedText = document.getElementById("RAMUsed<?php echo $uid; ?>");
            const RAMfreeText = document.getElementById("RAMFree<?php echo $uid; ?>");
            const RAMtotalText = document.getElementById("RAMTotal<?php echo $uid; ?>");

            const RAMradius = 60;
            const RAMcircumference = 2 * Math.PI * RAMradius;
            RAMcircle.style.strokeDasharray = RAMcircumference;
            RAMcircle.style.strokeDashoffset = RAMcircumference;

            function update() {
            fetch(base + "/api/sys/ramutilization/", { headers: { Authorization: token } })
                .then(r => r.json())
                .then(d => {
                    const RAMvalue = d.ram_percent;

                    RAMcircle.style.strokeDashoffset = RAMcircumference * (1 - RAMvalue / 100);

                    let RAMcolor;
                    if (RAMvalue < 40) RAMcolor = "#16a34a";
                    else if (RAMvalue < 70) RAMcolor = "#eab308";
                    else RAMcolor = "#dc2626";
                    RAMcircle.style.stroke = RAMcolor;
                    RAMusedText.style.color = RAMcolor;

                    RAMtext.textContent = RAMvalue + "%";
                    RAMusedText.textContent = d.ram_used_gb + "GB";
                    RAMfreeText.textContent = (Math.round((d.ram_total_gb - d.ram_used_gb) * 100) / 100) + "GB";
                    RAMtotalText.textContent = d.ram_total_gb + "GB";
                })
                .catch(() => {});
            }

            update();
            setInterval(update, 10000);
        })();
    </script>
</div>
