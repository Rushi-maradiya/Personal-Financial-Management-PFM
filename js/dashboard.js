var ctx = document.getElementById('transactionChart').getContext('2d');
var transactionChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Income (INR)',
                data: incomeData,
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            },
            {
                label: 'Expenses (INR)',
                data: expenseData,
                backgroundColor: 'rgba(220, 53, 69, 0.6)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return '₹' + tooltipItem.raw.toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});




function updateCardValues() {
    document.getElementById('totalTransactions').textContent = totalTransactions;
    document.getElementById('totalIncome').textContent = '₹' + totalIncome.toLocaleString();
    document.getElementById('totalExpenses').textContent = '₹' + totalExpenses.toLocaleString();
    document.getElementById('totalAmount').textContent = '₹' + (totalIncome + totalExpenses).toLocaleString();
}

// Update chart when filter changes
document.querySelectorAll('input[name="btnradio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        window.location.href = "?filter=" + this.id.replace("Filter", "").toLowerCase();
    });
});

// Call the updateCardValues function initially
updateCardValues();