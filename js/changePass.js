document.addEventListener('DOMContentLoaded', function () {
    const changePassForm = document.getElementById('changePassForm');

    changePassForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(changePassForm)
        formData.append("submit", true)
        fetch('http://localhost/im/actions/dashboard/process_change_pass.php', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                changePassForm.reset()
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});