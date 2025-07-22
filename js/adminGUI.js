document.getElementById('toggleAuditHistory').addEventListener('click', function() {
    var auditTable = document.getElementById('auditTable');
    if (auditTable.style.display === 'none' || auditTable.style.display === '') {
        auditTable.style.display = 'block';  // Show the table
        userListTable.style.display = 'none';
    } else {
        auditTable.style.display = 'none';  // Hide the table
    }
});

// Show User List on button click
document.getElementById('showUserListBtn').addEventListener('click', function() {
    var userListTable = document.getElementById('userListTable');
    if (userListTable.style.display === 'none' || userListTable.style.display === '') {
        userListTable.style.display = 'block';  // Show the user list
        auditTable.style.display = 'none';
    } else {
        userListTable.style.display = 'none';  // Hide the user list
    }
});



function showContent(contentId) {
    // Hide all content sections
    var sections = document.querySelectorAll('.content-section');
    sections.forEach(function (section) {
        section.style.display = 'none';
    });

    // Show the selected content
    document.getElementById(contentId).style.display = 'block';

    // Reset all nav links to default color and remove 'active' class
    var navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(function (link) {
        link.classList.remove('active');
    });

    // Add 'active' class to the clicked link
    var activeLink = document.querySelector(`.sidebar .nav-link[onclick="showContent('${contentId}')"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

// Make 'User Login History' active by default when page loads
window.onload = function () {
    showContent('auditTable');  // Default content to show
};

$(document).ready(function () {
    $('#floatingEmailReg').on('input', function () {
        var email = $(this).val();  // Get the value of the email field
        var emailWarning = $('#email-warning'); // Element to show error warning
        var passwordField = $('#passss'); // Password field
        var rePasswordField = $('#repassss'); // Re-password field
        var registerButton = $('#adduser'); // Register button element

        // If the email field is empty, hide the warning and show the register button
        if (email === "") {
            emailWarning.hide();  // Hide the warning
            passwordField.show();  // Show the password field
            rePasswordField.show();  // Show the re-password field
            registerButton.prop('disabled', false);  // Enable the button
            return;
        }

        // Send an AJAX request to check if the email is already taken
        $.ajax({
            url: 'adminGUI.php', // The PHP file that handles the email check
            type: 'POST',
            data: { email: email },  // Send the email to the server
            success: function (response) {
                console.log(response);  // Debugging line to check the response from PHP

                // Handle the response based on whether the email exists or not
                if (response.trim() === "exists") {
                    emailWarning.text("This email is already registered.").show(); // Show warning
                    passwordField.hide();  // Hide the password field
                    rePasswordField.hide();  // Hide the re-password field
                    registerButton.prop('disabled', true);  // Disable the register button
                } else if (response.trim() === "available") {
                    emailWarning.hide();  // Hide the warning
                    passwordField.show();  // Show the password field
                    rePasswordField.show();  // Show the re-password field
                    registerButton.prop('disabled', false);  // Enable the register button
                }
            },
            error: function () {
                emailWarning.text("Error checking email").css("color", "orange").show(); // Show error message
                registerButton.prop('disabled', true);  // Disable the button in case of an error
                passwordField.hide();  // Hide the password field in case of an error
                rePasswordField.hide(); // Hide the re-password field in case of an error
            }
        });
    });
});
