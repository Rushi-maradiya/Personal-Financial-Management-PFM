const loginBtn = document.getElementById('login-btn');
const signupBtn = document.getElementById('signup-btn');
const loginForm = document.getElementById('login-form');
const signupForm = document.getElementById('signup-form');

loginBtn.addEventListener('click', function() {
    loginForm.classList.add('active');
    signupForm.classList.remove('active');
    signupForm.style.display = 'none';
    loginForm.style.display = 'block';

    loginBtn.classList.add('active');
    signupBtn.classList.remove('active');
});

signupBtn.addEventListener('click', function() {
    signupForm.classList.add('active');
    loginForm.classList.remove('active');
    loginForm.style.display = 'none';
    signupForm.style.display = 'block';

    signupBtn.classList.add('active');
    loginBtn.classList.remove('active');
});


$('#floatingRePassword').on('input', function() 
{
    let password = $('input[name="Rpass"]').val();
    let rePassword = $(this).val();

    if (rePassword !== password) {
        $('#password-warning').text('Passwords do not match!').show();
        $('#Registerbutton').hide();
    } else {
        $('#password-warning').hide();
        $('#Registerbutton').show();

    }
}
)


$('#floatingPasswordReg').on('input', function() 
{
    let password = $(this).val();
    let rePassword =$('input[name="Rrepass"]').val();
    
    if (rePassword !== password) {
        $('#password-warning').text('Passwords do not match!').show();
        $('#Registerbutton').hide();
    } else {
        $('#password-warning').hide();
        $('#Registerbutton').show();

    }
}
)
 

$(document).ready(function () {
    $('#floatingEmailReg').on('input', function () {
        var email = $(this).val();
        var emailWarning = $('#email-warning');
        var registerButton = $('#Registerbutton');
        var passwordField = $('#passs');
        var rePasswordField = $('#repasss');

        if (email === "") {
            emailWarning.hide();
            registerButton.show();
            passwordField.show();
            rePasswordField.show();
            return;
        }

        $.ajax({
            url: 'Index.php',
            type: 'POST',
            data: {
                email: email,
                action: 'check_email'
            },
            success: function (response) {
                console.log("Response from server:", response);

                if (response.trim() === "exists") {
                    emailWarning.text("This email is already registered.").show();
                    registerButton.hide();
                    passwordField.hide();
                    rePasswordField.hide();
                } else if (response.trim() === "available") {
                    emailWarning.hide();
                    registerButton.show();
                    passwordField.show();
                    rePasswordField.show();
                }
            },
            error: function () {
                emailWarning.text("Error checking email").css("color", "orange").show();
                registerButton.hide();
                passwordField.hide();
                rePasswordField.hide();
            }
        });
    });
});
