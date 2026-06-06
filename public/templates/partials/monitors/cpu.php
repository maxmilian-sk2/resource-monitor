<?php
    $uid = (int) $e->id;
?>
<!-- CPU usage component -->
<div class="flex flex-col justify-center items-center bg-sky-50/5 backdrop-blur-xs rounded-xl border border-neutral-700 shadow-lg p-5 rounded-xl size-80 lg:size-96">
    <p class="text-gray-100 font-bold text-2xl mb-2">CPU Usage:</p>
    <hr class="w-64 lg:w-80 border-t-2 border-gray-500 my-3">
    <div>

        <div class="flex flex-col items-center gap-4">

            <!-- AI use disclaimer: the SVG below was created using generative AI! -->
            <svg width="256" height="128" viewBox="0 0 256 128">
                <!-- Gradient -->
                <defs>
                <linearGradient id="CPUgaugeGradient<?php echo $uid; ?>" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="10%" stop-color="#16a34a" />
                    <stop offset="50%" stop-color="#eab308" />
                    <stop offset="90%" stop-color="#dc2626" />
                </linearGradient>
                </defs>
                <!-- Outline -->
                <path
                d="M 16 128 A 112 112 0 0 1 240 128"
                fill="none"
                stroke="#1e293b"
                stroke-width="16"
                />
                <!-- Progress -->
                <path
                id="CPUgauge<?php echo $uid; ?>"
                d="M 16 128 A 112 112 0 0 1 240 128"
                fill="none"
                stroke="url(#CPUgaugeGradient<?php echo $uid; ?>)"
                stroke-width="16"
                stroke-linecap="round"
                class="transition-all duration-500"
                stroke-dasharray="351"
                stroke-dashoffset="351"
                />
            </svg>

        </div>

    </div>
    <p id="CPUvalue<?php echo $uid; ?>" class="text-gray-100 text-2xl mt-2">0%</p>
    <hr class="w-64 border-t border-gray-700 my-3">
    <p class="text-gray-100 text-base mt-2"><span id="CPUcores<?php echo $uid; ?>">0</span> cores</p>

    <script>
        (function () {
            const base = <?php echo json_encode('http://' . $e->host); ?>;
            const token = <?php echo json_encode($e->api_token); ?>;

            const CPUpath = document.getElementById("CPUgauge<?php echo $uid; ?>");
            const CPUtext = document.getElementById("CPUvalue<?php echo $uid; ?>");
            const CPUcores = document.getElementById("CPUcores<?php echo $uid; ?>");

            const CPUlength = CPUpath.getTotalLength();
            CPUpath.style.strokeDasharray = CPUlength;
            CPUpath.style.strokeDashoffset = CPUlength;

            function update() {
            fetch(base + "/api/sys/cpuload/", { headers: { Authorization: token } })
                .then(r => r.json())
                .then(d => {
                    const CPUvalue = d.cpu_load;
                    CPUpath.style.strokeDashoffset = CPUlength * (1 - CPUvalue / 100);
                    CPUtext.textContent = CPUvalue + "%";
                })
                .catch(() => {});

            fetch(base + "/api/sys/cpucores/", { headers: { Authorization: token } })
                .then(r => r.json())
                .then(d => {
                    CPUcores.textContent = d.core_count;
                })
                .catch(() => {});
            }

            update();
            setInterval(update, 10000);
        })();
    </script>
</div>
