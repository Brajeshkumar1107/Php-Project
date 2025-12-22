
function loadUsers() {
    fetch("list.php")
        .then(res => re.s.text())
        .then(data => {
            document.getElementById("userList").innerHTML = data;
        });
}

function submitForm() {
    const form = document.getElementById("userForm");
    const name = document.getElementById("name").value.trim();
    const age = document.getElementById("age").value;
    const email = document.getElementById("email").value.trim();

    if (name === "" ) {
        alert("Please enter a valid name.");
        return false;
    }

    if (isNaN(age) || age < 0) {
        alert("Please enter a valid age.");
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "" || !emailPattern.test(email)) {
        alert("Please enter a valid email address");
        return false;
    }
    const data = new FormData(form);
    const url = document.getElementById("userId").value ? "ajax/edit.php" : "ajax/submit.php";

    fetch(url, {
        method: "POST",
        body: data
    }).then(() => {
        form.reset();
        document.getElementById("userId").value = "";
        document.querySelector("button[type='submit']").textContent = "Submit";
        loadUsers();
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
        });
}

function deleteUser(id) {
    fetch("ajax/delete.php?id=" + id)
        .then(() => loadUsers());
}

window.onload = loadUsers;
