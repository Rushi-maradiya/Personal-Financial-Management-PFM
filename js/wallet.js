        // Variable to store the active transaction type
        let transactionType = 'income'; // Changed variable name

        // Set the default date to today's date
        document.getElementById('date').valueAsDate = new Date();

        // Set initial category options for Income
        function updateCategoryOptions() {
            const categorySelect = document.getElementById('category');
            categorySelect.innerHTML = ''; // Clear existing options

            if (transactionType === 'income') {
                // Income categories
                const incomeCategories = ['Salary', 'Freelance', 'Investments', 'PocketMoney', 'Other'];
                incomeCategories.forEach(function (category) {
                    let option = document.createElement('option');
                    option.value = category.toLowerCase();
                    option.textContent = category;
                    categorySelect.appendChild(option);
                });
            } else if (transactionType === 'expenses') {
                // Expenses categories
                const expenseCategories = ['Food', 'Transport', 'Entertainment', 'Education', 'Bills', 'Utilities', 'Other'];
                expenseCategories.forEach(function (category) {
                    let option = document.createElement('option');
                    option.value = category.toLowerCase();
                    option.textContent = category;
                    categorySelect.appendChild(option);
                });
            }

            // Update the displayed active transaction type
            document.getElementById('activeTransactionTypeDisplay').textContent = 'Active Transaction Type: ' + (transactionType.charAt(0).toUpperCase() + transactionType.slice(1));
        }

        // Initial category population based on the default radio button (Income)
        updateCategoryOptions();

        // Event listeners for radio buttons to update category options and active transaction type
        document.getElementById('incomeRadio').addEventListener('change', function () {
            transactionType = 'income';
            updateCategoryOptions();
        });

        document.getElementById('expensesRadio').addEventListener('change', function () {
            transactionType = 'expenses';
            updateCategoryOptions();
        });

        // Get the button and form elements
        const addTransactionBtn = document.getElementById('addTransactionBtn');
        const transactionForm = document.getElementById('transactionForm');

        // Toggle form visibility when the button is clicked
        addTransactionBtn.addEventListener('click', function () {
            if (transactionForm.style.display === 'none' || transactionForm.style.display === '') {
                transactionForm.style.display = 'block';
                addTransactionBtn.textContent = 'Cancel Transaction';  // Change button text to "Cancel"
            } else {
                transactionForm.style.display = 'none';
                addTransactionBtn.textContent = 'Add Transaction';  // Reset button text
            }
        });
