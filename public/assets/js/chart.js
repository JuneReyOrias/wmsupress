document.addEventListener('DOMContentLoaded', function() {
    // Sample static data for charts
    const productRevenueData = [100, 150, 200, 250, 300, 350, 400];


    // Service Overview Chart
    var productRevenueCtx = document.getElementById('productRevenueChart').getContext('2d');
    var productRevenueChart = new Chart(productRevenueCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Month Of April',
                data: productRevenueData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
