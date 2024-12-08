
// show details to the modal
const updateLoan = document.querySelectorAll('.updateLoan')
updateLoan.forEach(button => {
  button.addEventListener('click', () => {
    const loanId = button.value;
    const formData = new FormData();
    formData.append('loan_id', loanId);

    fetch("/im/actions/dashboard/process_get_loan.php", {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(loanData => {
        if (loanData.success) {
          document.getElementById('loan_id').value = loanData.data.loan_id;
          document.getElementById('amount').value = loanData.data.amount;
          document.getElementById('start_date').value = loanData.data.start_date;
          document.getElementById('due_date').value = loanData.data.due_date;
          document.getElementById('status').value = loanData.data.status;
          clientModal.classList.remove('hidden');
        } else {
          alert(loanData.message)
        }
      })
      .catch(error => {
        console.error('Error fetching loan data:', error);
      });
  });
});




// update loan button
document.getElementById('clientForm').addEventListener('submit', (event) => {
  event.preventDefault();
  const formData = new FormData(clientForm);
  fetch('/im/actions/dashboard/process_update_loan.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
            title: "Success",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK"
          })
          .then(result => {
            if (result.isConfirmed) {
              location.reload();
              clientModal.classList.add('hidden');
            }
          })
      } else {
        Swal.fire({
            title: "error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK"
          })
          .then(result => {
            if (result.isConfirmed) {
              clientModal.classList.add('hidden');
            }
          })
      }
    })
    .catch(error => {
      console.error('Error updating loan:', error);
    });
});



// delete loan
document.querySelectorAll('.deleteLoan').forEach(button => {
  button.addEventListener('click', () => {
    const loanId = button.value;

    const formData = new FormData();
    formData.append('loan_id', loanId);
    Swal.fire({
        title: "warning",
        text: "do you want to delete this loan",
        icon: "warning",
        confirmButtonText: "yes",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
      })  
      .then(result => {
        if (result.isConfirmed) {
          fetch(`/im/actions/dashboard/process_delete_loan.php`, {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                Swal.fire({
                    title: "Success",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "OK"
                  })
                  .then(result => {
                    if (result.isConfirmed) {
                      location.reload();
                      clientModal.classList.add('hidden');
                    }
                  })
              } else {
                Swal.fire({
                    title: "error",
                    text: data.message,
                    icon: "error",
                    confirmButtonText: "OK"
                  })
                  .then(result => {
                    if (result.isConfirmed) {
                      clientModal.classList.add('hidden');
                    }
                  })
              }
            })
            .catch(error => {
              console.error('Error deleting loan:', error);
            });
        }
      })
  });
});


document.getElementById('start_date').addEventListener('change', function() {
  const startDate = start_date.value;
  const dueDateInput = document.getElementById('due_date');
  if (startDate) {
    dueDateInput.setAttribute('min', startDate);
  } else {
    dueDateInput.removeAttribute('min');
  }
});