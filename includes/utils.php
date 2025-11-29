<?php
function validate_username($username) {
    return preg_match("/^[a-zA-Z][a-zA-Z0-9_\.]{2,19}$/", $username);
}

function validate_password($password) {
    return preg_match("/^(?=.*[0-9]).{8,}$/", $password);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

?>