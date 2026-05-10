function appendBorrowerRow(table, borrower) {
    const row = document.createElement('tr');
    row.className = 'bg-white hover:bg-gray-200';

    ['borrower_id', 'name', 'sex', 'mobile_number', 'email'].forEach(field => {
        const cell = document.createElement('td');
        cell.className = 'border px-4 py-2 max-w-xs overflow-hidden text-ellipsis';
        cell.textContent = borrower[field] ?? '';
        row.appendChild(cell);
    });

    const actionCell = document.createElement('td');
    actionCell.className = 'border px-4 py-2 text-center';
    const button = document.createElement('button');
    button.className = 'bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700 addLoan';
    button.value = borrower.borrower_id ?? '';
    button.textContent = 'Add Loan';
    actionCell.appendChild(button);
    row.appendChild(actionCell);

    table.appendChild(row);
}

function showBorrowerMessage(table, message) {
    const row = document.createElement('tr');
    const cell = document.createElement('td');
    cell.colSpan = 6;
    cell.className = 'text-center py-4';
    const span = document.createElement('span');
    span.className = 'text-red-500 font-bold';
    span.textContent = message;
    cell.appendChild(span);
    row.appendChild(cell);
    table.appendChild(row);
}

document.addEventListener('DOMContentLoaded', () => {
    const sexFilter = document.getElementById('sexFilter');
    const borrowersTable = document.getElementById('borrowersTable');

    const fetchBorrowers = () => {
        const sexValue = sexFilter.value;

        const formData = new FormData();
        formData.append('sex', sexValue);

        fetch("http://localhost/im/actions/dashboard/process_filter_borrowers.php", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            borrowersTable.textContent = '';

            if (data.success && data.data.length > 0) {
                data.data.forEach(borrower => appendBorrowerRow(borrowersTable, borrower));
                attachAddLoanListeners();
            } else {
                showBorrowerMessage(borrowersTable, data.message || 'No borrowers found');
            }
        });
    };

    const attachAddLoanListeners = () => {
        const addLoanButtons = document.querySelectorAll(".addLoan");
        addLoanButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                borrower_id = btn.value;
                clientModal.classList.remove("hidden");
                document.getElementById("modalTitle").textContent = "ADD LOAN";
                document.getElementById("clientForm").reset();
            });
        });
    };

    sexFilter.addEventListener('change', fetchBorrowers);
});