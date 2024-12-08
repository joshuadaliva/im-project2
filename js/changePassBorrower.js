document.addEventListener("DOMContentLoaded", function () {
  const openSidebar = document.getElementById("open-sidebar");
  const closeSidebar = document.getElementById("close-sidebar");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");

  openSidebar.addEventListener("click", () => {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
  });

  closeSidebar.addEventListener("click", () => {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
  });

  overlay.addEventListener("click", () => {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
  });
  const changePassForm = document.getElementById("changePassForm");

  changePassForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(changePassForm);
    formData.append("submit", true);
    fetch(
      "http://localhost/im/actions/userPage/process_change_password_borrower.php",
      {
        method: "POST",
        body: formData,
      }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          changePassForm.reset();
          Swal.fire({
            title: "Success!",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK",
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        Swal.fire({
          title: "Error!",
          text: "An unexpected error occurred. Please try again later.",
          icon: "error",
          confirmButtonText: "OK",
        });
      });
  });
});
