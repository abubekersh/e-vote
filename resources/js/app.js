import "./bootstrap";
import Chart from "chart.js/auto";
import EthiopianCalendar from "ethiopian-date-converter-swiss-knife";
import { Html5Qrcode } from "html5-qrcode";
// import Alpine from "alpinejs";
// window.Alpine = Alpine;

// Alpine.start();
window.renderpieC = function (label, data) {
    const ctx = document.getElementById("pieChart").getContext("2d");
    new Chart(ctx, {
        type: "pie",
        data: {
            labels: label,
            datasets: [
                {
                    data: data,
                    backgroundColor: [
                        "#3B82F6", // Blue
                        "#10B981", // Green
                        "#F59E0B", // Amber
                        "#EF4444",
                        "#EF4004", // Red // Violet
                    ],
                    borderColor: "#fff",
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom",
                },
                title: {
                    display: true,
                    text: "Users Registered by Role",
                },
            },
        },
    });
};
document.addEventListener("DOMContentLoaded", () => {
    const charts = document.querySelectorAll('canvas[id^="chart-"]');
    charts.forEach((canvas) => {
        const labels = canvas.dataset.labels.split(",");
        const values = canvas.dataset.values.split(",").map(Number);

        new Chart(canvas.getContext("2d"), {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Votes",
                        data: values,
                        backgroundColor: "rgba(75, 192, 192, 0.6)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1,
                        maxBarThickness: 40,
                    },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: true,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        },
                    },
                },
            },
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const chartDataElement = document.getElementById("chart-data");

    const schedules = parseInt(chartDataElement.dataset.schedules);
    const pollingStations = parseInt(chartDataElement.dataset.pollingStations);
    const constituencies = parseInt(chartDataElement.dataset.constituencies);
    const politicalParties = parseInt(
        chartDataElement.dataset.politicalParties
    );

    const ctx = document.getElementById("overviewChart").getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                "Schedules",
                "Polling Stations",
                "Constituencies",
                "Political Parties",
            ],
            datasets: [
                {
                    label: "Count",
                    data: [
                        schedules,
                        pollingStations,
                        constituencies,
                        politicalParties,
                    ],
                    backgroundColor: [
                        "#3b82f6", // blue
                        "#10b981", // green
                        "#f59e0b", // yellow
                        "#ef4444", // red
                    ],
                    borderRadius: 10,
                    barPercentage: 0.5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const chartElement = document.getElementById("candidate-chart-data");

    if (chartElement) {
        const ctx = document.getElementById("candidateChart").getContext("2d");

        const independentCount = parseInt(chartElement.dataset.independent);
        const partyCount = parseInt(chartElement.dataset.party);

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Independent", "Party-Affiliated"],
                datasets: [
                    {
                        label: "Candidates",
                        data: [independentCount, partyCount],
                        backgroundColor: ["#f59e0b", "#3b82f6"],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const chartDataDiv = document.getElementById("voting-chart-data");

    if (chartDataDiv) {
        const voted = parseInt(chartDataDiv.dataset.voted);
        const notVoted = parseInt(chartDataDiv.dataset["notVoted"]);

        const ctx = document.getElementById("votingChart").getContext("2d");

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Voted", "Not Voted"],
                datasets: [
                    {
                        data: [voted, notVoted],
                        backgroundColor: ["#10b981", "#ef4444"],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: "#374151",
                            font: {
                                size: 14,
                            },
                        },
                    },
                },
            },
        });
    }
});

window.renderlineC = function (label, data) {
    const ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {
        type: "line", // or 'bar'
        data: {
            labels: label, // Dates
            datasets: [
                {
                    label: "Registared Users By Date",
                    data: data, // Count per date
                    borderColor: "#3B82F6",
                    backgroundColor: "rgba(59, 130, 246, 0.4)",
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Date",
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Users",
                    },
                },
            },
        },
    });
};
const toggleBtn = document.getElementById("toggle-scanner-btn");
const scannerContainer = document.getElementById("scanner-container");
const resultInput = document.getElementById("token");
let qrScanner;
if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
        if (scannerContainer.style.display === "none") {
            scannerContainer.style.display = "block";
            toggleBtn.innerText = "Close Scanner";
            startScanner();
        } else {
            scannerContainer.style.display = "none";
            toggleBtn.innerText = "Open Scanner";
            stopScanner();
        }
    });
}
function startScanner() {
    qrScanner = new Html5Qrcode("qr-reader");
    qrScanner
        .start(
            {
                facingMode: "environment",
            },
            {
                fps: 10,
                qrbox: {
                    width: 200,
                    height: 150,
                },
            },
            (qrCodeMessage) => {
                stopScanner();
                scannerContainer.style.display = "none";
                toggleBtn.innerText = "Open Scanner";

                document.getElementById("scanner-loading").style.display =
                    "block";
                // Send token to backend using fetch
                fetch("/auto-login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ token: qrCodeMessage }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById(
                            "scanner-loading"
                        ).style.display = "none";
                        if (data.success) {
                            alert(data.message);
                        } else {
                            alert(data.error || "Login failed.");
                        }
                    })
                    .catch((error) => {
                        console.error("Fetch error:", error);
                        alert("Something went wrong.");
                    });
            },
            (errorMessage) => {
                // Optional: console.log(`Scan error: ${errorMessage}`);
            }
        )
        .catch((err) => {
            alert("Camera error: " + err);
        });
}

function stopScanner() {
    if (qrScanner) {
        qrScanner
            .stop()
            .then(() => {
                qrScanner.clear();
            })
            .catch((e) => {
                console.error("Error stopping scanner:", e);
            });
    }
}
function attachLiveSearch({ inputId, resultsId, endpoint, onSelect = null }) {
    const input = document.getElementById(inputId);
    const results = document.getElementById(resultsId);

    input.addEventListener("input", async () => {
        const query = input.value.trim();
        results.innerHTML = "";

        if (!query) return;

        try {
            const response = await fetch(
                `${endpoint}?query=${encodeURIComponent(query)}`
            );
            console.log(response);
            const data = await response.json();

            data.forEach((item) => {
                const li = document.createElement("li");
                li.textContent = item;
                li.style.cursor = "pointer";
                li.addEventListener("click", () => {
                    input.value = item;
                    results.innerHTML = "";
                    if (onSelect) onSelect(item);
                });
                results.appendChild(li);
                results.classList.add("su");
            });
        } catch (err) {
            console.error("Search error:", err);
        }
    });
}

window.attachLiveSearch = attachLiveSearch;

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("search-input")) {
        attachLiveSearch({
            inputId: "search-input",
            resultsId: "suggestions",
            endpoint: "/search/all",
            onSelect: (value) => console.log("Selected:", value),
        });
    }

    if (document.getElementById("constituency-search")) {
        attachLiveSearch({
            inputId: "constituency-search",
            resultsId: "constituency-suggestions",
            endpoint: "/search/c",
            onSelect: (value) => console.log("Selected:", value),
        });
    }

    if (document.getElementById("polling-search")) {
        attachLiveSearch({
            inputId: "polling-search",
            resultsId: "polling-suggestions",
            endpoint: "/search/ps",
            onSelect: (value) => console.log("Selected:", value),
        });
    }
    if (document.getElementById("region-search")) {
        attachLiveSearch({
            inputId: "region-search",
            resultsId: "region-suggestions",
            endpoint: "/search/r",
            onSelect: (value) => console.log("Selected:", value),
        });
    }
});

let d = new Date();
const formattedToday = d.toISOString().split("T")[0];
const calendar = new EthiopianCalendar();
const ethiopianDate = calendar
    .toEthiopian(formattedToday)
    .dateObject.toISOString()
    .split("T")[0];
let darr = ["sdate", "edate"];
darr.forEach((element) => {
    if (document.getElementById(element)) {
        document.getElementById(element).value = ethiopianDate;
        document.getElementById(element).min = ethiopianDate;
    }
});

// document.getElementById("sdate").value = ethiopianDate;
// document.getElementById("sdate").min = ethiopianDate;
// document.getElementById("edate").value = ethiopianDate;
// document.getElementById("edate").min = ethiopianDate;
function contoe(date) {
    const calendar = new EthiopianCalendar();
    const ethiopianDate = calendar.toEthiopian(formattedToday).amDate;

    return ethiopianDate;
}
