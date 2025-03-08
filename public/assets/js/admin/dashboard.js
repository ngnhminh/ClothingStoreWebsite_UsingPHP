// Biểu đồ cột
var ctx1 = document.getElementById('barChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
            label: 'Doanh thu',
            data: [5000, 7000, 8000, 10000],
            backgroundColor: 'orange'
        }]
    }
});

// Biểu đồ diện
var ctx2 = document.getElementById('lineChart').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
            label: 'Lượt đặt hàng',
            data: [120, 150, 180, 200],
            borderColor: 'red',
            fill: true
        }]
    }
});
