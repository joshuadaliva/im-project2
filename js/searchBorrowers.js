document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInputBorrowers');
    const borrowersTable = document.getElementById('borrowersTable');

    const fetchBorrowers = () => {
        const searchValue = searchInput.value;

        const formData = new FormData();
        formData.append('search', searchValue);

        fetch("http://localhost/im/actions/dashboard/process_search_borrowers.php", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            borrowersTable.innerHTML = '';

            if (data.success && data.data.length > 0) {
                data.data.forEach(borrower => {
                    const row = document.createElement('tr');
                    row.className = 'bg-white hover:bg-gray-200';
                    row.innerHTML = `
                        <td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>${borrower.borrower_id}</td>
                        <td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>${borrower.name}</td>
                        <td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>${borrower.sex}</td>
                        <td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>${borrower.mobile_number}</td>
                        <td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>${borrower.email}</td>
                        <td class='border px-4 py-2 text-center'>
                            <button class='bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700 addLoan' value='${borrower.borrower_id}'>Add Loan</button>
                        </td>
                    `;
                    borrowersTable.appendChild(row);
                });
                attachAddLoanListeners();
            } else {
                borrowersTable.innerHTML = `
                    <tr>
                        <td colspan='6' class='text-center py-4'>
                            <span class='text-red-500 font-bold'>${data.message}</span>
                        </td>
                    </tr>
                `;
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

    searchInput.addEventListener('input', fetchBorrowers);
});