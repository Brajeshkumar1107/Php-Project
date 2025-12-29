function showToast(message, isError = false) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.className = "toast";
    if (isError) {
        toast.classList.add("error");
    }
    toast.classList.add("show");
    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

function validateForm() {

    const formData = document.querySelector("#userForm").value;
    const nameInput = document.getElementById("name");
    const ageInput = document.getElementById("age");
    const emailInput = document.getElementById("email");

    const name = document.getElementById("name").value.trim();
    const age = document.getElementById("age").value;
    const email = document.querySelector("#email").value.trim();
    const gender = document.getElementById("gender").value;
    const submitBtn = document.getElementById("submitBtn");
    console.log("email", email);
    console.log("form", formData);

    let isValid = true;

    if (name === "" || name.length > 100) {
        isValid = false;
        nameInput.classList.add("input-invalid");
    }

    if (isNaN(age) || age < 0 || age > 120 || age === "") {
        isValid = false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "" || !emailPattern.test(email)) {
        isValid = false;
    }

    if (gender === "") {
        isValid = false;
    }

    submitBtn.disabled = !isValid;
    
    nameInput.classList.remove("input-invalid");
    return isValid;
}

function loadUsers() {
    fetch("list.php")
        .then(res => res.text())
        .then(data => {
            document.getElementById("userList").innerHTML = data;
        });
}

function submitForm() {
    const submitBtn = document.getElementById("submitBtn");
    submitBtn.disabled = true; // Disable immediately on submit

    if (!validateForm()) {
        submitBtn.disabled = false; // Re-enable if validation fails
        return false;
    }

    const form = document.getElementById("userForm");
    const data = new FormData(form);
    const url = document.getElementById("userId").value ? "ajax/edit.php" : "ajax/submit.php";

    fetch(url, {
        method: "POST",
        body: data
    }).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    }).then(text => {
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            // Not JSON, treat as error
            showToast("An unexpected error occurred.", true);
            submitBtn.disabled = false;
            return;
        }

        if (data.error) {
            showToast(data.error, true);
            submitBtn.disabled = false;
            return;
        }

        // Success
        form.reset();
        document.getElementById("userId").value = "";
        document.querySelector("button[type='submit']").textContent = "Submit";
        validateForm(); // Re-validate after reset
    
        loadUsers();

        showToast(data.success || "Operation completed successfully!");
        submitBtn.disabled = true; // Re-enable after success
    }).catch(() => {
        showToast("An error occurred. Please try again.", true);
        submitBtn.disabled = true; // Re-enable on error
    });

    return false;
}

function editUser(id) {
    fetch("ajax/get.php?id=" + id)
        .then(res => res.json())
        .then(data => {
            document.getElementById("userId").value = data.id;
            document.getElementById("name").value = data.name;
            document.getElementById("email").value = data.email;
            document.getElementById("age").value = data.age;
            document.getElementById("gender").value = data.gender;
            document.querySelector("button[type='submit']").textContent = "Update";
            validateForm(); // Validate after loading data
        });
}

function deleteUser(id) {
    fetch("ajax/delete.php?id=" + id)
        .then(() => loadUsers());

    showToast("User deleted successfully!");
}

window.onload = function() {
    loadUsers();
    // Add event listeners for validation
    document.getElementById("name").addEventListener("input", validateForm);
    document.getElementById("email").addEventListener("input", validateForm);
    document.getElementById("age").addEventListener("input", validateForm);
    document.getElementById("gender").addEventListener("change", validateForm);
    validateForm(); // Initial validation
};
