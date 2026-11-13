/*
 * script.js - Things that happen in the browser
 * Member 9: [Name] - JavaScript
 * JavaScript never talks to the database. PHP does that.
 */

/* ---------- 1. Highlight the current page in the menu ---------- */
const currentPage = window.location.pathname.split("/").pop() || "index.php";
document.querySelectorAll(".navbar nav a").forEach(function (link) {
    if (link.getAttribute("href") === currentPage) {
        link.classList.add("active");
    }
});

/* ---------- 2. Search events on the home page ---------- */
const searchBox = document.getElementById("searchBox");

if (searchBox) {
    searchBox.addEventListener("input", function () {
        const text = searchBox.value.toLowerCase();
        const cards = document.querySelectorAll(".event-card");
        let shown = 0;

        cards.forEach(function (card) {
            const match = card.textContent.toLowerCase().includes(text);
            card.hidden = !match;
            if (match) shown++;
        });

        document.getElementById("noResults").hidden = shown > 0;
    });
}

/* ---------- 3. Check the registration form before sending ---------- */
const registerForm = document.getElementById("registerForm");

if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        const errorBox = document.getElementById("formError");
        let message = "";

        // Remove old red borders
        registerForm.querySelectorAll(".invalid").forEach(function (field) {
            field.classList.remove("invalid");
        });

        const eventId = document.getElementById("event_id");
        const name = document.getElementById("student_name");
        const studentId = document.getElementById("student_id");
        const email = document.getElementById("email");
        const phone = document.getElementById("phone");

        if (eventId.value === "") {
            message = "Please choose an event.";
            eventId.classList.add("invalid");
        } else if (name.value.trim() === "") {
            message = "Please enter your name.";
            name.classList.add("invalid");
        } else if (studentId.value.trim() === "") {
            message = "Please enter your student ID.";
            studentId.classList.add("invalid");
        } else if (!email.value.includes("@") || !email.value.includes(".")) {
            message = "Please enter a valid email address.";
            email.classList.add("invalid");
        } else if (!/^[0-9]{10}$/.test(phone.value.trim())) {
            message = "Phone number must be exactly 10 digits.";
            phone.classList.add("invalid");
        }

        if (message !== "") {
            event.preventDefault();          // stop the form being sent
            errorBox.textContent = message;
            errorBox.hidden = false;
        }
    });
}

/* ---------- 4. Ask before deleting ---------- */
document.querySelectorAll(".delete-form").forEach(function (form) {
    form.addEventListener("submit", function (event) {
        if (!confirm("Delete this registration?")) {
            event.preventDefault();
        }
    });
});
