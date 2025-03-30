const form = document.getElementById('form')
const username = document.getElementById('username-input')
const email = document.getElementById('email-input')
const password = document.getElementById('password-input')
const repassword = document.getElementById('repassword-input')
const error_message = document.getElementById('error-message')

form.addEventListener('submit',(e) => {
    let errors = []
    if(username) {
        errors = getSignupFormErrors(username.value,email.value,password.value,repassword.value)
    }
    else {
        errors = getLoginFormErrors(email.value,password.value)
    }
    if(errors.length > 0) {
        e.preventDefault()
        error_message.innerText = errors.join('. ');
    }
})
function getSignupFormErrors(usernameout, emailout, passwordout, repasswordout) {
    let errors = [];

    if (!usernameout.trim()) { 
        errors.push('Username is required');
        if (username) username.parentElement.classList.add('incorrect'); 
    }

    if (!emailout.trim()) { 
        errors.push('E-mail is required');
        if (email) email.parentElement.classList.add('incorrect');
    }

    if (!passwordout.trim()) {
        errors.push('Password is required');
        if (password) password.parentElement.classList.add('incorrect');
    }
    if(passwordout.trim() !== repasswordout.trim()) {
        errors.push('Passwords do not match')
        if(repassword) repassword.parentElement.classList.add('incorrect')
        }
    return errors;
}

function getLoginFormErrors(emailout,passwordout) {
    let errors = [];
    if (!emailout.trim()) { 
        errors.push('E-mail is required');
        if (email) email.parentElement.classList.add('incorrect');
    }

    if (!passwordout.trim()) {
        errors.push('Password is required');
        if (password) password.parentElement.classList.add('incorrect');
    }
    return errors;
}

