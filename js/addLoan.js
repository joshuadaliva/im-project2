
  // modal
  const clientModal = document.getElementById('clientModal');
  const closeModalBtn = document.getElementById('closeModalBtn');

  closeModalBtn.addEventListener('click', () => {
    clientModal.classList.add('hidden');
  });

  // date
  document.getElementById('start_date').addEventListener('change', function() {
    const startDate = start_date.value;
    const dueDateInput = document.getElementById('due_date');
    if (startDate) {
      dueDateInput.setAttribute('min', startDate);
    } else {
      dueDateInput.removeAttribute('min');
    }
  });


  

  let borrower_id;
  document.getElementById("clientForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(document.getElementById("clientForm"));
    formData.append("borrower_id", Number(borrower_id));
    fetch("http://localhost/im/actions/dashboard/process_add_loan.php", {
        method: "POST",
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
            if(result.isConfirmed){
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
            if(result.isConfirmed){
                clientModal.classList.add('hidden');
            }
          })
        }
      })
  })


  // add loan buttons
  const addLoan = document.querySelectorAll(".addLoan")
  
  addLoan.forEach(btn => {
    btn.addEventListener("click", () => {
      borrower_id = btn.value;
      clientModal.classList.remove("hidden")
      document.getElementById("modalTitle").textContent = "ADD LOAN";
      document.getElementById("clientForm").reset();
    })
  })