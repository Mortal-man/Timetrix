let currentDeleteFormId = null;

function confirmDelete(formId) {
    currentDeleteFormId = formId;
    const modal = document.getElementById("confirmDeleteModal");
    modal.classList.remove('closing');
    modal.style.display = "flex";  // Show the modal

    const confirmBtn = document.getElementById('confirmBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    confirmBtn.onclick = function () {
        document.getElementById(currentDeleteFormId).submit();
    };

    cancelBtn.onclick = function () {
        closeModal();
    };
}

function closeModal() {
    const modal = document.getElementById("confirmDeleteModal");
    modal.classList.add('closing');  // Trigger fade-out animation
    setTimeout(() => {
        modal.style.display = "none";  // Hide modal after fade-out
        modal.classList.remove('closing');
    }, 300);  // Wait for fade-out to finish
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("cancelBtn").addEventListener("click", closeModal);

    document.getElementById("confirmBtn").addEventListener("click", function () {
        if (currentDeleteFormId) {
            document.getElementById(currentDeleteFormId).submit();
            closeModal();
        }
    });

    window.onclick = function (event) {
        const modal = document.getElementById("confirmDeleteModal");
        if (event.target === modal) {
            closeModal();
        }
    };
});
