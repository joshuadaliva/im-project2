document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    formData.append("submit", true)
    fetch('./actions/process_signup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            Swal.fire({
                title: "Success",
                text: data.message,
                icon: "success",
                confirmButtonText:"OK"
            }).then(result => {
                if(result.isConfirmed){
                    window.location.href = "login.php"
                }
            })
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = data.message;
            messageDiv.className = data.success ? 'text-green-500' : 'text-red-500';
        }
        else{
            Swal.fire({
                title: "error",
                text: data.message,
                icon: "error",
                confirmButtonText:"OK"
            })
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = data.message;
            messageDiv.className = data.success ? 'text-green-500' : 'text-red-500';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});