'use strict';

window.chartColors = {
    green: '#75c181',
    gray: '#a9b5c9',
    text: '#252930',
    border: '#e7e9ed'
};

let myChart = null;  // Declare chart variable outside of functions

// Fetch chart data based on dropdown selection
function updateChart(period) {
    fetch(`/data-for-charts-by-date?period=${period}`)
        .then(response => response.json())
        .then(data => {
            const labels = Object.keys(data);  // Labels will be time ranges or periods like "1-7", "8-14"
            const counts = Object.values(data);  // Counts per period

            // Configure chart options dynamically based on period
            let chartTitle = 'Nombre de Parties Prenantes ajoutées';
            let stepSize = 1;
            let maxValue = Math.max(...counts) + 1;

            if (period == 1) {
                chartTitle = 'Nombre de Parties Prenantes ajoutées';
            } else if (period == 2) {
                chartTitle = 'Nombre de Parties Prenantes ajoutées';
            } else if (period == 3) {  // For "Ce mois-ci"
                chartTitle = 'Nombre de Parties Prenantes ajoutées';
            } else if (period == 4) {  // For "Cette année" (This year)
                chartTitle = 'Nombre de Parties Prenantes ajoutées';
            }

            const chartConfig = {
                type: 'bar',
                data: {
                    labels: labels,  // Dynamic labels (time ranges for today, dates for the week, or 7-day periods for the month, months for the year)
                    datasets: [{
                        label: 'Parties Prenantes',
                        data: counts,
                        backgroundColor: window.chartColors.green,
                        borderColor: window.chartColors.green,
                        borderWidth: 1,
                        maxBarThickness: 16
                    }]
                },
                options: {
                    responsive: true,
                    aspectRatio: 1.5,
                    legend: {
                        position: 'bottom',
                        align: 'end',
                    },
                    title: {
                        display: true,
                        text: chartTitle
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        titleMarginBottom: 10,
                        bodySpacing: 10,
                        xPadding: 16,
                        yPadding: 16,
                        borderColor: window.chartColors.border,
                        borderWidth: 1,
                        backgroundColor: '#fff',
                        bodyFontColor: window.chartColors.text,
                        titleFontColor: window.chartColors.text,
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                drawBorder: false,
                                color: window.chartColors.border,
                            },
                        },
                        y: {
                            display: true,
                            grid: {
                                drawBorder: false,
                                color: window.chartColors.border,
                            },
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                max: maxValue,
                                stepSize: stepSize,
                                callback: function (value) {
                                    return Number.isInteger(value) ? value : '';
                                }
                            }
                        }
                    }
                }
            };

            // If the chart already exists, update it instead of creating a new one
            if (myChart) {
                myChart.data = chartConfig.data;
                myChart.options = chartConfig.options;
                myChart.update();
            } else {
                // Create a new chart if it doesn't exist
                myChart = new Chart(document.getElementById('canvas-barchart'), chartConfig);
            }
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
}

// Trigger updateChart when dropdown selection changes
document.getElementById('barChartSelect').addEventListener('change', function() {
    const selectedPeriod = this.value;
    updateChart(selectedPeriod);
});

// Initial load with "Cette semaine" option selected
updateChart(1);
