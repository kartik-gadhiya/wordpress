// 1. Pehle element ko variable mein save karein
const chartElement = document.getElementById("portfolioChart");

// 2. Check karein ke element exist karta hy ya nahi
if (chartElement) {
    const ctx = chartElement.getContext("2d");

    // ✅ Add margin-bottom to header dynamically
    const header = document.querySelector(".chart-header");
    if (header) {
        header.style.marginBottom = "25px";
    }

    // Gradients for area fill
    const redGradient = ctx.createLinearGradient(0, 0, 0, 400);
    redGradient.addColorStop(0, "rgba(255, 99, 99, 0.25)");
    redGradient.addColorStop(1, "rgba(255, 99, 99, 0)");

    const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
    blueGradient.addColorStop(0, "rgba(77, 166, 255, 0.25)");
    blueGradient.addColorStop(1, "rgba(77, 166, 255, 0)");

    new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
            datasets: [
                {
                    label: "Finspire",
                    data: [25, 20, 35, 85, 40, 65, 30, 55, 35, 45],
                    borderColor: "#ff4c4c",
                    backgroundColor: redGradient,
                    borderWidth: 1,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: "#ff4c4c",
                },
                {
                    label: "Others",
                    data: [30, 15, 60, 40, 20, 50, 65, 35, 25, 55],
                    borderColor: "#4da6ff",
                    backgroundColor: blueGradient,
                    borderWidth: 1,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: "#4da6ff",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: "#ccc",
                        usePointStyle: true,
                        pointStyle: "circle",
                        boxWidth: 12,
                    },
                    position: "top",
                    align: "end",
                },
                tooltip: {
                    backgroundColor: "#fff",
                    titleColor: "#000",
                    bodyColor: "#000",
                    displayColors: false,
                    yAlign: "bottom",
                    caretSize: 0,
                    callbacks: {
                        label: (ctx) => `$${(ctx.parsed.y * 100).toLocaleString()}`,
                    },
                    external: function (context) {
                        const tooltip = context.tooltip;
                        if (tooltip.opacity === 0) return;

                        const chart = context.chart;
                        const ctx = chart.ctx;
                        const { dataPoints } = tooltip;
                        if (!dataPoints.length) return;

                        const { x, y } = dataPoints[0].element;
                        ctx.save();
                        ctx.beginPath();
                        ctx.setLineDash([3, 3]);
                        ctx.moveTo(x, y);
                        ctx.lineTo(x, chart.chartArea.bottom);
                        ctx.lineWidth = 1;
                        ctx.strokeStyle = "rgba(255,255,255,0.3)";
                        ctx.stroke();
                        ctx.restore();
                    },
                },
            },
            scales: {
                x: {
                    ticks: { color: "#aaa", font: { size: 12 } },
                    grid: { color: "rgba(255, 255, 255, 0.05)" },
                },
                y: {
                    ticks: {
                        color: "#aaa",
                        callback: (val) => `${val}K`,
                        stepSize: 20,
                    },
                    grid: { color: "rgba(255, 255, 255, 0.05)" },
                    min: 0,
                    max: 100,
                },
            },
            interaction: {
                mode: "index",
                intersect: false,
            },
            animation: {
                duration: 1800,
                easing: "easeInOutQuart",
            },
        },
    });
} else {
    // Agar element nahi mila to ye line console mein error nahi degi
    console.log("Portfolio chart element not found on this page, skipping initialization.");
}