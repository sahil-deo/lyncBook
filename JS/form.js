let eyeOpen = document.getElementById('eye-open')
let eyeClose = document.getElementById('eye-close')
let password = document.getElementById('password')
let confirmPassword = document.getElementById('confirm-password')

function ShowPassword(){
    eyeOpen.style.display = "inline-block";
    eyeClose.style.display = "none";
    password.type = "text";
    if(confirmPassword) 
    confirmPassword.type = "text";
}

function HidePassword(){
    eyeOpen.style.display = "none";
    eyeClose.style.display = "inline-block";
    password.type = "password";
    if(confirmPassword) confirmPassword.type = "password";

}