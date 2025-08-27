function showToast(message, type = "info") {
    const container = document.querySelector(".toast-container") || createToastContainer();
    const toast = document.createElement("div");
    toast.classList.add("toast");
    toast.textContent = message;

    if (type === "success") toast.style.background = "#28a745";
    if (type === "error") toast.style.background = "#dc3545";
    if (type === "warning") toast.style.background = "#ffc107";

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add("show");
    }, 100);

    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

function createToastContainer() {
    const container = document.createElement("div");
    container.classList.add("toast-container");
    document.body.appendChild(container);
    return container;
}
