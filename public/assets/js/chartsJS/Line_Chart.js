'use strict';

window.chartColors = {
    green: '#75c181',
    blue: '#4d94ff',  // For fournisseur_clients
    gray: '#a9b5c9',
    text: '#252930',
    border: '#e7e9ed'
};

let myLineChart = null;  // Declare chart variable for the line chart

// Fetch chart data based on dropdown selection
function updateLineChart(period) {
    fetch(`/data-for-line-chart-by-date?period=${period}`) // Ensure correct route here
        .then(response => response.json())
        .then(data => {
            // Check if both fournisseurs and fournisseur_clients exist
            if (!data.fournisseurs || !data.fournisseur_clients) {
                console.error('Missing data: fournisseurs or fournisseur_clients');
                return;
            }

            // Extract labels (which should be time ranges or periods) from the data
            const labels = Object.keys(data.fournisseurs);  // Assume labels are in the keys of the data
            const fournisseursCounts = Object.values(data.fournisseurs); // Counts for fournisseurs
            const fournisseurClientsCounts = Object.values(data.fournisseur_clients); // Counts for fournisseur_clients

            // Debugging line to check the data structure
            console.log('Received data:', data);
            console.log('Labels:', labels);
            console.log('Fournisseurs Counts:', fournisseursCounts);
            console.log('Fournisseurs Clients Counts:', fournisseurClientsCounts);

            if (fournisseursCounts.length === 0 || fournisseurClientsCounts.length === 0) {
                console.warn('No data found for the specified period.');
                return;
            }

            // Proceed with chart creation
            let chartTitle = 'Nombre de Fournisseurs et Fournisseurs Clients ajoutés';
            let stepSize = 1;
            let maxValue = Math.max(
                Math.max(...fournisseursCounts),
                Math.max(...fournisseurClientsCounts)
            ) + 1;

            const chartConfig = {
                type: 'line',
                data: {
                    labels: labels,  // Use the dates or time periods as labels
                    datasets: [{
                        label: 'Fournisseurs',
                        data: fournisseursCounts,  // Counts for fournisseurs on Y-axis
                        backgroundColor: window.chartColors.green,
                        borderColor: window.chartColors.green,
                        fill: false,
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: window.chartColors.green,
                    },
                    {
                        label: 'Fournisseurs Clients',
                        data: fournisseurClientsCounts,  // Counts for fournisseur_clients on Y-axis
                        backgroundColor: window.chartColors.blue,
                        borderColor: window.chartColors.blue,
                        fill: false,
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: window.chartColors.blue,
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
            if (myLineChart) {
                myLineChart.data = chartConfig.data;
                myLineChart.options = chartConfig.options;
                myLineChart.update();
            } else {
                // Create a new chart if it doesn't exist
                myLineChart = new Chart(document.getElementById('canvas-linechart'), chartConfig);
            }
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
}

// Trigger updateLineChart when dropdown selection changes
document.getElementById('lineChartSelect').addEventListener('change', function () {
    const selectedPeriod = this.value;
    updateLineChart(selectedPeriod);
});

// Initial load with "Cette semaine" option selected
updateLineChart(1);
